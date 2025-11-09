<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendVKMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($message, $userId = null)
    {
        $this->message = $message;
        $this->userId = $userId ?? config('services.vk.user_id');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $token = config('services.vk.token');
        $version = config('services.vk.api_version');

        if (!$token || !$this->userId) {
            Log::warning('VK: токен или user_id не настроены');
            return;
        }

        try {
            $response = Http::timeout(30)
                ->asForm()
                ->post('https://api.vk.com/method/messages.send', [
                    'access_token' => $token,
                    'v' => $version,
                    'user_id' => $this->userId,
                    'message' => $this->message,
                    'random_id' => random_int(1, 999999999),
                ]);

            $result = $response->json();

            if (isset($result['error'])) {
                Log::error('VK API Error: ' . json_encode($result['error']));
            } else {
                Log::info('VK message sent successfully', ['response' => $result]);
            }
        } catch (\Exception $e) {
            Log::error('VK send failed: ' . $e->getMessage());
        }
    }
}
