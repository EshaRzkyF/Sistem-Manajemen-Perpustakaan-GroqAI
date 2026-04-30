<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Throwable;

class GroqService
{
    protected string $apiKey;

    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

    protected string $model = 'llama-3.1-8b-instant';

    public function __construct()
    {
        $this->apiKey = (string) config('services.groq.key');
    }

    public function ask(string $prompt): array
    {
        return $this->sendChatRequest([
            [
                'role' => 'user',
                'content' => $prompt,
            ],
        ]);
    }

    public function recommendLibrary(array $libraryData): array
    {
        $prompt = "Anda adalah asisten manajemen perpustakaan.\n"
            . "Analisis data berikut dan berikan:\n"
            . "1. Buku populer berdasarkan peminjaman.\n"
            . "2. Saran pengelolaan stok buku.\n"
            . "3. Rekomendasi operasional perpustakaan.\n\n"
            . 'Data perpustakaan: ' . json_encode($libraryData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $this->sendChatRequest([
            [
                'role' => 'system',
                'content' => 'Anda adalah konsultan perpustakaan yang memberikan jawaban ringkas, praktis, dan berbasis data.',
            ],
            [
                'role' => 'user',
                'content' => $prompt,
            ],
        ]);
    }

    protected function sendChatRequest(array $messages): array
    {
        if ($this->apiKey === '') {
            return [
                'success' => false,
                'status' => 500,
                'data' => null,
                'content' => null,
                'error' => 'GROQ_API_KEY belum dikonfigurasi.',
            ];
        }

        try {
            $response = Http::acceptJson()
                ->withToken($this->apiKey)
                ->timeout(30)
                ->post($this->baseUrl, [
                    'model' => $this->model,
                    'messages' => $messages,
                    'temperature' => 0.2,
                ]);

            $data = $response->json();

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $data,
                'content' => $data['choices'][0]['message']['content'] ?? null,
                'error' => $data['error']['message'] ?? null,
            ];
        } catch (ConnectionException|Throwable $exception) {
            return [
                'success' => false,
                'status' => 500,
                'data' => null,
                'content' => null,
                'error' => $exception->getMessage(),
            ];
        }
    }
}
