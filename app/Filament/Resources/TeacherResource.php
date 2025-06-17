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

                // TextInput::make('phone')
                //     ->required()
                //     ->tel()
                //     ->maxLength(20),
                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required()
                    ->maxLength(20)
                    ->placeholder('0123456789'),

                Forms\Components\Textarea::make('address')
                    // ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('user_id')
                    ->label('User Account')
                    // ->relationship('user', 'email') //ini untuk load semua
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'email',
                        modifyQueryUsing: function (Builder $query, ?Model $record) {
                            // Dapatkan semua user_id yang sudah di-assign ke teacher lain
                            $assignedUserIds = Teacher::query()
                                ->when($record, function ($query) use ($record) {
                                // Kecualikan teacher yang sedang diedit
                                $query->where('id', '!=', $record->id);
                            })
                                ->whereNotNull('user_id')
                                ->pluck('user_id')
                                ->toArray();

                            // Filter hanya user yang belum di-assign
                            return $query->whereNotIn('id', $assignedUserIds);
                        }
                    )
                    ->searchable()
                    ->preload()
                    // ->required()
                    ->unique(ignoreRecord: true) // Tambahkan ini
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
                                'super-admin' => 'Super Admin',
                                'admin' => 'Admin',
                                'teacher' => 'Teacher',
                            ])
                            ->default('teacher')
                            ->required()
                    ])
                    ->visible(fn() => auth()->user()->isSuperAdmin()) // Only super-admin can assign users
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone / WhatsApp')
                    ->formatStateUsing(function ($state) {
                        if (!$state)
                            return null;

                        // Clean to digits only
                        $number = preg_replace('/[^0-9]/', '', $state);

                        // Handle different input formats
                        if (str_starts_with($number, '0')) {
                            $number = substr($number, 1);
                        } elseif (str_starts_with($number, '60')) {
                            $number = substr($number, 2);
                        }

                        $formatted = '+60' . $number;
                        return $formatted;
                    })
                    ->url(function ($record) {
                        $number = preg_replace('/[^0-9]/', '', $record->phone);

                        if (str_starts_with($number, '0')) {
                            $number = substr($number, 1);
                        } elseif (str_starts_with($number, '60')) {
                            $number = substr($number, 2);
                        }

                        return 'https://wa.me/60' . $number;
                    })
                    ->openUrlInNewTab(),

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
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->isSuperAdmin()),
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

    public static function canCreate(): bool
    {
        $user = auth()->user();

        // Admins can create many
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }
        // Allow create only if the user hasn't created a teacher yet
        return Teacher::where('user_id', $user->id)->doesntExist();
    }
    public static function canEdit(Model $record): bool
    {
        return auth()->user()->isSuperAdmin() || auth()->user()->isAdmin() || $record->user_id === auth()->id();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->isSuperAdmin();
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
