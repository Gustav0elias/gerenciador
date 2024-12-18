<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }

            $user = JWTAuth::user();
            $role = $user->getRoleNames()->first(); 
            $permissions = $user->getAllPermissions()->pluck('name'); 

            return response()->json([
                'token' => $token, 
                'role' => $role,   
                'permissions' => $permissions, 
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Erro ao gerar o token'], 500);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografando a senha
        ]);

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'user' => $user,
        ], 201);
    }


public function getUsers()
{
    $users = User::with('roles')->get();

    return response()->json([
        'users' => $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name'),
            ];
        }),
    ]);
}

public function updateUser(Request $request, $id)
{


    $validator = Validator::make($request->all(), [
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:users,email,' . $id,
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'Usuário não encontrado.'], 404);
    }

    if ($request->has('name')) {
        $user->name = $request->name;
    }

    if ($request->has('email')) {
        $user->email = $request->email;
    }

    $user->save();

    return response()->json([
        'message' => 'Usuário atualizado com sucesso!',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ],
    ]);
}

public function deleteUser($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'Usuário não encontrado.'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'Usuário deletado com sucesso.']);
}

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); 
            return response()->json(['message' => 'Logout bem-sucedido.']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Falha ao tentar fazer logout'], 500);
        }
    }


}
