<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdditionalSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skip user creation if already exists to avoid duplicates
        if (!User::where('email', 'manager@centre.com')->exists()) {
            User::create([
                'name' => 'Centre Manager',
                'email' => 'manager@centre.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'preferred_language' => 'en',
            ]);
        }

        // Create additional teachers
        $additionalTeachers = [
            [
                'first_name' => 'Karim',
                'last_name' => 'Bennani',
                'phone' => '+212600000007',
                'joined_date' => '2024-02-15',
                'subjects' => ['Mathematics', 'Physics'],
            ],
            [
                'first_name' => 'Leila',
                'last_name' => 'Chraibi',
                'phone' => '+212600000008',
                'joined_date' => '2024-01-25',
                'subjects' => ['Chemistry', 'Biology'],
            ],
            [
                'first_name' => 'Hassan',
                'last_name' => 'Mourad',
                'phone' => '+212600000009',
                'joined_date' => '2024-03-01',
                'subjects' => ['English Language', 'French'],
            ],
        ];

        foreach ($additionalTeachers as $teacherData) {
            $teacher = Teacher::create([
                'first_name' => $teacherData['first_name'],
                'last_name' => $teacherData['last_name'],
                'phone' => $teacherData['phone'],
                'joined_date' => $teacherData['joined_date'],
            ]);

            // Assign subjects
            $subjectIds = [];
            foreach ($teacherData['subjects'] as $subjectName) {
                $subject = Subject::where('name_en', $subjectName)->first();
                if ($subject) {
                    $subjectIds[] = $subject->id;
                }
            }
            if (!empty($subjectIds)) {
                $teacher->subjects()->sync($subjectIds);
            }
        }

        // Create additional students with grades and notes
        $additionalStudents = [
            [
                'first_name' => 'Sara',
                'last_name' => 'El Fassi',
                'phone' => '+212600000010',
                'grade' => '11',
                'joined_date' => '2024-03-12',
                'notes' => 'Excellent in sciences',
                'subjects' => ['Mathematics', 'Physics', 'Chemistry'],
            ],
            [
                'first_name' => 'Mehdi',
                'last_name' => 'Zeroual',
                'phone' => '+212600000011',
                'grade' => '10',
                'joined_date' => '2024-03-08',
                'notes' => 'Needs help with languages',
                'subjects' => ['Mathematics', 'English Language', 'French'],
            ],
            [
                'first_name' => 'Nadia',
                'last_name' => 'Bouazza',
                'phone' => '+212600000012',
                'grade' => '12',
                'joined_date' => '2024-03-15',
                'notes' => 'Preparing for baccalaureate',
                'subjects' => ['Mathematics', 'Physics', 'Chemistry', 'Biology'],
            ],
            [
                'first_name' => 'Rachid',
                'last_name' => 'Tazi',
                'phone' => '+212600000013',
                'grade' => '9',
                'joined_date' => '2024-03-18',
                'notes' => 'New student, good potential',
                'subjects' => ['Mathematics', 'French'],
            ],
            [
                'first_name' => 'Lina',
                'last_name' => 'Mansouri',
                'phone' => '+212600000014',
                'grade' => '11',
                'joined_date' => '2024-03-20',
                'notes' => 'Very motivated',
                'subjects' => ['Physics', 'Chemistry', 'Biology'],
            ],
        ];

        foreach ($additionalStudents as $studentData) {
            $student = Student::create([
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name'],
                'phone' => $studentData['phone'],
                'grade' => $studentData['grade'],
                'joined_date' => $studentData['joined_date'],
                'notes' => $studentData['notes'],
            ]);

            // Assign subjects
            $subjectIds = [];
            foreach ($studentData['subjects'] as $subjectName) {
                $subject = Subject::where('name_en', $subjectName)->first();
                if ($subject) {
                    $subjectIds[] = $subject->id;
                }
            }
            if (!empty($subjectIds)) {
                $student->subjects()->sync($subjectIds);
            }
        }

        // Create additional classes with names using actual teacher objects
        $karim = Teacher::where('first_name', 'Karim')->first();
        $leila = Teacher::where('first_name', 'Leila')->first();
        $hassan = Teacher::where('first_name', 'Hassan')->first();

        $additionalClasses = [
            [
                'teacher_id' => $karim->id,
                'subject_id' => 1, // Mathematics
                'name' => 'Advanced Mathematics - Grade 11',
            ],
            [
                'teacher_id' => $karim->id,
                'subject_id' => 2, // Physics
                'name' => 'Physics Fundamentals - Grade 10',
            ],
            [
                'teacher_id' => $leila->id,
                'subject_id' => 3, // Chemistry
                'name' => 'Chemistry Lab - Grade 12',
            ],
            [
                'teacher_id' => $leila->id,
                'subject_id' => 4, // Biology
                'name' => 'Biology Advanced - Grade 11',
            ],
            [
                'teacher_id' => $hassan->id,
                'subject_id' => 5, // English Language
                'name' => 'English Conversation - All Grades',
            ],
        ];

        $createdClasses = [];
        foreach ($additionalClasses as $classData) {
            $createdClasses[] = Classes::create($classData);
        }

        // Get student objects
        $sara = Student::where('first_name', 'Sara')->first();
        $mehdi = Student::where('first_name', 'Mehdi')->first();
        $nadia = Student::where('first_name', 'Nadia')->first();
        $rachid = Student::where('first_name', 'Rachid')->first();
        $lina = Student::where('first_name', 'Lina')->first();

        // Assign students to classes
        $createdClasses[0]->students()->attach([$sara->id, $nadia->id]); // Advanced Mathematics
        $createdClasses[1]->students()->attach([$mehdi->id, $rachid->id]); // Physics Fundamentals
        $createdClasses[2]->students()->attach([$sara->id, $nadia->id, $lina->id]); // Chemistry Lab
        $createdClasses[3]->students()->attach([$sara->id, $nadia->id, $lina->id]); // Biology Advanced
        $createdClasses[4]->students()->attach([$mehdi->id, $rachid->id]); // English Conversation

        $this->command->info('Additional sample data seeded successfully!');
        $this->command->info('Total Students: ' . Student::count());
        $this->command->info('Total Teachers: ' . Teacher::count());
        $this->command->info('Total Classes: ' . Classes::count());
    }
}
