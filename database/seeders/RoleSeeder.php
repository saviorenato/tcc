<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (!Role::where('name', 'Super Admin')->first()) {
            Role::create([
                'name' => 'Super Admin',
            ]);
        }

        if (!Role::where('name', 'Admin')->first()) {
            $admin = Role::create([
                'name' => 'Admin',
            ]);
        } else {
            $admin = Role::where('name', 'Admin')->first();
        }

        // Cadastrar permissão para o papel
        $admin->givePermissionTo([

            'index-user',
            'create-user',
            'edit-user',
            'edit-user-password',
            'destroy-user',

            'index-transaction',
            'create-transaction',
            'edit-transaction',
            'destroy-transaction',

            'index-tax',
            'pay-tax',
            'destroy-tax',

            'index-ticker',
            'create-ticker',
            'edit-ticker',
            'destroy-ticker',

            'index-role',
            'create-role',
            'edit-role',
            'destroy-role',

            'index-role-permission',
            'update-role-permission',
        ]);

        // Remover a permissão de acesso
        // $admin->revokePermissionTo([
        //     'update-role-permission',
        // ]);

        if (!Role::where('name', 'User')->first()) {
            $user = Role::create(['name' => 'User']);
        } else {
            $user = Role::where('name', 'User')->first();
        }

        // Cadastrar permissão para o papel
        $user->givePermissionTo([
            'index-user',
            'show-user',

            'index-transaction',
            'create-transaction',
            'edit-transaction',
            'destroy-transaction',

            'index-tax',
            'pay-tax',
            'destroy-tax',

        ]);

    }
}
