<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendVKMessage;

class TestVKChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vk:test-chat {message?} {--peer-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправить тестовое сообщение в ВК групповой чат';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = $this->argument('message') ?? 'Тестовое сообщение от ' . config('app.name') . ' в ' . now()->format('d.m.Y H:i');
        $peerId = (int) ($this->option('peer-id') ?: config('services.vk.chat_id'));
        
        $this->info("Отправляю сообщение в ВК чат (peer_id: {$peerId})...");
        $this->info("Сообщение: {$message}");
        
        // Отправляем сообщение в групповой чат синхронно для тестирования
        try {
            $job = new SendVKMessage($message, null, $peerId);
            $job->handle();
            
            $this->info('✅ Сообщение отправлено синхронно!');
        } catch (\Exception $e) {
            $this->error('❌ Ошибка отправки: ' . $e->getMessage());
        }
        
        $this->info('Проверьте логи для результата отправки: storage/logs/laravel.log');
        
        return Command::SUCCESS;
    }
}
