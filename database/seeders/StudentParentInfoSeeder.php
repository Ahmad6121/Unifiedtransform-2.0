<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class StudentParentInfoSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();

        if ($students->isEmpty()) {
            $this->command->warn('⚠️ لا يوجد طلاب — شغّل UserSeeder أولاً.');
            return;
        }

        $columns = Schema::getColumnListing('student_parent_infos');
        $now = now();
        $count = 0;

        foreach ($students as $student) {
            $data = [
                'student_id'      => $student->id,
                'father_name'     => 'Father of ' . ($student->last_name ?? $student->first_name),
                'father_phone'    => '07' . random_int(700000000, 799999999),
                'mother_name'     => 'Mother of ' . ($student->last_name ?? $student->first_name),
                'mother_phone'    => '07' . random_int(800000000, 899999999),
                'guardian_name'   => 'Guardian of ' . ($student->last_name ?? $student->first_name),
                'guardian_phone'  => '07' . random_int(600000000, 699999999),
                'parent_address'  => 'Amman, Jordan', // حل العمود الإجباري
                'occupation'      => 'Employee',
                'created_at'      => $now,
                'updated_at'      => $now,
            ];

            // فلترة الأعمدة المتاحة
            $filtered = array_intersect_key($data, array_flip($columns));

            DB::table('student_parent_infos')->updateOrInsert(
                ['student_id' => $student->id],
                $filtered
            );

            $count++;
        }

        $this->command->info("✅ StudentParentInfoSeeder: تم إنشاء/تحديث بيانات أولياء الأمور لـ {$count} طالب.");
    }
}
