<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {--to=info@xn--h1aafpog8g.xn--p1ai}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тестирует отправку email через ContactFormMail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $to = $this->option('to');
        
        $this->info("Отправка тестового email на {$to}...");
        
        $testData = [
            'name' => 'Тестовый пользователь',
            'phone' => '+7 (999) 123-45-67',
            'email' => 'test@example.com',
            'message' => 'Это тестовое сообщение для проверки отправки email',
            'form_type' => 'contact'
        ];
        
        try {
            // Тест с полным функционалом ContactFormMail
            Mail::to($to)->send(new ContactFormMail($testData));
            
            $this->info('✅ Email успешно отправлен!');
            
            // Показываем информацию о настройках почты
            $this->line('');
            $this->info('Настройки почты:');
            $this->line('MAIL_MAILER: ' . config('mail.default'));
            $this->line('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
            $this->line('MAIL_FROM_NAME: ' . config('mail.from.name'));
            
            if (config('mail.default') === 'log') {
                $this->warn('⚠️  Почта настроена на режим "log". Проверьте файл storage/logs/laravel.log');
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Ошибка отправки email: ' . $e->getMessage());
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}
