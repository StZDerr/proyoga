<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Rules\YandexCaptcha;

class TestYandexCaptcha extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:yandex-captcha {token?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тестирует работу Яндекс капчи с заданным токеном';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = $this->argument('token');
        
        $this->info('🔐 Тестирование Яндекс SmartCaptcha...');
        $this->newLine();
        
        // Проверяем конфигурацию
        $clientKey = config('services.yandex_captcha.client_key');
        $serverKey = config('services.yandex_captcha.server_key');
        
        $this->info('📋 Конфигурация:');
        $this->line("   Client Key: " . ($clientKey ? '✅ Настроен' : '❌ Не настроен'));
        $this->line("   Server Key: " . ($serverKey ? '✅ Настроен' : '❌ Не настроен'));
        $this->line("   Verify URL: " . config('services.yandex_captcha.verify_url'));
        $this->newLine();
        
        if (!$clientKey || !$serverKey) {
            $this->error('❌ Яндекс капча не настроена полностью!');
            $this->info('Добавьте в .env файл:');
            $this->info('YANDEX_CAPTCHA_CLIENT_KEY=ваш_client_key');
            $this->info('YANDEX_CAPTCHA_SERVER_KEY=ваш_server_key');
            return Command::FAILURE;
        }
        
        if (!$token) {
            $this->info('🌐 Для полного тестирования получите токен из браузера:');
            $this->info('1. Откройте страницу с формой');
            $this->info('2. Пройдите капчу');
            $this->info('3. В консоли браузера выполните:');
            $this->info('   document.querySelector(\'input[name="smart-token"]\').value');
            $this->info('4. Запустите команду с полученным токеном:');
            $this->info('   php artisan test:yandex-captcha ваш_токен');
            $this->newLine();
            return Command::SUCCESS;
        }
        
        $this->info("🧪 Тестирование токена: " . substr($token, 0, 20) . '...');
        
        try {
            $validator = new YandexCaptcha();
            $errors = [];
            
            $validator->validate('smart-token', $token, function($message) use (&$errors) {
                $errors[] = $message;
            });
            
            if (empty($errors)) {
                $this->info('✅ Токен капчи прошел проверку успешно!');
                $this->info('🎉 Яндекс капча настроена и работает корректно.');
                return Command::SUCCESS;
            } else {
                $this->error('❌ Ошибка валидации токена:');
                foreach ($errors as $error) {
                    $this->error("   {$error}");
                }
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Ошибка при тестировании: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
