<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendVKMessage;
use App\Jobs\SendContactEmail;

class TestNotificationsAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifications {message?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тестирует отправку уведомлений во все каналы: Email, ВК личные сообщения и ВК чат';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = $this->argument('message') ?? 'Тестовое уведомление от ' . config('app.name') . ' в ' . now()->format('d.m.Y H:i');
        
        $this->info('🚀 Тестирую отправку уведомлений во все каналы...');
        $this->info("📝 Сообщение: {$message}");
        $this->newLine();
        
        // Тестовые данные для письма
        $testData = [
            'name' => 'Тестовый Пользователь',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'test@example.com',
            'message' => $message,
            'service' => 'Тестирование уведомлений',
            'page_url' => 'https://example.com/test',
            'page_title' => 'Тестовая страница'
        ];
        
        // 1. Email уведомление
        try {
            $this->info('📧 1. Отправка Email уведомления...');
            $emailsString = env('CONTACT_EMAIL', env('ADMIN_EMAIL', 'it@sumnikoff.ru'));
            $adminEmails = array_filter(array_map('trim', explode(',', $emailsString)));
            
            SendContactEmail::dispatch($testData, $adminEmails);
            $this->info("   ✅ Email добавлен в очередь для: " . implode(', ', $adminEmails));
        } catch (\Exception $e) {
            $this->error("   ❌ Ошибка Email: " . $e->getMessage());
        }
        
        // 2. ВК личные сообщения
        try {
            $this->info('👤 2. Отправка в ВК личные сообщения...');
            $userId = config('services.vk.user_id');
            
            SendVKMessage::dispatch($message, $userId);
            $this->info("   ✅ ВК личное сообщение добавлено в очередь для ID: {$userId}");
        } catch (\Exception $e) {
            $this->error("   ❌ Ошибка ВК личные сообщения: " . $e->getMessage());
        }
        
        // 3. ВК групповой чат
        try {
            $this->info('👥 3. Отправка в ВК групповой чат...');
            $chatId = config('services.vk.chat_id');
            
            SendVKMessage::dispatch($message, null, $chatId);
            $this->info("   ✅ ВК групповое сообщение добавлено в очередь для чата: {$chatId}");
        } catch (\Exception $e) {
            $this->error("   ❌ Ошибка ВК групповой чат: " . $e->getMessage());
        }
        
        $this->newLine();
        $this->info('🎉 Все уведомления добавлены в очередь!');
        $this->info('📋 Для обработки очереди выполните: php artisan queue:work');
        $this->info('📝 Проверьте логи: storage/logs/laravel.log');
        
        return Command::SUCCESS;
    }
}
