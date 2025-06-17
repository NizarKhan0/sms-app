<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Teacher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\EveningClassCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EveningClassCategoryResource\Pages;
use App\Filament\Resources\EveningClassCategoryResource\RelationManagers;

class EveningClassCategoryResource extends Resource
{
    protected static ?string $model = EveningClassCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Class Management';
    // protected static bool $shouldRegisterNavigation = false; // disable default navigation
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Co-curricular Types';
    protected static ?string $navigationBadgeTooltip = 'The number of co-curricular types';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->unique(
                    table: EveningClassCategory::class,
                    column: 'name',
                    ignoreRecord: true // Allow same name when editing existing record
                )
                ->validationMessages([
                    'unique' => 'This category name already exists'
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Category was deleted successfully'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEveningClassCategories::route('/'),
        ];
    }
}
