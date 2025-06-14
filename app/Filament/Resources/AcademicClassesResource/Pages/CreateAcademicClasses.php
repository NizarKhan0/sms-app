<?php

namespace App\Filament\Resources\AcademicClassesResource\Pages;

use App\Filament\Resources\AcademicClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAcademicClasses extends CreateRecord
{
    protected static string $resource = AcademicClassesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Class successfully created';
    }
}