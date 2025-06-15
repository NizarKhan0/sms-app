<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\EveningClass;
use App\Models\AcademicClasses;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Dashboard extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::count())
                ->icon('heroicon-o-users'),
            Stat::make('Total Teachers', Teacher::count())
                ->icon('heroicon-o-users'),
            Stat::make('Total Classes', AcademicClasses::count())
                ->icon('heroicon-o-rectangle-group'),
            Stat::make('Total Activity', EveningClass::count())
                ->icon('heroicon-o-rectangle-stack'),
        ];
    }
}
