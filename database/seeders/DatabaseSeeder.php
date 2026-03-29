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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $staff1 = User::create([
            'name' => 'Staff One',
            'email' => 'staff1@test.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        $staff2 = User::create([
            'name' => 'Staff Two',
            'email' => 'staff2@test.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        Task::create([
            'title' => 'Prepare Report',
            'description' => 'Monthly report',
            'priority' => 'high',
            'status' => 'pending',
            'created_by' => $admin->id,
            'assigned_to' => $staff1->id,
            'assigned_by' => $admin->id,
        ]);

        Task::create([
            'title' => 'Fix Bug',
            'description' => 'System bug fix',
            'priority' => 'medium',
            'status' => 'in_progress',
            'created_by' => $admin->id,
            'assigned_to' => $staff2->id,
            'assigned_by' => $admin->id,
        ]);

        Task::create([
            'title' => 'Unassigned Task',
            'description' => 'No one assigned yet',
            'priority' => 'low',
            'status' => 'not_assigned',
            'created_by' => $admin->id,
        ]);
    }
}
