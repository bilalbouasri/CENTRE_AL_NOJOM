<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin users
        User::factory()->create([
            'name' => 'Admin 1',
            'email' => 'admin1@centre.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'preferred_language' => 'en',
        ]);

        User::factory()->create([
            'name' => 'Admin 2',
            'email' => 'admin2@centre.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'preferred_language' => 'ar',
        ]);

        // Create subjects
        $subjects = [
            ['name_en' => 'Mathematics', 'name_ar' => 'الرياضيات'],
            ['name_en' => 'Physics', 'name_ar' => 'الفيزياء'],
            ['name_en' => 'SVT', 'name_ar' => 'علوم الحياة والأرض'],
            ['name_en' => 'French', 'name_ar' => 'الفرنسية'],
            ['name_en' => 'English', 'name_ar' => 'الإنجليزية'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        // Create teachers
        $teachers = [
            ['first_name' => 'Ahmed', 'last_name' => 'Hassan', 'phone' => '+212600000001', 'joined_date' => '2024-01-15'],
            ['first_name' => 'Fatima', 'last_name' => 'Alami', 'phone' => '+212600000002', 'joined_date' => '2024-02-01'],
            ['first_name' => 'Mohammed', 'last_name' => 'Benali', 'phone' => '+212600000003', 'joined_date' => '2024-01-20'],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

        // Assign subjects to teachers
        $teacher1 = Teacher::find(1);
        $teacher1->subjects()->attach([1, 2]); // Math and Physics

        $teacher2 = Teacher::find(2);
        $teacher2->subjects()->attach([3, 4]); // SVT and French

        $teacher3 = Teacher::find(3);
        $teacher3->subjects()->attach([5]); // English

        // Create students
        $students = [
            ['first_name' => 'Youssef', 'last_name' => 'Khalil', 'phone' => '+212600000004', 'joined_date' => '2024-03-01'],
            ['first_name' => 'Amina', 'last_name' => 'Rahmani', 'phone' => '+212600000005', 'joined_date' => '2024-03-05'],
            ['first_name' => 'Omar', 'last_name' => 'Bouzid', 'phone' => '+212600000006', 'joined_date' => '2024-03-10'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        // Assign subjects to students
        $student1 = Student::find(1);
        $student1->subjects()->attach([1, 2, 5]); // Math, Physics, English

        $student2 = Student::find(2);
        $student2->subjects()->attach([3, 4]); // SVT and French

        $student3 = Student::find(3);
        $student3->subjects()->attach([1, 2, 3, 4, 5]); // All subjects

        // Create classes
        $classes = [
            ['teacher_id' => 1, 'subject_id' => 1, 'duration_minutes' => 60, 'class_date' => '2024-03-20 10:00:00'], // Math class
            ['teacher_id' => 1, 'subject_id' => 2, 'duration_minutes' => 90, 'class_date' => '2024-03-20 14:00:00'], // Physics class
            ['teacher_id' => 2, 'subject_id' => 3, 'duration_minutes' => 120, 'class_date' => '2024-03-21 09:00:00'], // SVT class
            ['teacher_id' => 2, 'subject_id' => 4, 'duration_minutes' => 60, 'class_date' => '2024-03-21 11:00:00'], // French class
            ['teacher_id' => 3, 'subject_id' => 5, 'duration_minutes' => 90, 'class_date' => '2024-03-21 15:00:00'], // English class
        ];

        foreach ($classes as $class) {
            Classes::create($class);
        }

        // Assign students to classes
        $class1 = Classes::find(1);
        $class1->students()->attach([1, 3]); // Math class: Youssef and Omar

        $class2 = Classes::find(2);
        $class2->students()->attach([1]); // Physics class: Youssef

        $class3 = Classes::find(3);
        $class3->students()->attach([2, 3]); // SVT class: Amina and Omar

        $class4 = Classes::find(4);
        $class4->students()->attach([2, 3]); // French class: Amina and Omar

        $class5 = Classes::find(5);
        $class5->students()->attach([1, 3]); // English class: Youssef and Omar

        // Create payments
        $payments = [
            ['student_id' => 1, 'amount' => 500.00, 'payment_month' => 3, 'payment_year' => 2024, 'payment_date' => '2024-03-01'],
            ['student_id' => 2, 'amount' => 500.00, 'payment_month' => 3, 'payment_year' => 2024, 'payment_date' => '2024-03-02'],
            ['student_id' => 3, 'amount' => 250.00, 'payment_month' => 3, 'payment_year' => 2024, 'payment_date' => '2024-03-15', 'notes' => 'Half month payment'],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}
