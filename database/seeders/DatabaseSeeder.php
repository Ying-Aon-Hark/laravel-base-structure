<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['Admin', 'Editor', 'User'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(
                [
                    'name' => $roleName,
                    'description' => "This is the {$roleName} role.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Fetch all roles
        $allRoles = Role::all();

        // Create users and assign roles randomly
        User::firstOrCreate(
            [
                'firstname' => 'Admin',
                'lastname' => 'User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'status' => 'active',
                'company' => 'Admin Company',
                'country' => 'Admin Country',
                'email_verified_at' => now(),
            ],
            [
                'password' => bcrypt('test1234'), // Set a default password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        )->roles()->attach(
            $allRoles->where('name', 'Admin')->pluck('id')->toArray(),
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        User::factory(10)->create()->each(function ($user) use ($allRoles) {
            $user->roles()->attach(
                $allRoles->random(rand(1, 3))->pluck('id')->toArray() // Correctly pluck IDs
            );
            $user->roles()->updateExistingPivot(
                $allRoles->random()->id,
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        });
    }
}
