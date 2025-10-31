<?php

namespace App\Console\Commands;

use App\Mail\ContactFormMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class CheckEmailSystem extends Command
{
    protected $signature = 'check:email-system';

    protected $description = 'Проверяет всю email систему проекта';

    public function handle()
    {
        $this->info('🔍 Проверка email системы...');
        $this->newLine();

        // Проверка конфигурации
        $this->checkConfiguration();

        // Проверка классов
        $this->checkClasses();

        // Проверка шаблонов
        $this->checkTemplates();

        // Проверка роутов
        $this->checkRoutes();

        // Тестовая отправка
        $this->testEmailSending();

        $this->newLine();
        $this->info('✅ Проверка завершена!');

        return 0;
    }

    private function checkConfiguration()
    {
        $this->line('📧 Конфигурация email:');

        $mailer = config('mail.default');
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        $contactEmail = env('CONTACT_EMAIL');

        $this->line("   MAIL_MAILER: {$mailer}");
        $this->line("   FROM_ADDRESS: {$fromAddress}");
        $this->line("   FROM_NAME: {$fromName}");
        $this->line("   CONTACT_EMAIL: {$contactEmail}");

        if ($mailer === 'log') {
            $this->warn('   ⚠️ Режим LOG - письма сохраняются в storage/logs/laravel.log');
        } else {
            $this->info('   ✅ Режим отправки настроен');
        }

        $this->newLine();
    }

    private function checkClasses()
    {
        $this->line('🔧 Проверка классов:');

        // Проверка Mailable
        if (class_exists(\App\Mail\ContactFormMail::class)) {
            $this->line('   ✅ ContactFormMail класс существует');
        } else {
            $this->error('   ❌ ContactFormMail класс не найден');
        }

        // Проверка Controller
        if (class_exists(\App\Http\Controllers\ContactController::class)) {
            $this->line('   ✅ ContactController класс существует');
        } else {
            $this->error('   ❌ ContactController класс не найден');
        }

        $this->newLine();
    }

    private function checkTemplates()
    {
        $this->line('📄 Проверка шаблонов:');

        $templates = [
            'emails.contact-form-final',
            'emails.contact-form',
            'emails.contact-form-styled',
        ];

        foreach ($templates as $template) {
            if (View::exists($template)) {
                $this->line("   ✅ {$template} существует");
            } else {
                $this->line("   ❌ {$template} не найден");
            }
        }

        $this->newLine();
    }

    private function checkRoutes()
    {
        $this->line('🛣️ Проверка роутов:');

        $routes = \Route::getRoutes();

        $contactRoutes = 0;
        foreach ($routes as $route) {
            if (str_contains($route->uri(), 'contact')) {
                $contactRoutes++;
                $this->line("   ✅ {$route->methods()[0]} /{$route->uri()}");
            }
        }

        if ($contactRoutes === 0) {
            $this->warn('   ⚠️ Роуты для contact не найдены');
        }

        $this->newLine();
    }

    private function testEmailSending()
    {
        $this->line('📤 Тестовая отправка email:');

        try {
            $testData = [
                'name' => 'Тест Системы',
                'email' => 'test@example.com',
                'message' => 'Тестовое сообщение для проверки системы email',
                'form_type' => 'contact',
            ];

            $contactEmail = env('CONTACT_EMAIL', 'info@example.com');

            Mail::to($contactEmail)->send(new ContactFormMail($testData));

            $this->line('   ✅ Email успешно отправлен!');

            if (config('mail.default') === 'log') {
                $this->line('   📁 Проверьте файл storage/logs/laravel.log');
            }

        } catch (\Exception $e) {
            $this->error("   ❌ Ошибка отправки: {$e->getMessage()}");
        }
    }
}
