@props([
    'id' => 'yandex-captcha-' . uniqid(),
    'class' => 'yandex-captcha',
    'theme' => 'light', // light, dark
    'size' => 'normal', // normal, compact
])

@php
    $clientKey = config('services.yandex_captcha.client_key');
@endphp

@if($clientKey)
    <div {{ $attributes->merge(['class' => $class, 'id' => $id]) }}
         data-sitekey="{{ $clientKey }}"
         data-theme="{{ $theme }}"
         data-size="{{ $size }}">
    </div>

    @once
        @push('scripts')
            <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
            <script>
                function onYandexCaptchaLoad() {
                    const captchas = document.querySelectorAll('.yandex-captcha');
                    
                    captchas.forEach(captcha => {
                        if (!captcha.hasAttribute('data-rendered')) {
                            window.smartCaptcha.render(captcha, {
                                sitekey: captcha.getAttribute('data-sitekey'),
                                theme: captcha.getAttribute('data-theme') || 'light',
                                size: captcha.getAttribute('data-size') || 'normal',
                                callback: function(token) {
                                    // Найдем ближайшую форму и добавим токен
                                    const form = captcha.closest('form');
                                    if (form) {
                                        let tokenInput = form.querySelector('input[name="smart-token"]');
                                        if (!tokenInput) {
                                            tokenInput = document.createElement('input');
                                            tokenInput.type = 'hidden';
                                            tokenInput.name = 'smart-token';
                                            form.appendChild(tokenInput);
                                        }
                                        tokenInput.value = token;
                                        
                                        // Убираем ошибки капчи если есть
                                        const errorElement = form.querySelector('.captcha-error');
                                        if (errorElement) {
                                            errorElement.style.display = 'none';
                                        }
                                    }
                                },
                                'expired-callback': function() {
                                    // Очищаем токен при истечении
                                    const form = captcha.closest('form');
                                    if (form) {
                                        const tokenInput = form.querySelector('input[name="smart-token"]');
                                        if (tokenInput) {
                                            tokenInput.value = '';
                                        }
                                    }
                                }
                            });
                            captcha.setAttribute('data-rendered', 'true');
                        }
                    });
                }

                // Загружаем капчу когда скрипт готов
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof window.smartCaptcha !== 'undefined') {
                        onYandexCaptchaLoad();
                    } else {
                        // Ждем загрузки скрипта капчи
                        window.onYandexCaptchaLoad = onYandexCaptchaLoad;
                    }
                });
            </script>
        @endpush
    @endonce
@else
    <div class="alert alert-warning">
        <strong>Внимание:</strong> Яндекс капча не настроена. Добавьте YANDEX_CAPTCHA_CLIENT_KEY в .env файл.
    </div>
@endif