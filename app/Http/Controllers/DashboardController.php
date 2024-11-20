<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        $contasCount = Conta::count();

        $usersCount = User::count();

        $roles = Role::all();

        $permissions = Permission::all();

        $pendentesCount = Conta::where('status', 'Pendente')->count();
        $pagasCount = Conta::where('status', 'Pago')->count();
        $atrasadasCount = Conta::where('status', 'Atrasado')->count();

        return response()->json([
            'contasCount' => $contasCount,
            'usersCount' => $usersCount,
            'roles' => $roles->pluck('name'),
            'permissions' => $permissions->pluck('name'),
            'status' => [
                'pendentes' => $pendentesCount,
                'pagas' => $pagasCount,
                'atrasadas' => $atrasadasCount,
            ]
        ]);
    }

    public function getAuthenticatedUserDashboardData()
    {
        $user = JWTAuth::user();
        $contas = Conta::where('user_id', $user->id)->get();

        $userContasCount = $contas->count();

        $pendentesCount = $contas->where('status', 'Pendente')->count();
        $pagasCount = $contas->where('status', 'Pago')->count();
        $atrasadasCount = $contas->where('status', 'Atrasado')->count();

        return response()->json([
            'contasCount' => $userContasCount,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'status' => [
                'pendentes' => $pendentesCount,
                'pagas' => $pagasCount,
                'atrasadas' => $atrasadasCount,
            ]
        ]);
    }
}
