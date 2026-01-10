<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат теста</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 720px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #123D4D, #1D7D6F);
            color: white;
            padding: 28px 22px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .content {
            padding: 30px 26px;
        }

        .section-title {
            color: #123D4D;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .field {
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid #eee;
        }

        .field:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .field-label {
            font-weight: bold;
            color: #123D4D;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .field-value {
            font-size: 16px;
            color: #333;
            word-wrap: break-word;
        }

        .answers {
            background-color: #f9f9f9;
            padding: 16px 18px;
            border-radius: 8px;
            border: 1px solid #e6eded;
        }

        .answers ol {
            margin: 0;
            padding-left: 20px;
        }

        .answers li {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 18px;
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
                padding: 22px 18px;
            }

            .header {
                padding: 22px 18px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>🧘 Новый результат теста</h1>
        </div>

        <div class="content">
            <div class="field">
                <div class="section-title">Контакты</div>
                <div class="field-label">Имя</div>
                <div class="field-value">{{ $submission->name ?? 'Не указано' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Телефон</div>
                <div class="field-value">{{ $submission->phone ?? 'Не указан' }}</div>
            </div>

            @if (!empty($submission->email))
                <div class="field">
                    <div class="field-label">Email</div>
                    <div class="field-value">{{ $submission->email }}</div>
                </div>
            @endif

            <div class="field">
                <div class="field-label">Время отправки</div>
                <div class="field-value timestamp">{{ $submittedAt }}</div>
            </div>

            <div class="field">
                <div class="section-title">Ответы теста</div>
                @if ($answers->isNotEmpty())
                    <div class="answers">
                        <ol>
                            @foreach ($answers as $index => $answer)
                                <li>
                                    <strong>{{ $answer->question->question ?? 'Вопрос ' . $answer->test_question_id }}</strong><br>
                                    {{ $answer->option->option_text ?? 'Вариант ' . $answer->test_option_id }}
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @else
                    <div class="field-value">Ответы не найдены.</div>
                @endif
            </div>
        </div>

        <div class="footer">
            Это письмо отправлено автоматически. Ответьте клиенту в ближайшее время.
        </div>
    </div>
</body>

</html>
