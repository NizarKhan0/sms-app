<?php

namespace App\Filament\Resources\AcademicClassesResource\Pages;

use App\Filament\Resources\AcademicClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicClasses extends ListRecords
{
    protected static string $resource = AcademicClassesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
