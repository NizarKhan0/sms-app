<?php

namespace App\Filament\Resources\EveningClassCategoryResource\Pages;

use App\Filament\Resources\EveningClassCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEveningClassCategories extends ManageRecords
{
    protected static string $resource = EveningClassCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->successNotificationTitle('Category was created successfully'),
        ];
    }

}