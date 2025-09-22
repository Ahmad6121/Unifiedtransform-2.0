<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);

        Permission::firstOrCreate(['name' => 'promote students']);

        Permission::firstOrCreate(['name' => 'create notices']);
        Permission::firstOrCreate(['name' => 'view notices']);
        Permission::firstOrCreate(['name' => 'edit notices']);
        Permission::firstOrCreate(['name' => 'delete notices']);

        Permission::firstOrCreate(['name' => 'create events']);
        Permission::firstOrCreate(['name' => 'view events']);
        Permission::firstOrCreate(['name' => 'edit events']);
        Permission::firstOrCreate(['name' => 'delete events']);

        Permission::firstOrCreate(['name' => 'create syllabi']);
        Permission::firstOrCreate(['name' => 'view syllabi']);
        Permission::firstOrCreate(['name' => 'edit syllabi']);
        Permission::firstOrCreate(['name' => 'delete syllabi']);

        Permission::firstOrCreate(['name' => 'create routines']);
        Permission::firstOrCreate(['name' => 'view routines']);
        Permission::firstOrCreate(['name' => 'edit routines']);
        Permission::firstOrCreate(['name' => 'delete routines']);

        Permission::firstOrCreate(['name' => 'create exams']);
        Permission::firstOrCreate(['name' => 'view exams']);
        Permission::firstOrCreate(['name' => 'delete exams']);
        Permission::firstOrCreate(['name' => 'create exams rule']);
        Permission::firstOrCreate(['name' => 'view exams rule']);
        Permission::firstOrCreate(['name' => 'edit exams rule']);
        Permission::firstOrCreate(['name' => 'delete exams rule']);
        Permission::firstOrCreate(['name' => 'view exams history']);

        Permission::firstOrCreate(['name' => 'create grading systems']);
        Permission::firstOrCreate(['name' => 'view grading systems']);
        Permission::firstOrCreate(['name' => 'edit grading systems']);
        Permission::firstOrCreate(['name' => 'delete grading systems']);
        Permission::firstOrCreate(['name' => 'create grading systems rule']);
        Permission::firstOrCreate(['name' => 'view grading systems rule']);
        Permission::firstOrCreate(['name' => 'edit grading systems rule']);
        Permission::firstOrCreate(['name' => 'delete grading systems rule']);

        Permission::firstOrCreate(['name' => 'take attendances']);
        Permission::firstOrCreate(['name' => 'view attendances']);
        Permission::firstOrCreate(['name' => 'update attendances type']);

        Permission::firstOrCreate(['name' => 'submit assignments']);
        Permission::firstOrCreate(['name' => 'create assignments']);
        Permission::firstOrCreate(['name' => 'view assignments']);

        Permission::firstOrCreate(['name' => 'save marks']);
        Permission::firstOrCreate(['name' => 'view marks']);

        Permission::firstOrCreate(['name' => 'create school sessions']);

        Permission::firstOrCreate(['name' => 'create semesters']);
        Permission::firstOrCreate(['name' => 'view semesters']);
        Permission::firstOrCreate(['name' => 'edit semesters']);
        Permission::firstOrCreate(['name' => 'assign teachers']);
        Permission::firstOrCreate(['name' => 'create courses']);
        Permission::firstOrCreate(['name' => 'view courses']);
        Permission::firstOrCreate(['name' => 'edit courses']);

        Permission::firstOrCreate(['name' => 'view academic settings']);
        Permission::firstOrCreate(['name' => 'update marks submission window']);
        Permission::firstOrCreate(['name' => 'update browse by session']);

        Permission::firstOrCreate(['name' => 'create classes']);
        Permission::firstOrCreate(['name' => 'view classes']);
        Permission::firstOrCreate(['name' => 'edit classes']);
        // Permission::create(['name' => 'delete classes']);

        Permission::firstOrCreate(['name' => 'create sections']);
        Permission::firstOrCreate(['name' => 'view sections']);
        Permission::firstOrCreate(['name' => 'edit sections']);
        // Permission::create(['name' => 'delete sections']);


    }
}
//
//
//namespace Database\Seeders;
//
//use Illuminate\Database\Seeder;
//use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;
//use Spatie\Permission\PermissionRegistrar;
//
//class PermissionSeeder extends Seeder
//{
//    public function run(): void
//    {
//        // 1️⃣ إعادة تعيين الكاش
//        app()[PermissionRegistrar::class]->forgetCachedPermissions();
//
//        // 2️⃣ إنشاء كل الصلاحيات
//        $permissions = [
//            // Users management
//            'create users', 'view users', 'edit users', 'delete users',
//            // Students & promotions
//            'promote students',
//            // Notices
//            'create notices', 'view notices', 'edit notices', 'delete notices',
//            // Events
//            'create events', 'view events', 'edit events', 'delete events',
//            // Syllabi
//            'create syllabi', 'view syllabi', 'edit syllabi', 'delete syllabi',
//            // Routines
//            'create routines', 'view routines', 'edit routines', 'delete routines',
//            // Exams & grading
//            'create exams', 'view exams', 'delete exams',
//            'create exams rule', 'view exams rule', 'edit exams rule', 'delete exams rule',
//            'view exams history',
//            'create grading systems', 'view grading systems', 'edit grading systems', 'delete grading systems',
//            // Attendance
//            'take attendances', 'view attendances', 'update attendances type',
//            // Assignments
//            'submit assignments', 'create assignments', 'view assignments',
//            // Marks
//            'save marks', 'view marks',
//            // Academic setup
//            'create school sessions', 'create semesters', 'view semesters', 'edit semesters', 'assign teachers',
//            'create courses', 'view courses', 'edit courses',
//            'view academic settings', 'update marks submission window', 'update browse by session',
//            'create classes', 'view classes', 'edit classes',
//            'create sections', 'view sections', 'edit sections',
//            // Library & accounting
//            'manage library', 'manage payments'
//        ];
//
//        foreach ($permissions as $perm) {
//            Permission::firstOrCreate(['name' => $perm]);
//        }
//
//        // 3️⃣ إنشاء الأدوار
//        $roles = [
//            'admin' => Permission::all()->pluck('name')->toArray(), // كل الصلاحيات
//            'accountant' => ['manage payments', 'view students', 'view users'],
//            'librarian' => ['manage library', 'view students'],
//            'teacher' => [
//                'take attendances', 'view attendances', 'save marks', 'view marks',
//                'submit assignments', 'view students', 'view classes', 'view courses',
//                'view routines', 'view syllabi'
//            ],
//            'student' => ['view marks', 'submit assignments', 'view routines', 'view syllabi'],
//            'parent' => ['view marks', 'view routines', 'view notices'],
//        ];
//
//        foreach ($roles as $roleName => $rolePermissions) {
//            $role = Role::firstOrCreate(['name' => $roleName]);
//            $role->syncPermissions($rolePermissions);
//        }
//    }
//}
