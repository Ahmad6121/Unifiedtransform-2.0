<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminUserSeeder::class,
            SchoolSessionSeeder::class,
            SemesterSeeder::class,
            SchoolClassSeeder::class,
            SectionSeeder::class,
            CourseSeeder::class,

            // Seeders الجديدة
            BookSeeder::class,
            BookIssueSeeder::class,
            InvoiceSeeder::class,
            PaymentSeeder::class,
            StaffSeeder::class,
            UserSeeder::class,
            StudentParentInfoSeeder::class,
            StudentAcademicInfoSeeder::class,
            AcademicSettingSeeder::class,
        ]);

    }
}
