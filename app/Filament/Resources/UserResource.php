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
    protected static ?string $navigationBadgeTooltip = 'The number of users';
    // custom label sidebar
    public static function getLabel(): string
    {
        $user = auth()->user();

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return 'Users';
        }

        return 'Profile';
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // If role teacher & admin just show them
        if (!auth()->user()->isSuperAdmin()) {
            $query->whereIn('role', ['teacher', 'admin']);
        }
        return $query;
    }
    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return static::getModel()::count();
        }

        return static::getModel()::whereIn('role', ['teacher', 'admin'])->count();
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
                        'super-admin' => 'Super Admin',
                        'admin' => 'Admin',
                        'teacher' => 'Teacher',
                    ])
                    ->visible(fn() => auth()->user()->isSuperAdmin())
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('User was deleted successfully')
                    ->visible(fn() => auth()->user()->isSuperAdmin()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->isSuperAdmin()),
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
        return auth()->user()->isSuperAdmin() || auth()->user()->isAdmin() || $record->id === auth()->id();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    public static function canCreate(): bool
    {
        return auth()->user()->isSuperAdmin();
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
