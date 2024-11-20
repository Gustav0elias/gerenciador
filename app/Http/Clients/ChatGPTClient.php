<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;


class ChatGPTClient
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function askQuestion($question)
    {
        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo', // Atualizado para o modelo atual
                'messages' => [
                    ['role' => 'user', 'content' => $question]
                ],
                'max_tokens' => 150,
                'temperature' => 0.7,
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        $body = json_decode($response->getBody(), true);

        return $body['choices'][0]['message']['content'] ?? 'Desculpe, não consegui entender sua pergunta.';
    }
}
