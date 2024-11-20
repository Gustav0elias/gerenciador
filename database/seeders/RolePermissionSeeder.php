<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'editar valores de contas',
            'visualizar valores de contas',
            'adicionar novas contas',
            'visualizar inscrições específicas',
            'modulo usuario'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $master = Role::firstOrCreate(['name' => 'Master']);
        Role::firstOrCreate(['name' => 'Administrador']);
        Role::firstOrCreate(['name' => 'Usuário Comum']);

        $master->syncPermissions(Permission::all());
    }
}
