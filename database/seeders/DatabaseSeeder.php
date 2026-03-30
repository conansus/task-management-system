<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 2 admins
        $admins = [];
        $admins[] = User::create([
            'name'     => 'Admin One',
            'email'    => 'admin1@test.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
        $admins[] = User::create([
            'name'     => 'Admin Two',
            'email'    => 'admin2@test.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Create 5 staff
        $staffs = [];
        for ($i = 1; $i <= 5; $i++) {
            $staffs[] = User::create([
                'name'     => "Staff $i",
                'email'    => "staff$i@test.com",
                'password' => Hash::make('password'),
                'role'     => 'staff',
            ]);
        }

        // Task data pool to pick from randomly
        $titles = [
            'Prepare Monthly Report', 'Fix Login Bug', 'Update User Dashboard',
            'Write Unit Tests', 'Review Pull Request', 'Deploy to Staging',
            'Database Backup', 'Send Client Invoice', 'Update Documentation',
            'Refactor Auth Module', 'Design New Landing Page', 'Fix Payment Gateway',
            'Setup CI/CD Pipeline', 'Migrate Old Data', 'Conduct Code Review',
            'Optimize Slow Queries', 'Handle Support Ticket', 'Update Dependencies',
            'Write API Docs', 'Test Mobile Responsiveness',
        ];

        $priorities = ['low', 'medium', 'high'];
        $statuses   = ['pending', 'in_progress', 'complete'];

        foreach ($titles as $i => $title) {
            $admin      = $admins[array_rand($admins)];
            $staff      = $staffs[array_rand($staffs)];
            $isAssigned = rand(0, 1); // 50/50 chance of being assigned

            Task::create([
                'title'       => $title,
                'description' => "Description for: $title",
                'priority'    => $priorities[array_rand($priorities)],
                'status'      => $isAssigned ? $statuses[array_rand($statuses)] : 'not_assigned',
                'created_by'  => $admin->id,
                'assigned_to' => $isAssigned ? $staff->id : null,
                'assigned_by' => $isAssigned ? $admin->id : null,
            ]);
        }
    }
}
