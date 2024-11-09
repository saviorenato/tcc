<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            ['title'=> 'Listar usuários', 'name' => 'index-user'],
            ['title'=> 'Visualizar usuário', 'name' => 'show-user'],
            ['title'=> 'Cadastrar usuário', 'name' => 'create-user'],
            ['title'=> 'Editar usuário', 'name' => 'edit-user'],
            ['title'=> 'Editar senha do usuário', 'name' => 'edit-user-password'],
            ['title'=> 'Apagar usuário', 'name' => 'destroy-user'],

            ['title'=> 'Listar transações', 'name' => 'index-transaction'],
            ['title'=> 'Cadastrar transações', 'name' => 'create-transaction'],
            ['title'=> 'Editar transações', 'name' => 'edit-transaction'],
            ['title'=> 'Apagar transações', 'name' => 'destroy-transaction'],

            ['title'=> 'Listar taxas', 'name' => 'index-tax'],
            ['title'=> 'Visualizar taxas', 'name' => 'pay-tax'],
            ['title'=> 'Apagar taxas', 'name' => 'destroy-tax'],

            ['title'=> 'Listar tickers', 'name' => 'index-ticker'],
            ['title'=> 'Visualizar tickers', 'name' => 'show-ticker'],
            ['title'=> 'Cadastrar tickers', 'name' => 'create-ticker'],
            ['title'=> 'Editar tickers', 'name' => 'edit-ticker'],
            ['title'=> 'Apagar tickers', 'name' => 'destroy-ticker'],

            ['title'=> 'Listar regras', 'name' => 'index-rule'],
            ['title'=> 'Visualizar regras', 'name' => 'show-rule'],
            ['title'=> 'Cadastrar regras', 'name' => 'create-rule'],
            ['title'=> 'Editar regras', 'name' => 'edit-rule'],
            ['title'=> 'Apagar regras', 'name' => 'destroy-rule'],

            ['title' => 'Listar papéis', 'name' => 'index-role'],
            ['title' => 'Cadastrar papel', 'name' => 'create-role'],
            ['title' => 'Editar papel', 'name' => 'edit-role'],
            ['title' => 'Apagar papel', 'name' => 'destroy-role'],

            ['title' => 'Listar permissões do papel', 'name' => 'index-role-permission'],
            ['title' => 'Editar permissão do papel', 'name' => 'update-role-permission'],

            ['title'=> 'Listar páginas', 'name' => 'index-permission'],
            ['title'=> 'Visualizar página', 'name' => 'show-permission'],
            ['title'=> 'Cadastrar página', 'name' => 'create-permission'],
            ['title'=> 'Editar página', 'name' => 'edit-permission'],
            ['title'=> 'Apagar página', 'name' => 'destroy-permission'],
        ];

        foreach ($permissions as $permission) {
            $existingPermission = Permission::where('name', $permission['name'])->first();

            if (!$existingPermission) {
                Permission::create([
                    'title' => $permission['title'],
                    'name' => $permission['name'],
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
