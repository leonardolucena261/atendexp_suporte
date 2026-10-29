<?php

namespace App\Filament\Coordenador\Resources\Cursos\Pages;

use App\Filament\Coordenador\Resources\Cursos\CursoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCursos extends ListRecords
{
    protected static string $resource = CursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
