<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Conta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $masterRole = Role::findByName('Master');
        $adminRole = Role::findByName('Administrador');
        $commonRole = Role::findByName('Usuário Comum');

        $masterUser = User::create([
            'name' => 'Master User',
            'email' => 'master@exemplo.com',
            'password' => Hash::make('senha123')
        ]);
        $masterUser->assignRole($masterRole);

        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@exemplo.com',
            'password' => Hash::make('senha123')
        ]);
        $adminUser->assignRole($adminRole);

        $commonUser = User::create([
            'name' => 'Common User',
            'email' => 'common@exemplo.com',
            'password' => Hash::make('senha123')
        ]);
        $commonUser->assignRole($commonRole);

Conta::create([
    'descricao' => 'Conta do Master',
    'valor' => 1000.00,
    'data_vencimento' => now()->addMonth(),
    'status' => 'Pendente',
    'tipo' => 'Pagar',
    'user_id' => $masterUser->id
]);

Conta::create([
    'descricao' => 'Conta do Admin',
    'valor' => 500.00,
    'data_vencimento' => now()->addWeek(),
    'status' => 'Pendente',
    'tipo' => 'Receber',
    'user_id' => $adminUser->id
]);

Conta::create([
    'descricao' => 'Conta do Usuário Comum',
    'valor' => 150.00,
    'data_vencimento' => now()->addDay(),
    'status' => 'Pendente',
    'tipo' => 'Pagar',
    'user_id' => $commonUser->id
]);

    }
}
