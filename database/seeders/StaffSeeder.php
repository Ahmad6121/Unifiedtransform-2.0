<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\SchoolSession;
use Carbon\Carbon;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $session = SchoolSession::first();

        if (!$session) return;

        $staffMembers = [
            [
                'first_name' => 'Ali',
                'last_name' => 'Ahmad',
                'email' => 'ali@example.com',
                'phone' => '0790001111',
                'job_title' => 'Teacher',
                'salary_type' => 'fixed',
                'base_salary' => 500,
                'join_date' => Carbon::now()->subMonths(3),
                'status' => 'active',
                'session_id' => $session->id,
            ],
            [
                'first_name' => 'Mona',
                'last_name' => 'Khaled',
                'email' => 'mona@example.com',
                'phone' => '0790002222',
                'job_title' => 'Accountant',
                'salary_type' => 'fixed',
                'base_salary' => 600,
                'join_date' => Carbon::now()->subMonths(1),
                'status' => 'active',
                'session_id' => $session->id,
            ],
        ];

        foreach ($staffMembers as $member) {
            Staff::firstOrCreate(['email' => $member['email']], $member);
        }
    }
}
