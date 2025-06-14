<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Teacher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\EveningClass;
use Filament\Resources\Resource;
use App\Models\EveningClassCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EveningClassResource\Pages;
use App\Filament\Resources\EveningClassResource\RelationManagers;

class EveningClassResource extends Resource
{
    protected static ?string $model = EveningClass::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationBadgeTooltip = 'The number of co-curricular classes';
    protected static ?string $navigationGroup = 'Class Management';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Co-curricular Classes';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->options(EveningClassCategory::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->label('Teacher')
                    ->options(Teacher::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // relationship dari table pivot kena setup model,migration,relation kena betul
                Tables\Columns\TextColumn::make('students.name')
                    ->label('Students Name')
                    ->formatStateUsing(fn($state, $record) => $record->students->pluck('name')->join('<br>'))
                    ->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Activity Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                // Category filter
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),

                // Teacher filter
                Tables\Filters\SelectFilter::make('teacher')
                    ->relationship('teacher', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Class Evening was deleted successfully'),
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
            'index' => Pages\ListEveningClasses::route('/'),
            'create' => Pages\CreateEveningClass::route('/create'),
            'edit' => Pages\EditEveningClass::route('/{record}/edit'),
        ];
    }

}
