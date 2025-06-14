<?php

namespace App\Filament\Resources\EveningClassResource\Pages;

use App\Filament\Resources\EveningClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEveningClass extends EditRecord
{
    protected static string $resource = EveningClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotificationTitle('Class Evening was deleted successfully'),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Class Evening successfully updated';
    }
}
