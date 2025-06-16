<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\EveningClass;
use App\Models\AcademicClasses;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationBadgeTooltip = 'The number of students';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 1; // Lower value means it appears first;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->label('Nickname')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('age')
                            ->required()
                            ->numeric()
                            ->minValue(3)
                            ->maxValue(25),
                        Toggle::make('is_active')
                            ->label('Active Student')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger'),
                            // ->columnSpanFull(),
                    ]),

                Forms\Components\Select::make('academic_classes_id')
                    ->label('Academic Class')
                    ->options(AcademicClasses::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('evening_classes')
                    ->label('Evening Classes')
                    ->multiple()
                    ->relationship('eveningClasses', 'name') // relationship must be defined in model
                    ->searchable(false) // disable search bar
                    ->preload(), // load semua data awal-awal
                // ->required(),

                Section::make('Diagnosis & Skills')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Textarea::make('diagnosis')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('reading_skills')
                            ->label('Reading Skills'),
                        Forms\Components\RichEditor::make('numeracy')
                            ->label('Numeracy'),
                        Forms\Components\RichEditor::make('writing_skills')
                            ->label('Handwriting Skills'),
                    ]),

                Section::make('Development & Behavior')
                    ->schema([
                        Forms\Components\RichEditor::make('school_readiness')
                            ->label('School Readiness Assessment'),
                        Forms\Components\RichEditor::make('motor_skills')
                            ->label('Motor Skills Development'),
                        Forms\Components\RichEditor::make('behaviour_skills')
                            ->label('Behavioral Skills'),
                        Forms\Components\RichEditor::make('sensory_issues')
                            ->label('Sensory Issues'),
                        Forms\Components\RichEditor::make('communication_skills')
                            ->label('Communication Skills'),
                    ]),

                Section::make('Medical & Additional Info')
                    ->schema([
                        Forms\Components\Textarea::make('other_medical_conditions')
                            ->label('Other Medical Conditions'),
                        Forms\Components\Textarea::make('tips_and_tricks')
                            ->label('Teaching Tips & Strategies')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('export')
                    ->label('Export All')
                    ->icon('heroicon-o-document')
                    ->action(function () {
                        return Excel::download(new StudentsExport, 'all-students-' . now()->format('d-m-Y') . '.xlsx');
                    })
                    ->color('success')
                    ->tooltip('Export all records to Excel'),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Nickname')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('age')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('academicClass.name') // relationship
                    ->sortable()
                    // ->alignCenter()
                    ->searchable(),
                // TextColumn::make('diagnosis')
                //     ->limit(30)
                //     ->tooltip(fn($record) => $record->diagnosis),
                // TextColumn::make('reading_skills')
                //     ->badge()
                //     ->color(fn(string $state): string => match ($state) {
                //         'beginner' => 'danger',
                //         'intermediate' => 'warning',
                //         'advanced' => 'success',
                //     }),
                // TextColumn::make('writing_skills')
                //     ->badge()
                //     ->color(fn(string $state): string => match ($state) {
                //         'beginner' => 'danger',
                //         'intermediate' => 'warning',
                //         'advanced' => 'success',
                //     }),
                // TextColumn::make('school_readiness')
                //     ->limit(30),
                // DIRECT TOGGLE COLUMN - NO NEED FOR SEPARATE ACTION
                ToggleColumn::make('is_active')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('academic_classes_id')
                    ->label('Academic Class')
                    ->relationship('academicClass', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->indicateUsing(function (array $state): ?string {
                        if (empty($state['values']))
                            return null;
                        return 'Class: ' . AcademicClasses::find($state['values'])
                            ->pluck('name')
                            ->join(', ');
                    }),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active students')
                    ->falseLabel('Inactive students'),
                // Tables\Filters\SelectFilter::make('reading_skills')
                //     ->options([
                //         'beginner' => 'Beginner Reading',
                //         'intermediate' => 'Intermediate Reading',
                //         'advanced' => 'Advanced Reading',
                //     ]),
                // Tables\Filters\SelectFilter::make('writing_skills')
                //     ->options([
                //         'beginner' => 'Beginner Writing',
                //         'intermediate' => 'Intermediate Writing',
                //         'advanced' => 'Advanced Writing',
                //     ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->successNotificationTitle('Student was updated successfully'),
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle('Student was deleted successfully'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make()
                    //     ->successNotificationTitle('Students were deleted successfully'),
                    Tables\Actions\BulkAction::make('activate')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn($records) => $records->each->update(['is_active' => false])),
                    Tables\Actions\BulkAction::make('exportSelected')
                        ->label('Export Selected')
                        ->icon('heroicon-o-document')
                        ->action(function ($records) {
                            return Excel::download(new StudentsExport($records), 'selected-students-' . now()->format('d-m-Y') . '.xlsx');
                        })
                        ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'), // View Only
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}