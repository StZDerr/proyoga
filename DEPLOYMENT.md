# 🚀 Руководство по деплою проекта ПроЙога

## Подготовка к продакшену

### 1. Требования к серверу

**Минимальные требования:**

-   PHP 8.2+
-   MySQL 8.0+ или PostgreSQL 13+
-   Nginx 1.18+ или Apache 2.4+
-   Node.js 18+
-   Composer 2.0+
-   Redis (рекомендуется)
-   SSL сертификат

**Расширения PHP:**

```bash
sudo apt install php8.2-fpm php8.2-mysql php8.2-redis php8.2-gd php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-intl
```

### 2. Подготовка сервера

```bash
# Обновляем систему
sudo apt update && sudo apt upgrade -y

# Устанавливаем необходимые пакеты
sudo apt install nginx mysql-server redis-server git curl

# Устанавливаем Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Устанавливаем Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 3. Клонирование проекта

```bash
# Переходим в веб-директорию
cd /var/www/html

# Клонируем репозиторий
sudo git clone https://github.com/StZDerr/proyoga.git
cd proyoga

# Устанавливаем права доступа
sudo chown -R www-data:www-data /var/www/html/proyoga
sudo chmod -R 775 storage bootstrap/cache
```

### 4. Настройка окружения

```bash
# Копируем файл окружения
cp .env.production .env

# Генерируем ключ приложения
php artisan key:generate

# Редактируем .env файл с реальными данными
nano .env
```

**Обязательно измените в .env:**

-   `APP_URL` - ваш домен
-   `DB_*` - настройки базы данных
-   `MAIL_*` - настройки почты
-   `REDIS_*` - если используете Redis

### 5. Установка зависимостей

```bash
# Устанавливаем PHP зависимости
composer install --no-dev --optimize-autoloader

# Устанавливаем Node.js зависимости
npm ci --production

# Собираем assets
npm run build
```

### 6. Настройка базы данных

```bash
# Создаем базу данных
mysql -u root -p
CREATE DATABASE proyoga_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'proyoga_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON proyoga_production.* TO 'proyoga_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Выполняем миграции
php artisan migrate --force

# Заполняем начальными данными
php artisan db:seed --class=TestSeeder
```

### 7. Оптимизация Laravel

```bash
# Кешируем конфигурацию
php artisan config:cache

# Кешируем роуты
php artisan route:cache

# Кешируем views
php artisan view:cache

# Связываем storage
php artisan storage:link
```

### 8. Настройка Nginx

```bash
# Копируем конфигурацию Nginx
sudo cp nginx.conf /etc/nginx/sites-available/proyoga

# Создаем символическую ссылку
sudo ln -s /etc/nginx/sites-available/proyoga /etc/nginx/sites-enabled/

# Удаляем дефолтную конфигурацию
sudo rm /etc/nginx/sites-enabled/default

# Проверяем конфигурацию
sudo nginx -t

# Перезапускаем Nginx
sudo systemctl restart nginx
```

### 9. SSL сертификат (Let's Encrypt)

```bash
# Устанавливаем Certbot
sudo apt install certbot python3-certbot-nginx

# Получаем сертификат
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Настраиваем автообновление
sudo crontab -e
# Добавляем строку:
0 12 * * * /usr/bin/certbot renew --quiet
```

## Автоматический деплой

### Вариант 1: Ручной деплой со скриптом

```bash
# Делаем скрипт исполняемым
chmod +x deploy.sh

# Запускаем деплой
./deploy.sh
```

### Вариант 2: GitHub Actions (автоматический)

1. В GitHub репозитории перейдите в Settings → Secrets and variables → Actions
2. Добавьте секреты:

    - `HOST` - IP адрес сервера
    - `USERNAME` - имя пользователя для SSH
    - `PRIVATE_KEY` - приватный SSH ключ
    - `PORT` - порт SSH (обычно 22)

3. При каждом push в main ветку деплой будет происходить автоматически

## Мониторинг и обслуживание

### Логи

```bash
# Логи Laravel
tail -f storage/logs/laravel.log

# Логи Nginx
tail -f /var/log/nginx/proyoga_access.log
tail -f /var/log/nginx/proyoga_error.log

# Логи PHP-FPM
tail -f /var/log/php8.2-fpm.log
```

### Регулярные задачи

```bash
# Добавляем в crontab Laravel scheduler
crontab -e
# Добавляем:
* * * * * cd /var/www/html/proyoga && php artisan schedule:run >> /dev/null 2>&1
```

### Бэкапы

```bash
# Создаем скрипт бэкапа
nano /usr/local/bin/backup-proyoga.sh
```

```bash
#!/bin/bash
DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/var/backups/proyoga"
PROJECT_DIR="/var/www/html/proyoga"

mkdir -p $BACKUP_DIR

# Бэкап базы данных
mysqldump -u proyoga_user -p proyoga_production > $BACKUP_DIR/db_$DATE.sql

# Бэкап файлов проекта
tar -czf $BACKUP_DIR/files_$DATE.tar.gz $PROJECT_DIR

# Удаляем старые бэкапы (старше 7 дней)
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

```bash
# Делаем исполняемым
chmod +x /usr/local/bin/backup-proyoga.sh

# Добавляем в crontab (ежедневно в 2:00)
0 2 * * * /usr/local/bin/backup-proyoga.sh
```

## Troubleshooting

### Частые проблемы

1. **Ошибка 500** - проверьте логи Laravel и права доступа
2. **Ошибка 403** - проверьте права доступа к файлам
3. **Assets не загружаются** - убедитесь, что `npm run build` выполнился успешно
4. **Проблемы с БД** - проверьте настройки подключения в .env

### Полезные команды

```bash
# Очистка всех кешей
php artisan optimize:clear

# Проверка статуса сервисов
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
sudo systemctl status mysql
sudo systemctl status redis

# Проверка дискового пространства
df -h

# Проверка использования памяти
free -h
```

## Безопасность

1. **Регулярно обновляйте** систему и зависимости
2. **Используйте firewall** (UFW)
3. **Настройте fail2ban** против брутфорс атак
4. **Регулярно делайте бэкапы**
5. **Мониторьте логи** на подозрительную активность

## Контакты

При возникновении проблем обращайтесь к разработчику проекта.
