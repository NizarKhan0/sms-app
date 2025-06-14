<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotificationTitle('Teacher deleted successfully'),
        ];
    }

    // Redirect to index page after creation
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Alternative: Redirect to edit page after creation
    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    // }

    // In EditTeacher
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Teacher updated successfully';
    }
}
