<?php

namespace App\Filament\Coordenador\Resources\Cursos\RelationManagers;

use App\Models\CursoCoordenador;
use App\Models\User;
use App\Services\CoordenadorService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoordenadoresRelationManager extends RelationManager
{
    protected static string $relationship = 'coordenadores';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')
                ->label('Coordenador')
                ->options(User::query()->orderBy('name')->pluck('name', 'id'))
                ->searchable()->preload()->required(),
            DatePicker::make('data_inicio')
                ->label('Início do mandato')
                ->default(now())
                ->required(),
            Textarea::make('observacao')->label('Observação')->rows(2)->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('data_inicio')
            ->columns([
                TextColumn::make('user.name')->label('Coordenador')->searchable(),
                TextColumn::make('data_inicio')->label('Início')->date('d/m/Y'),
                TextColumn::make('data_fim')
                    ->label('Fim')
                    ->date('d/m/Y')
                    ->placeholder('ATIVO')          // null = mandato vigente
                    ->badge()
                    ->color(fn ($state) => $state ? 'gray' : 'success'),
                TextColumn::make('observacao')->label('Observação')->limit(40)->toggleable(),
            ])
            ->recordActions([
                Action::make('encerrar')
                    ->label('Encerrar mandato')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (CursoCoordenador $record) => $record->data_fim === null)
                    ->schema([
                        DatePicker::make('data_fim')
                            ->label('Data de encerramento')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (array $data, CursoCoordenador $record) {
                        app(CoordenadorService::class)
                            ->encerrar($record, Carbon::parse($data['data_fim']));

                        Notification::make()->title('Mandato encerrado com sucesso.')->success()->send();
                    }),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('Escalar coordenador')
                    ->using(function (array $data, RelationManager $livewire): CursoCoordenador {
                        $curso = $livewire->getOwnerRecord();
                        $user  = User::findOrFail($data['user_id']);

                        // ⭐ Toda a regra (fechar mandato anterior, gerar UUID) fica no Service
                        $mandato = app(CoordenadorService::class)->escalar(
                            $curso,
                            $user,
                            Carbon::parse($data['data_inicio']),
                            $data['observacao'] ?? null,
                        );

                        // 📲 Passo 5 (WhatsApp) — descomente quando a notificação existir:
                        // $user->notify(new \App\Notifications\ConviteCoordenador($curso, $mandato));

                        return $mandato;
                    }),
            ]);
    }
}
