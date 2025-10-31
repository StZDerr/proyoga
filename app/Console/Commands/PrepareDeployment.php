<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class PrepareDeployment extends Command
{
    protected $signature = 'deploy:prepare';

    protected $description = 'Подготавливает проект к деплою на сервер';

    public function handle()
    {
        $this->info('🚀 Подготовка к деплою...');
        $this->newLine();

        // Проверка системы
        $this->checkSystem();

        // Сборка assets
        $this->buildAssets();

        // Очистка кешей
        $this->clearCaches();

        // Проверка email системы
        $this->checkEmailSystem();

        // Создание .env.production
        $this->createProductionEnv();

        // Инструкции
        $this->showInstructions();

        return 0;
    }

    private function checkSystem()
    {
        $this->line('🔍 Проверка системы:');

        // Проверка PHP версии
        $phpVersion = PHP_VERSION;
        $this->line("   PHP версия: {$phpVersion}");

        // Проверка необходимых расширений
        $extensions = ['openssl', 'pdo', 'mbstring', 'tokenizer', 'xml', 'ctype', 'json'];
        foreach ($extensions as $ext) {
            if (extension_loaded($ext)) {
                $this->line("   ✅ {$ext}");
            } else {
                $this->error("   ❌ {$ext} не установлен");
            }
        }

        $this->newLine();
    }

    private function buildAssets()
    {
        $this->line('🎨 Сборка frontend assets:');

        if (File::exists(base_path('package.json'))) {
            $this->line('   Запуск npm run build...');
            exec('npm run build 2>&1', $output, $returnCode);

            if ($returnCode === 0) {
                $this->line('   ✅ Assets собраны успешно');
            } else {
                $this->warn('   ⚠️ Ошибка сборки assets');
                foreach ($output as $line) {
                    $this->line("   {$line}");
                }
            }
        } else {
            $this->line('   ⚠️ package.json не найден');
        }

        $this->newLine();
    }

    private function clearCaches()
    {
        $this->line('🧹 Очистка кешей:');

        try {
            Artisan::call('config:clear');
            $this->line('   ✅ Config кеш очищен');

            Artisan::call('route:clear');
            $this->line('   ✅ Route кеш очищен');

            Artisan::call('view:clear');
            $this->line('   ✅ View кеш очищен');

        } catch (\Exception $e) {
            $this->error("   ❌ Ошибка очистки кеша: {$e->getMessage()}");
        }

        $this->newLine();
    }

    private function checkEmailSystem()
    {
        $this->line('📧 Проверка email системы:');

        try {
            Artisan::call('check:email-system');
            $this->line('   ✅ Email система готова');
        } catch (\Exception $e) {
            $this->error("   ❌ Проблема с email системой: {$e->getMessage()}");
        }

        $this->newLine();
    }

    private function createProductionEnv()
    {
        $this->line('⚙️ Создание .env.production:');

        $envContent = $this->getProductionEnvTemplate();

        File::put(base_path('.env.production'), $envContent);
        $this->line('   ✅ Файл .env.production создан');
        $this->line('   📝 Отредактируйте его перед загрузкой на сервер');

        $this->newLine();
    }

    private function getProductionEnvTemplate()
    {
        return <<<'ENV'
APP_NAME="ПроЙога"
APP_ENV=production
APP_KEY=base64:СГЕНЕРИРУЙТЕ_НОВЫЙ_КЛЮЧ
APP_DEBUG=false
APP_URL=https://йога-истоки.рф

APP_LOCALE=ru
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=ru_RU

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

# База данных - узнайте настройки у хостинга
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=НАЗВАНИЕ_БАЗЫ_ДАННЫХ
DB_USERNAME=ПОЛЬЗОВАТЕЛЬ_БАЗЫ
DB_PASSWORD=ПАРОЛЬ_БАЗЫ

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync

CACHE_STORE=file

# Email настройки - ОБЯЗАТЕЛЬНО НАСТРОЙТЕ!
MAIL_MAILER=smtp
MAIL_HOST=smtp.yandex.ru
MAIL_PORT=587
MAIL_USERNAME="info@xn--h1aafpog8g.xn--p1ai"
MAIL_PASSWORD="ПАРОЛЬ_ПРИЛОЖЕНИЯ_YANDEX"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@xn--h1aafpog8g.xn--p1ai"
MAIL_FROM_NAME="ПроЙога"

# Email получателя для форм обратной связи
CONTACT_EMAIL="info@xn--h1aafpog8g.xn--p1ai"

# Оставьте пустыми если не используете
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
ENV;
    }

    private function showInstructions()
    {
        $this->info('✅ Подготовка завершена!');
        $this->newLine();

        $this->line('📋 Следующие шаги:');
        $this->line('');
        $this->line('1. 📁 Создайте архив проекта, исключив:');
        $this->line('   - node_modules/');
        $this->line('   - .env (используйте .env.production)');
        $this->line('   - storage/logs/*');
        $this->line('   - .git/ (если не нужен)');
        $this->line('');
        $this->line('2. 🌐 Загрузите файлы на хостинг');
        $this->line('');
        $this->line('3. ⚙️ На сервере выполните:');
        $this->line('   composer install --no-dev --optimize-autoloader');
        $this->line('   php artisan key:generate');
        $this->line('   php artisan storage:link');
        $this->line('   php artisan migrate (если используете БД)');
        $this->line('   php artisan config:cache');
        $this->line('   php artisan route:cache');
        $this->line('   php artisan view:cache');
        $this->line('');
        $this->line('4. 📧 Настройте email в .env:');
        $this->line('   - Создайте пароль приложения в Yandex');
        $this->line('   - Обновите MAIL_PASSWORD в .env');
        $this->line('');
        $this->line('5. 🧪 Протестируйте:');
        $this->line('   php artisan check:email-system');
        $this->line('');
        $this->info('📖 Подробные инструкции в DEPLOYMENT_GUIDE.md');
    }
}
