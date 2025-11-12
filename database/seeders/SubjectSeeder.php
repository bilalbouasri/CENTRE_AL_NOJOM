<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'name_en' => 'Mathematics',
                'name_ar' => 'الرياضيات',
                'description' => 'Fundamental mathematics including algebra, geometry, and calculus',
            ],
            [
                'name_en' => 'Physics',
                'name_ar' => 'الفيزياء',
                'description' => 'Study of matter, energy, and their interactions',
            ],
            [
                'name_en' => 'Chemistry',
                'name_ar' => 'الكيمياء',
                'description' => 'Study of substances and their properties, reactions, and uses',
            ],
            [
                'name_en' => 'Biology',
                'name_ar' => 'الأحياء',
                'description' => 'Study of living organisms and their vital processes',
            ],
            [
                'name_en' => 'English Language',
                'name_ar' => 'اللغة الإنجليزية',
                'description' => 'English language learning and communication skills',
            ],
            [
                'name_en' => 'Arabic Language',
                'name_ar' => 'اللغة العربية',
                'description' => 'Arabic language and literature studies',
            ],
            [
                'name_en' => 'Computer Science',
                'name_ar' => 'علوم الحاسوب',
                'description' => 'Programming, algorithms, and computer systems',
            ],
            [
                'name_en' => 'History',
                'name_ar' => 'التاريخ',
                'description' => 'Study of past events and their impact on society',
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
