<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'saviorenato@gmail.com')->first()) {
            $superAdmin = User::create([
                'name' => 'Sávio',
                'email' => 'saviorenato@gmail.com',
                'password' => Hash::make('123456a', ['rounds' => 12])
            ]);

            // Atribuir papel para ao usuário
            $superAdmin->assignRole('Super Admin');
        }

        if (!User::where('email', 'tina@teste.com')->first()) {
            $admin = User::create([
                'name' => 'Tina',
                'email' => 'tina@teste.com',
                'password' => Hash::make('123456a', ['rounds' => 12])
            ]);

            // Atribuir papel para ao usuário
            $admin->assignRole('Admin');
        }

        if (!User::where('email', 'silvana@teste.com')->first()) {
            $teacher = User::create([
                'name' => 'Silvana',
                'email' => 'silvana@teste.com',
                'password' => Hash::make('123456a', ['rounds' => 12])
            ]);

            // Atribuir papel para ao usuário
            $teacher->assignRole('User');
        }
    }
}
