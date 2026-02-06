<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новый выигрыш в колесе</title>
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

        .badge {
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
            <h1>🎁 Новый выигрыш в колесе</h1>
        </div>

        <div class="content">
            <div class="badge">Колесо удачи — результат</div>

            <div class="field">
                <div class="field-label">📞 Телефон</div>
                <div class="field-value">{{ $phone }}</div>
            </div>

            <div class="field">
                <div class="field-label">🏆 Приз</div>
                <div class="field-value">{{ $prizeName }}</div>
            </div>

            @if (!empty($prizeDescription))
                <div class="field">
                    <div class="field-label">📝 Описание</div>
                    <div class="field-value">{{ $prizeDescription }}</div>
                </div>
            @endif

            <div class="field">
                <div class="field-label">📄 Страница</div>
                <div class="field-value">
                    @if ($pageTitle && $pageTitle !== 'Не указан')
                        <strong>{{ $pageTitle }}</strong><br>
                    @endif
                    @if ($pageUrl && $pageUrl !== 'Не указана')
                        <a href="{{ $pageUrl }}"
                            style="color: #1D7D6F; text-decoration: none;">{{ $pageUrl }}</a>
                    @else
                        Не указана
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="field-label">🕐 Время</div>
                <div class="field-value timestamp">{{ $timestamp }}</div>
            </div>
        </div>

        <div class="footer">
            <p>Это письмо было отправлено автоматически после вращения колеса.</p>
        </div>
    </div>
</body>

</html>
