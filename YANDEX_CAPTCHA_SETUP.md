# Настройка Яндекс SmartCaptcha

## Быстрая настройка

### 1. Получите ключи Яндекс SmartCaptcha

1. Перейдите в [консоль Яндекс.Облако](https://console.cloud.yandex.ru/)
2. Выберите сервис **SmartCaptcha**
3. Создайте новую капчу или используйте существующую
4. Скопируйте **Ключ клиента** (Client Key) и **Серверный ключ** (Server Key)

### 2. Добавьте ключи в .env файл

```env
# Яндекс SmartCaptcha
YANDEX_CAPTCHA_CLIENT_KEY=ваш_client_key_от_yandex
YANDEX_CAPTCHA_SERVER_KEY=ваш_server_key_от_yandex
```

### 3. Проверьте настройку

```bash
php artisan test:yandex-captcha
```

## Использование в формах

### Blade компонент

Капча уже добавлена в формы:
- Форма записи на занятие (`recording-block.blade.php`)
- Модальная форма теста (`modal-test.blade.php`)

```blade
{{-- Добавить в любую форму --}}
<x-yandex-captcha />

{{-- Или с параметрами --}}
<x-yandex-captcha theme="dark" size="compact" />
```

### Валидация на сервере

Капча автоматически валидируется в:
- `ContactController::sendContactForm()` - основная контактная форма
- `TestController::submitTest()` - форма теста

```php
// Для новых форм добавьте правило валидации:
'smart-token' => ['required', new \App\Rules\YandexCaptcha()],
```

### JavaScript интеграция

Токен капчи автоматически добавляется в формы:
- `resources/js/recording-form.js` - форма записи
- `resources/js/yoga-test.js` - модальный тест

```javascript
// Для новых форм добавьте в FormData:
"smart-token": formData.get("smart-token")
```

## Тестирование

### 1. Проверка конфигурации
```bash
php artisan test:yandex-captcha
```

### 2. Полное тестирование с токеном
```bash
# 1. Откройте страницу с формой
# 2. Пройдите капчу
# 3. В консоли браузера выполните:
#    document.querySelector('input[name="smart-token"]').value
# 4. Запустите команду с полученным токеном:
php artisan test:yandex-captcha полученный_токен
```

### 3. Проверка логов
```bash
# Смотрите логи Laravel для отладки:
tail -f storage/logs/laravel.log | grep -i captcha
```

## Настройки капчи

### Параметры компонента
- `theme` - тема капчи: `light` (по умолчанию), `dark`
- `size` - размер: `normal` (по умолчанию), `compact`
- `class` - CSS классы
- `id` - уникальный ID

### Конфигурация в services.php
```php
'yandex_captcha' => [
    'client_key' => env('YANDEX_CAPTCHA_CLIENT_KEY'),
    'server_key' => env('YANDEX_CAPTCHA_SERVER_KEY'),
    'verify_url' => 'https://smartcaptcha.yandexcloud.net/validate',
],
```

## Устранение проблем

### Капча не загружается
- Проверьте `YANDEX_CAPTCHA_CLIENT_KEY` в .env
- Убедитесь что домен добавлен в настройки капчи в консоли Яндекс

### Валидация не проходит
- Проверьте `YANDEX_CAPTCHA_SERVER_KEY` в .env
- Убедитесь что токен передается в поле `smart-token`
- Проверьте логи Laravel на наличие ошибок API

### Капча появляется несколько раз
- Компонент автоматически предотвращает дублирование
- Проверьте что скрипт капчи подключается только один раз (@once в компоненте)

## Безопасность

- Серверный ключ никогда не передается в браузер
- Валидация всегда происходит на сервере
- IP пользователя передается для дополнительной проверки
- Токены одноразовые и имеют ограниченный срок действия

## Поддержка

Для получения помощи:
1. Проверьте логи Laravel: `storage/logs/laravel.log`
2. Используйте команду тестирования: `php artisan test:yandex-captcha`
3. Обратитесь к документации Яндекс SmartCaptcha