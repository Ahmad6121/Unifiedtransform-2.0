<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // تفريغ الكاش
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 👥 المستخدمين
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        Permission::firstOrCreate(['name' => 'view students']);

        // 📢 الإعلانات
        Permission::firstOrCreate(['name' => 'create notices']);
        Permission::firstOrCreate(['name' => 'view notices']);
        Permission::firstOrCreate(['name' => 'edit notices']);
        Permission::firstOrCreate(['name' => 'delete notices']);

        // 📅 الفعاليات
        Permission::firstOrCreate(['name' => 'create events']);
        Permission::firstOrCreate(['name' => 'view events']);
        Permission::firstOrCreate(['name' => 'edit events']);
        Permission::firstOrCreate(['name' => 'delete events']);

        // 📚 المواد / الصفوف / الشعب
        Permission::firstOrCreate(['name' => 'create courses']);
        Permission::firstOrCreate(['name' => 'view courses']);
        Permission::firstOrCreate(['name' => 'edit courses']);

        Permission::firstOrCreate(['name' => 'create classes']);
        Permission::firstOrCreate(['name' => 'view classes']);
        Permission::firstOrCreate(['name' => 'edit classes']);

        Permission::firstOrCreate(['name' => 'create sections']);
        Permission::firstOrCreate(['name' => 'view sections']);
        Permission::firstOrCreate(['name' => 'edit sections']);

        // 🏫 الإعدادات الأكاديمية
        Permission::firstOrCreate(['name' => 'view academic settings']);
        Permission::firstOrCreate(['name' => 'update marks submission window']);
        Permission::firstOrCreate(['name' => 'update browse by session']);

        // 📝 الواجبات والامتحانات
        Permission::firstOrCreate(['name' => 'create assignments']);
        Permission::firstOrCreate(['name' => 'view assignments']);
        Permission::firstOrCreate(['name' => 'submit assignments']);

        Permission::firstOrCreate(['name' => 'create exams']);
        Permission::firstOrCreate(['name' => 'view exams']);
        Permission::firstOrCreate(['name' => 'delete exams']);

        // ✅ العلامات
        Permission::firstOrCreate(['name' => 'save marks']);
        Permission::firstOrCreate(['name' => 'view marks']);

        // 📖 المكتبة
        Permission::firstOrCreate(['name' => 'create books']);
        Permission::firstOrCreate(['name' => 'view books']);
        Permission::firstOrCreate(['name' => 'edit books']);
        Permission::firstOrCreate(['name' => 'delete books']);
        Permission::firstOrCreate(['name' => 'issue books']);
        Permission::firstOrCreate(['name' => 'return books']);
        Permission::firstOrCreate(['name' => 'view issued books']);

        // 💵 المالية
        Permission::firstOrCreate(['name' => 'create invoices']);
        Permission::firstOrCreate(['name' => 'view invoices']);
        Permission::firstOrCreate(['name' => 'edit invoices']);
        Permission::firstOrCreate(['name' => 'delete invoices']);
        Permission::firstOrCreate(['name' => 'record payments']);
        Permission::firstOrCreate(['name' => 'view payments']);

        // 🧾 الحضور
        Permission::firstOrCreate(['name' => 'take attendances']);
        Permission::firstOrCreate(['name' => 'view attendances']);
        Permission::firstOrCreate(['name' => 'update attendances type']);

        $this->command->info('✅ PermissionSeeder: تم إنشاء كل الصلاحيات بنجاح.');
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
