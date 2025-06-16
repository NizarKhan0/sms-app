<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    // custom label sidebar
    public static function getLabel(): string
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return 'Users';
        }

        return 'Profile';
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // If user is teacher, show only their own record
        if (!auth()->user()->isAdmin()) {
            $query->where('id', auth()->id());
        }
        // If admin, return all
        return $query;
    }
    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return static::getModel()::count();
        }

        return null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'teacher' => 'Teacher'
                    ])
                    ->visible(fn() => auth()->user()->isAdmin())
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->confirmed()
                    ->hint('Leave empty if you don\'t want to change the password.')
                    ->dehydrated(fn($state) => filled($state)),

                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->hint('Leave empty if you don\'t want to change the password.')
                    ->dehydrated(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('role'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    // public static function shouldRegisterNavigation(): bool
    // {
    //     return auth()->user()->isAdmin();
    // }
    // ▼▼▼ ADD AUTHORIZATION METHODS HERE ▼▼▼
    public static function canEdit(Model $record): bool
    {
        return auth()->user()->isAdmin() || $record->id === auth()->id();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function canCreate(): bool
    {
        return auth()->user()->isAdmin();
    }
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}