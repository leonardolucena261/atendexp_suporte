<?php

namespace App\Filament\Coordenador\Resources\Cursos;

use App\Filament\Coordenador\Resources\Cursos\Pages\CreateCurso;
use App\Filament\Coordenador\Resources\Cursos\Pages\EditCurso;
use App\Filament\Coordenador\Resources\Cursos\Pages\ListCursos;
use App\Filament\Coordenador\Resources\Cursos\Pages\ViewCurso;
use App\Filament\Coordenador\Resources\Cursos\RelationManagers\CoordenadoresRelationManager;
use App\Filament\Coordenador\Resources\Cursos\Schemas\CursoForm;
use App\Filament\Coordenador\Resources\Cursos\Schemas\CursoInfolist;
use App\Filament\Coordenador\Resources\Cursos\Tables\CursosTable;
use App\Models\Curso;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CursoResource extends Resource
{
    protected static ?string $model = Curso::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nome_curso';

    public static function form(Schema $schema): Schema
    {
        return CursoForm::configure($schema);
    }

    /** ⭐ O coordenador só vê os cursos que coordena HOJE */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Filament::getCurrentPanel()?->getId() === 'coordenador') {
            $query->whereHas('coordenadores', function (Builder $q) {
                $q->where('user_id', Auth::id())->whereNull('data_fim');
            });
        }

    return $query;
    }

    /** Coordenador não cria nem exclui cursos — só edita o conteúdo */
    public static function canCreate(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'atendexp';
    }

    public static function canDeleteAny(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'atendexp';
    }

    public static function canDelete($record): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'atendexp';
    }

    public static function infolist(Schema $schema): Schema
    {
        return CursoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CursosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CoordenadoresRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCursos::route('/'),
            'create' => CreateCurso::route('/create'),
            'view' => ViewCurso::route('/{record}'),
            'edit' => EditCurso::route('/{record}/edit'),
        ];
    }
}
