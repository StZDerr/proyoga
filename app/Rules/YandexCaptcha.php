<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YandexCaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('Необходимо пройти проверку капчи');
            return;
        }

        $serverKey = config('services.yandex_captcha.server_key');
        $verifyUrl = config('services.yandex_captcha.verify_url');

        if (empty($serverKey)) {
            Log::error('Yandex Captcha: server_key не настроен');
            $fail('Ошибка конфигурации капчи');
            return;
        }

        try {
            $response = Http::timeout(10)
                ->asForm()
                ->post($verifyUrl, [
                    'secret' => $serverKey,
                    'token' => $value,
                    'ip' => request()->ip(),
                ]);

            $result = $response->json();

            if (!$response->successful() || !isset($result['status']) || $result['status'] !== 'ok') {
                Log::warning('Yandex Captcha validation failed', [
                    'status' => $result['status'] ?? 'unknown',
                    'message' => $result['message'] ?? 'no message',
                    'response' => $result
                ]);
                
                $fail('Проверка капчи не пройдена. Попробуйте еще раз');
                return;
            }

            Log::info('Yandex Captcha validated successfully');

        } catch (\Exception $e) {
            Log::error('Yandex Captcha validation error: ' . $e->getMessage());
            $fail('Ошибка проверки капчи. Попробуйте еще раз');
        }
    }
}
