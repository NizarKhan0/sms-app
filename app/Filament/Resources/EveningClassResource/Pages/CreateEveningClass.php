<?php

namespace App\Filament\Resources\EveningClassResource\Pages;

use App\Filament\Resources\EveningClassResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use App\Models\EveningClassCategory;

class CreateEveningClass extends CreateRecord
{
    protected static string $resource = EveningClassResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Class Evening successfully created';
    }

    // add category modal
    public function getHeaderActions(): array
    {
        return [
            Action::make('createCategory')
                ->label('Add Category')
                ->modalHeading('Create New Co-curricular Category')
                ->modalSubmitActionLabel('Create')
                ->form([
                    TextInput::make('name')
                        ->label('Category Name')
                        ->unique(EveningClassCategory::class, 'name')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    EveningClassCategory::create($data);
                    $this->dispatch('categoryCreated'); // optional: to refresh select field
                }),
        ];
    }

}