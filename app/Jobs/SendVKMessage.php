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
    protected $peerId;
    protected $isGroupChat;

    /**
     * Create a new job instance.
     */
    public function __construct($message, $userId = null, $peerId = null)
    {
        $this->message = $message;
        $this->userId = $userId ?? config('services.vk.user_id');
        $this->peerId = $peerId;
        $this->isGroupChat = $peerId !== null;
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
            $params = [
                'access_token' => $token,
                'v' => $version,
                'message' => $this->message,
                'random_id' => random_int(1, 999999999),
            ];

            if ($this->isGroupChat) {
                $params['peer_id'] = $this->peerId;
            } else {
                $params['user_id'] = $this->userId;
            }

            $response = Http::timeout(30)
                ->asForm()
                ->post('https://api.vk.com/method/messages.send', $params);

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
