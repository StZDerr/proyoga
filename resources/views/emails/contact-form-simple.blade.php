<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Заявка с сайта</title>
</head>

<body>
    <h1>Новая заявка с сайта йоги</h1>

    <p><strong>Имя:</strong> {{ $name ?? 'Не указано' }}</p>
    <p><strong>Телефон:</strong> {{ $phone ?? 'Не указан' }}</p>
    <p><strong>Email:</strong> {{ $email ?? 'Не указан' }}</p>
    <p><strong>Сообщение:</strong> {{ $message ?? 'Без сообщения' }}</p>
    <p><strong>Время отправки:</strong> {{ $timestamp ?? date('d.m.Y H:i') }}</p>
</body>

</html>
