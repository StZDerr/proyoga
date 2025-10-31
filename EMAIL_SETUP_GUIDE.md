# Настройка Email для сайта ПроЙога

## Проблема
На локальном сервере (Laragon) письма не могут быть отправлены на реальные email адреса, потому что нет настроенного SMTP сервера.

## Решения для продакшена

### Вариант 1: Использование Yandex Mail (рекомендуется)

1. **Войдите в почту info@йога-истоки.рф**
2. **Создайте пароль приложения:**
   - Перейдите в настройки почты Yandex
   - Раздел "Безопасность" 
   - "Пароли приложений"
   - Создайте новый пароль для "Почтовый клиент"

3. **Обновите .env файл:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yandex.ru
MAIL_PORT=587
MAIL_USERNAME="info@xn--h1aafpog8g.xn--p1ai"
MAIL_PASSWORD="ВАШ_ПАРОЛЬ_ПРИЛОЖЕНИЯ"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@xn--h1aafpog8g.xn--p1ai"
MAIL_FROM_NAME="ПроЙога"

CONTACT_EMAIL="info@xn--h1aafpog8g.xn--p1ai"
```

### Вариант 2: Использование хостинга с sendmail

Если ваш хостинг поддерживает sendmail:

```env
MAIL_MAILER=sendmail
MAIL_FROM_ADDRESS="info@xn--h1aafpog8g.xn--p1ai"
MAIL_FROM_NAME="ПроЙога"

CONTACT_EMAIL="info@xn--h1aafpog8g.xn--p1ai"
```

### Вариант 3: Использование Gmail SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="ваш-gmail@gmail.com"
MAIL_PASSWORD="пароль-приложения-gmail"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@xn--h1aafpog8g.xn--p1ai"
MAIL_FROM_NAME="ПроЙога"

CONTACT_EMAIL="info@xn--h1aafpog8g.xn--p1ai"
```

## Тестирование

После настройки запустите команду:
```bash
php artisan test:email
```

Если увидите сообщение "✅ Email успешно отправлен!", значит настройка работает.

## Текущий статус

✅ **Готово:**
- Контроллер ContactController
- Mailable класс ContactFormMail  
- Email шаблон contact-form-final.blade.php
- JavaScript форма с AJAX
- Роуты и CSRF защита
- Тестовая команда

⚠️ **Требует настройки на продакшене:**
- SMTP настройки в .env файле
- Проверка email доставки

## Файлы системы

- **Контроллер:** `app/Http/Controllers/ContactController.php`
- **Email класс:** `app/Mail/ContactFormMail.php`
- **Шаблон письма:** `resources/views/emails/contact-form-final.blade.php`
- **JavaScript:** в файлах с формами
- **Роуты:** `routes/web.php`
- **Команда тестирования:** `app/Console/Commands/TestEmail.php`