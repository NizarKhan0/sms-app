<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Teacher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TeacherResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TeacherResource\RelationManagers;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationBadgeTooltip = 'The number of teachers';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 2; // Lower value means it appears first;
    // protected static ?string $navigationLabel = 'Teachers';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // TextInput::make('email')
                //     ->email()
                //     ->required()
                //     ->unique(
                //         table: Teacher::class,
                //         ignoreRecord: true
                //     )
                //     ->maxLength(255),

                TextInput::make('phone')
                    ->required()
                    ->tel()
                    ->maxLength(20),

                Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('user_id')
                    ->label('User Account')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->confirmed(),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->required(),
                        Forms\Components\Select::make('role')
                            ->options([
                                'teacher' => 'Teacher',
                                'admin' => 'Admin'
                            ])
                            ->default('teacher')
                            ->required()
                    ])
                    ->visible(fn() => auth()->user()->isAdmin()) // Only admins can assign users
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')->searchable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')->searchable()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Teacher was deleted successfully'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    // ▼▼▼ ADD AUTHORIZATION METHODS HERE ▼▼▼
    // public static function canEdit(Model $record): bool
    // {
    //     return auth()->user()->isAdmin() ||
    //         ($record->user_id === auth()->id());
    // }
    // yg create teacher dan admin boleh edit record
    public static function canEdit(Model $record): bool
    {
        return auth()->user()->isAdmin() || $record->user_id === auth()->id();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->isAdmin();
    }

    // public static function canCreate(): bool
    // {
    //     return auth()->user()->isAdmin();
    // }
    // ▲▲▲ END OF AUTHORIZATION METHODS ▲▲▲

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
