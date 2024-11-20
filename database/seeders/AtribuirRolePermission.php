<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AtribuirRolePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

$adminRole = Role::findByName('Administrador');
$adminRole->givePermissionTo('editar valores de contas', 'visualizar valores de contas', 'adicionar novas contas', 'visualizar inscrições específicas');



    }
}
