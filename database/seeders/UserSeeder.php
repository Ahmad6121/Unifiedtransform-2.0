<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Course;
use App\Models\AssignedTeacher;
use App\Models\Promotion;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $classes  = SchoolClass::all();
        $sections = Section::all();
        $courses  = Course::all();

        if ($classes->isEmpty() || $sections->isEmpty() || $courses->isEmpty()) {
            $this->command->warn('⚠️ لا توجد صفوف أو شعب أو مواد — تأكد من تشغيل SchoolClassSeeder, SectionSeeder, CourseSeeder أولاً.');
            return;
        }

        // 1️⃣ إنشاء معلمين لكل مادة
        foreach ($courses as $course) {
            $teacher = User::firstOrCreate(
                ['email' => 'teacher_' . $course->id . '@school.com'],
                [
                    'first_name'   => 'Teacher',
                    'last_name'    => $course->course_name,
                    'gender'       => 'male',
                    'nationality'  => 'Jordanian',
                    'phone'        => '079' . rand(1000000, 9999999),
                    'role'         => 'teacher',
                    'password'     => Hash::make('password'),

                    // الحقول الإلزامية
                    'address'      => 'Main Street',
                    'address2'     => 'N/A',
                    'city'         => 'Amman',
                    'zip'          => '11118',

                ]
            );

            // ربط المعلم بالمادة إذا لم يكن مربوط
            AssignedTeacher::firstOrCreate([
                'teacher_id' => $teacher->id,
                'course_id'  => $course->id,
                'class_id'   => $course->class_id,
                'section_id' => Section::where('class_id', $course->class_id)->inRandomOrder()->first()->id,
                'session_id' => $course->session_id,
                'semester_id'=> $course->semester_id,
            ]);
        }

        // 2️⃣ إنشاء طلاب لكل صف ولكل شعبة (5 طلاب لكل شعبة)
        foreach ($sections as $section) {
            for ($i = 1; $i <= 5; $i++) {
                $student = User::firstOrCreate(
                    ['email' => "student_{$section->id}_{$i}@school.com"],
                    [
                        'first_name'   => 'Student',
                        'last_name'    => "{$section->section_name}_{$i}",
                        'gender'       => 'male',
                        'nationality'  => 'Jordanian',
                        'phone'        => '078' . rand(1000000, 9999999),
                        'role'         => 'student',
                        'password'     => Hash::make('password'),

                        // الحقول الإلزامية
                        'address'      => 'Main Street',
                        'address2'     => 'N/A',
                        'city'         => 'Amman',
                        'zip'          => '11118',
                    ]
                );

                // 3️⃣ ربط الطالب بالصف والشعبة في جدول Promotions
                Promotion::firstOrCreate([
                    'student_id' => $student->id,
                    'class_id'   => $section->class_id,
                    'section_id' => $section->id,
                    'session_id' => $section->session_id,
                    'id_card_number'  => 'P-' . str_pad($student->id, 5, '0', STR_PAD_LEFT), // 🆕 حل المشكلة
                ]);
            }
        }

        $this->command->info('✅ تم إنشاء المعلمين، الطلاب، وربط الطلاب بالصفوف والشعب بنجاح.');
    }
}
