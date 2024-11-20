<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContaController extends Controller
{
    public function index(Request $request)
    {
        $query = Conta::query();

        if ($request->filled('search')) {
            $query->where('descricao', 'like', '%' . $request->search . '%')
                  ->orWhere('status', 'like', '%' . $request->search . '%')
                  ->orWhere('tipo', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $contas = $query->paginate(10);

        return response()->json($contas);
    }

    public function indexForUser(Request $request)
    {
        $user = JWTAuth::user();

        $query = Conta::where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('descricao', 'like', '%' . $request->search . '%')
                  ->orWhere('status', 'like', '%' . $request->search . '%')
                  ->orWhere('tipo', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $contas = $query->paginate(10);

        return response()->json($contas);
    }


    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date',
            'status' => 'required|in:Pendente,Pago,Atrasado',
            'tipo' => 'required|in:Pagar,Receber',
        ]);

        $conta = Conta::create([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'data_vencimento' => $request->data_vencimento,
            'status' => $request->status,
            'tipo' => $request->tipo,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Conta cadastrada com sucesso!',
            'data' => $conta
        ], 201);
    }

    public function show(Conta $conta)
    {
        return response()->json($conta);
    }

    public function update(Request $request, Conta $conta)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data_vencimento' => 'required|date',
            'status' => 'required|in:Pendente,Pago,Atrasado',
            'tipo' => 'required|in:Pagar,Receber',
        ]);



            $conta->update($request->all());

            return response()->json([
                'message' => 'Conta atualizada com sucesso!',
                'data' => $conta
            ]);



    }

    public function destroy(Conta $conta)
    {
        $conta->delete();

        return response()->json([
            'message' => 'Conta excluída com sucesso!'
        ], 200);
    }
}
