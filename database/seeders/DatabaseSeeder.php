<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // لو عندك صلاحيات/أدمن جاهزة أبقها هنا
            PermissionSeeder::class,
            AdminUserSeeder::class,


            SchoolSessionSeeder::class,
            SemesterSeeder::class,
            SchoolClassSeeder::class,
            SectionSeeder::class,
            CourseSeeder::class,
        ]);
    }
}
