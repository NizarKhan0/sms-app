<?php

namespace App\Filament\Resources\AcademicClassesResource\Pages;

use App\Filament\Resources\AcademicClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademicClasses extends EditRecord
{
    protected static string $resource = AcademicClassesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotificationTitle('Class deleted successfully'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Class updated successfully';
    }
}
