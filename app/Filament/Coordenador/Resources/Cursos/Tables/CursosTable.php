<?php

namespace App\Filament\Coordenador\Resources\Cursos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CursosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome_curso')->label('Curso')->searchable()->sortable(),
                TextColumn::make('coordenadorAtivo.user.name')
                    ->label('Coordenador atual')
                    ->badge()->color('success'),
                TextColumn::make('coordenadorAtivo.data_inicio')
                    ->label('Desde')
                    ->date('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(), // editar conteúdo = o workflow do coordenador
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
