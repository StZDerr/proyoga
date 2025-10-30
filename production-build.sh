#!/bin/bash

# Скрипт для финальной подготовки к продакшену

echo "🔧 Подготовка проекта к продакшену..."

# Оптимизируем Composer
echo "📦 Оптимизируем Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

# Собираем assets для продакшена
echo "🎨 Собираем assets..."
npm ci --production
npm run build

# Проверяем Laravel
echo "🔍 Проверяем Laravel..."
php artisan --version

# Очищаем все кеши
echo "🧹 Очищаем кеши..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Генерируем оптимизированные кеши
echo "⚡ Создаем оптимизированные кеши..."
php artisan config:cache
php artisan route:cache

# Оптимизируем файлы
echo "🗂️ Оптимизируем файлы..."
php artisan view:cache

# Генерируем манифест пакетов
echo "📋 Обновляем манифест..."
composer dump-autoload --optimize

echo "✅ Проект готов к продакшену!"
echo ""
echo "📝 Следующие шаги на сервере:"
echo "1. Скопируйте .env.production в .env"
echo "2. Настройте переменные окружения"
echo "3. Выполните: php artisan key:generate"
echo "4. Выполните: php artisan migrate --force"
echo "5. Выполните: php artisan storage:link"
echo "6. Настройте права доступа"
echo "7. Перезапустите веб-сервер"