<?php

namespace App\Filament\Coordenador\Resources\Cursos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CursoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('cod_coordenacao')
                    ->numeric(),
                TextEntry::make('nome_curso')
                    ->placeholder('-'),
                TextEntry::make('informacoes_curso')
                    ->placeholder('-'),
                TextEntry::make('ementa')
                    ->placeholder('-'),
                TextEntry::make('objetivo')
                    ->placeholder('-'),
                TextEntry::make('conteudo_programatico')
                    ->placeholder('-'),
                TextEntry::make('metodologia')
                    ->placeholder('-'),
                TextEntry::make('recursos_utilizados')
                    ->placeholder('-'),
                TextEntry::make('sistematica_avaliacao')
                    ->placeholder('-'),
                TextEntry::make('referencias')
                    ->placeholder('-'),
            ]);
    }
}
