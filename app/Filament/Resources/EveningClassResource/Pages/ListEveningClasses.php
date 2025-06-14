<?php

namespace App\Filament\Resources\EveningClassResource\Pages;

use App\Filament\Resources\EveningClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEveningClasses extends ListRecords
{
    protected static string $resource = EveningClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}