<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

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

    // In CreateTeacher
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Teacher successfully created';
    }

}
