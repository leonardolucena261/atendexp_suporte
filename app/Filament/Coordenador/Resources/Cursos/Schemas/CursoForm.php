<?php

namespace App\Filament\Coordenador\Resources\Cursos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CursoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificação')->columns(2)->schema([
                    TextInput::make('nome_curso')->label('Nome do curso')->required()->maxLength(255),
                    Select::make('cod_coordenacao')
                    ->label('Coordenação')
                    ->relationship('coordenacao', 'nome_coordenacao'),
                ]),
                Section::make('Conteúdo')->schema([
                    Textarea::make('informacoes_curso')->label('Informações')->rows(2)->columnSpanFull(),
                    Textarea::make('ementa')->label('Ementa')->rows(4)->columnSpanFull(),
                    Textarea::make('objetivo')->label('Objetivo')->rows(3)->columnSpanFull(),
                    Textarea::make('conteudo_programatico')->label('Conteúdo programático')->rows(5)->columnSpanFull(),
                    Textarea::make('metodologia')->label('Metodologia')->rows(3)->columnSpanFull(),
                    Textarea::make('recursos_utilizados')->label('Recursos utilizados')->rows(3)->columnSpanFull(),
                    Textarea::make('sistematica_avaliacao')->label('Sistemática de avaliação')->rows(3)->columnSpanFull(),
                    Textarea::make('referencias')->label('Referências')->rows(3)->columnSpanFull(),
                ]),
            ]);
    }
}
