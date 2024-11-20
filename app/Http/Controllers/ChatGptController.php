<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatGPTController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $client = new Client();

        $url = 'https://api.openai.com/v1/chat/completions';
        $question = $request->input('question');

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $question],
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $answer = $data['choices'][0]['message']['content'];

            return response()->json([
                'question' => $question,
                'answer' => $answer,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao se comunicar com o ChatGPT: ' . $e->getMessage(),
            ], 500);
        }
    }
}
