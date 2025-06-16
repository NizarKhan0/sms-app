<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Teacher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicClasses;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AcademicClassesResource\Pages;
use App\Filament\Resources\AcademicClassesResource\RelationManagers;

class AcademicClassesResource extends Resource
{
    protected static ?string $model = AcademicClasses::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationBadgeTooltip = 'The number of academic classes';
    protected static ?string $navigationGroup = 'Class Management';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Academic Classes';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    // public static function getNavigationGroup(): ?string
    // {
    //     return 'Class Management';
    // }

    // public static function getNavigationSort(): ?int
    // {
    //     return 10; // Higher value, so it appears below User Management
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('teachers')
                    ->label('Teachers')
                    ->multiple()
                    ->relationship('teachers', 'name') // relationship must be defined in model
                    ->searchable(false) // disable search bar
                    ->preload() // load semua data awal-awal
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Class Name')
                    ->searchable()
                    ->sortable(),
                // relationship dari table pivot kena setup model,migration,relation kena betul
                Tables\Columns\TextColumn::make('students.name')
                    ->label('Students Name')
                    ->formatStateUsing(fn($state, $record) => $record->students->pluck('name')->join('<br>'))
                    ->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('teachers.name')
                    ->label('Teachers')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->teachers->pluck('name')->join('<br>');
                    })
                    ->html()
                    ->searchable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Class was deleted successfully'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicClasses::route('/'),
            'create' => Pages\CreateAcademicClasses::route('/create'),
            'edit' => Pages\EditAcademicClasses::route('/{record}/edit'),
        ];
    }
}