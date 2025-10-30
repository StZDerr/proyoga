#!/bin/bash

# Deployment скрипт для Laravel проекта ПроЙога
# Использование: ./deploy.sh

set -e

echo "🚀 Начинаем деплой проекта ПроЙога..."

# Цвета для вывода
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Функция для вывода сообщений
print_status() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️ $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Проверяем, что мы в правильной директории
if [ ! -f "artisan" ]; then
    print_error "Файл artisan не найден. Убедитесь, что вы в корневой директории Laravel проекта."
    exit 1
fi

print_status "Обновляем код из Git..."
git pull origin main

print_status "Устанавливаем/обновляем зависимости Composer..."
composer install --no-dev --optimize-autoloader

print_status "Устанавливаем/обновляем зависимости NPM..."
npm ci --production

print_status "Сборка assets для продакшена..."
npm run build

print_status "Очищаем все кеши Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

print_status "Кешируем конфигурацию для продакшена..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

print_status "Выполняем миграции базы данных..."
php artisan migrate --force

print_status "Оптимизируем автозагрузку Composer..."
composer dump-autoload --optimize

print_status "Связываем storage с public..."
php artisan storage:link

print_status "Устанавливаем права доступа..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

print_status "Перезапускаем сервисы..."
# Убедитесь, что у вас есть права на выполнение этих команд
sudo systemctl reload nginx
sudo systemctl reload php8.2-fpm

print_status "🎉 Деплой завершен успешно!"

echo ""
echo "📋 Что было сделано:"
echo "   • Обновлен код из Git"
echo "   • Установлены зависимости"
echo "   • Собраны assets"
echo "   • Очищены и пересозданы кеши"
echo "   • Выполнены миграции БД"
echo "   • Оптимизирован автозагрузчик"
echo "   • Настроены права доступа"
echo "   • Перезапущены сервисы"
echo ""
print_warning "Не забудьте проверить сайт!"