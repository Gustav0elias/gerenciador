<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CepController extends Controller
{
    public function consultaCep($cep)
    {

        if (!preg_match('/^\d{5}-?\d{3}$/', $cep)) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->failed()) {
            return response()->json(['error' => 'Falha na consulta do CEP'], 500);
        }

        $data = $response->json();

        if (isset($data['erro'])) {
            return response()->json(['error' => 'CEP não encontrado'], 404);
        }

        return response()->json($data);
    }
}
