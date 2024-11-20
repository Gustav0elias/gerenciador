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
        // Validação das credenciais
        $credentials = $request->only('email', 'password');

        try {
            // Tentativa de autenticar o usuário e gerar o token JWT
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }

            // Após o login, obtenha o usuário atual
            $user = JWTAuth::user();
            $role = $user->getRoleNames()->first(); // Obtenha o papel do usuário
            $permissions = $user->getAllPermissions()->pluck('name'); // Obtenha as permissões do usuário

            return response()->json([
                'token' => $token, // O token JWT gerado
                'role' => $role,    // O papel do usuário
                'permissions' => $permissions, // As permissões do usuário
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Erro ao gerar o token'], 500);
        }
    }

    // Método para registrar um novo usuário
    public function register(Request $request)
    {
        // Validação dos dados do usuário
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Criação do usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografando a senha
        ]);

        // Retornando o usuário criado (sem a senha) e uma mensagem de sucesso
        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'user' => $user,
        ], 201);
    }

    // Método para obter todos os usuários
// Método para obter todos os usuários com seus papéis
public function getUsers()
{
    // Carrega os usuários com a relação de papéis
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

    // Salvar as alterações
    $user->save();

    // Retornar a resposta com os dados atualizados
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
            JWTAuth::invalidate(JWTAuth::getToken()); // Invalidando o token atual
            return response()->json(['message' => 'Logout bem-sucedido.']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Falha ao tentar fazer logout'], 500);
        }
    }


}
