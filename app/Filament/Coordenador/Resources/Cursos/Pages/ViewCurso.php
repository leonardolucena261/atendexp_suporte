<?php

namespace App\Filament\Coordenador\Resources\Cursos\Pages;

use App\Filament\Coordenador\Resources\Cursos\CursoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCurso extends ViewRecord
{
    protected static string $resource = CursoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
