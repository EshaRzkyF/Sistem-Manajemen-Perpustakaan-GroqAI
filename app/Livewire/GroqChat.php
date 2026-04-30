<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\GroqService;

class GroqChat extends Component
{
    public $prompt;
    public $response;
    public $statusCode = 0;
    public $latency = 0;

    public function sendRequest(GroqService $groq)
    {
        $this->validate([
            'prompt' => 'required|min:3'
        ]);

        $start = microtime(true);

        $result = $groq->ask($this->prompt);

        $this->latency = round(microtime(true) - $start, 2);
        $this->statusCode = $result['status'];

        if ($result['success']) {
            $this->response =
                $result['data']['choices'][0]['message']['content'] ?? 'Tidak ada jawaban.';
        } else {
            $this->response = "Error: " .
                ($result['data']['error']['message'] ?? 'Gagal request');
        }
    }

    public function render()
    {
        // 🔥 INI YANG TADI SALAH
        return view('livewire.groq-chat');
    }
}
