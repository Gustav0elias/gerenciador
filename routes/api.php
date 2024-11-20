<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\GlobalConfigurationController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/global-configuration', [GlobalConfigurationController::class, 'getConfiguration']);
Route::put('/global-configuration', [GlobalConfigurationController::class, 'updateBackgroundColor']);
Route::middleware(['auth:api'])->group(function () {
    Route::get('/contas', [ContaController::class, 'index'])  -> middleware('permission:visualizar valores de contas'); #middleware('permission:visualizar_valores_de_contas'); #->middleware('permission:visualizar valores de contas'); #middleware('role:Master'); #middleware('permission:visualizar_valores_de_contas');
    Route::post('/contas', [ContaController::class, 'store'])->middleware('permission:adicionar novas contas'); #middleware('role:Master');
    Route::get('contas/usuario', [ContaController::class, 'indexForUser']) -> middleware('permission:visualizar inscrições específicas');  // Para as contas do usuário autenticado
    Route::get('/contas/{conta}', [ContaController::class, 'show'])-> middleware('permission:visualizar inscrições específicas'); #middleware('role:Master'); #middleware('permission:visualizar_conta_especifica');
    Route::put('/contas/{conta}', [ContaController::class, 'update'])->middleware('permission:editar valores de contas'); #middleware('role:Master'); #middleware('permission:editar valores de contas');
    Route::delete('/contas/{conta}', [ContaController::class, 'destroy'])-> middleware('role:Master');
    Route::post('/roles', [RolePermissionController::class, 'createRole'])->middleware('permission:modulo usuario');
    Route::post('/roles/assign-permissions', [RolePermissionController::class, 'assignPermissionsToRole'])->middleware('role:Master');
    Route::get('/permissions', [RolePermissionController::class, 'getPermissions'])->middleware('role:Master');
    Route::get('/roles', [RolePermissionController::class, 'getRolesWithPermissions'])->middleware('permission:modulo usuario');
    Route::post('/roles/remove-permission', [RolePermissionController::class, 'removePermissionFromRole'])->middleware('role:Master');
    Route::post('/users/assign-role', [RolePermissionController::class, 'assignRoleToUser'])->middleware('role:Master');
    Route::post('/ask-chatgpt', [ChatGPTController::class, 'ask'])->middleware('role:Master,Administrador');
    Route::get('/users', [AuthController::class, 'getUsers'])-> middleware('permission:modulo usuario');
    Route::delete('users/{id}', [AuthController::class, 'deleteUser']) -> middleware('permission:modulo usuario');

    Route::put('/users/{id}/update', [AuthController::class, 'updateUser'])-> middleware('permission:modulo usuario');
    Route::get('/consulta-cep/{cep}', [CepController::class, 'consultaCep'])->middleware('role:Master,Administrador');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/unassign-role', [RolePermissionController::class, 'unassignRoleFromUser'])->middleware('role:Master');
    Route::get('/dashboard', [DashboardController::class, 'getDashboardData']);
    Route::get('/dashboard-user', [DashboardController::class, 'getAuthenticatedUserDashboardData']);


});
