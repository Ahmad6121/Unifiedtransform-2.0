<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolSession;
use App\Models\Semester;
use App\Models\SchoolClass;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $session = SchoolSession::orderByDesc('id')->first();
        if (!$session) return;

        // سنربط المواد بكل فصل
        $semesters = Semester::where('session_id', $session->id)->get();
        if ($semesters->isEmpty()) return;

        $coreCourses = ['Mathematics', 'Science', 'English', 'Arabic', 'History'];

        foreach (SchoolClass::where('session_id', $session->id)->get() as $class) {
            foreach ($semesters as $semester) {
                foreach ($coreCourses as $cname) {
                    Course::firstOrCreate(
                        [
                            'course_name' => $cname,
                            'class_id'    => $class->id,
                            'semester_id' => $semester->id,
                            'session_id'  => $session->id,
                        ],
                        [
                            'course_type' => 'Core',
                        ]
                    );
                }
            }
        }
    }
}
