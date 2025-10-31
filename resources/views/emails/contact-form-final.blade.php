<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая заявка с сайта</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #123D4D, #1D7D6F);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 300;
        }
        .content {
            padding: 30px;
        }
        .form-type {
            background-color: #f1f8f6;
            color: #123D4D;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .field {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .field:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .field-label {
            font-weight: bold;
            color: #123D4D;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }
        .field-value {
            font-size: 16px;
            color: #333;
            word-wrap: break-word;
        }
        .message-field {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #1D7D6F;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
        }
        .timestamp {
            color: #999;
            font-style: italic;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 20px 15px;
            }
            .header {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🧘‍♀️ Новая заявка с сайта йоги</h1>
        </div>
        
        <div class="content">
            <div class="form-type">
                @if($formType === 'recording')
                    📝 Запись на занятие
                @else
                    💬 Обратная связь
                @endif
            </div>

            <div class="field">
                <div class="field-label">👤 Имя</div>
                <div class="field-value">{{ $name }}</div>
            </div>

            <div class="field">
                <div class="field-label">📞 Телефон</div>
                <div class="field-value">{{ $phone }}</div>
            </div>

            @if($userEmail && $userEmail !== 'Не указан')
            <div class="field">
                <div class="field-label">📧 Email</div>
                <div class="field-value">{{ $userEmail }}</div>
            </div>
            @endif

            @if($userMessage && $userMessage !== 'Без сообщения')
            <div class="field">
                <div class="field-label">💭 Сообщение</div>
                <div class="field-value message-field">{{ $userMessage }}</div>
            </div>
            @endif

            <div class="field">
                <div class="field-label">🕐 Время отправки</div>
                <div class="field-value timestamp">{{ $timestamp }}</div>
            </div>
        </div>

        <div class="footer">
            <p>Это письмо было отправлено автоматически с сайта йоги.<br>
            Пожалуйста, свяжитесь с клиентом в ближайшее время.</p>
        </div>
    </div>
</body>
</html>