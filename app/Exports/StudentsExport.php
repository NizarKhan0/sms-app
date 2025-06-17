<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    // Di app/Exports/StudentsExport.php
    protected $students;

    public function __construct($students = null)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students ?: Student::with(['academicClass', 'eveningClasses'])->get();
    }
    public function headings(): array
    {
        return [
            'No.', // Changed from ID to No.
            'Full Name',
            'Nickname',
            'Age',
            'Academic Class',
            'Co-Curricular Class',
            'Diagnosis',
            'Reading Skills',
            'Writing Skills',
            'Numeracy',
            'School Readiness',
            'Motor Skills',
            'Behaviour Skills',
            'Sensory Issues',
            'Communication Skills',
            'Other Medical Conditions',
            'Teaching Tips & Tricks',
            'Active Status',
            // 'Registration Date'
        ];
    }

    public function map($student): array
    {
        // Get the current index (starts at 0)
        static $index = 0;
        $index++;

        return [
            $index, // Sequential number instead of ID
            $student->full_name,
            $student->name,
            $student->age,
            $student->academicClass->name ?? 'N/A',
            $student->eveningClasses->pluck('name')->join(', '),
            $student->diagnosis,
            ucfirst($student->reading_skills),
            ucfirst($student->writing_skills),
            $student->numeracy,
            $student->school_readiness,
            $student->motor_skills,
            $student->behaviour_skills,
            $student->sensory_issues,
            $student->communication_skills,
            $student->other_medical_conditions,
            $student->tips_and_tricks,
            $student->is_active ? 'Active' : 'Inactive',
            // $student->created_at->format('m/d/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row style
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '3490DC'],
                ],
            ],

            // Alternate row colors
            'A2:Z' . ($sheet->getHighestRow()) => [
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'F8FAFC'],
                ],
            ],

            // Center align the number column
            'A' => [
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ],

            // Wrap text for long content
            'D:M' => [
                'alignment' => [
                    'wrapText' => true,
                ],
            ],
        ];
    }
}
