<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@pln.id'],
            [
                'name' => 'Administrator PLN',
                'password' => \Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Operator
        User::updateOrCreate(
            ['email' => 'operator@pln.id'],
            [
                'name' => 'Operator Lapangan',
                'password' => \Hash::make('password'),
                'role' => 'operator',
            ]
        );

        // Manager
        User::updateOrCreate(
            ['email' => 'manager@pln.id'],
            [
                'name' => 'Manager UP3',
                'password' => \Hash::make('password'),
                'role' => 'manager',
            ]
        );

        $this->call([
            KriteriaSeeder::class,
            PlnSampleSeeder::class,
        ]);
    }
}
