@props([
    'id' => 'yandex-captcha-' . uniqid(),
    'theme' => 'light', // light, dark
    'size' => 'normal', // normal, compact
])

@php
    $clientKey = config('services.yandex_captcha.client_key');
@endphp

@if($clientKey)
    <div {{ $attributes->merge(['class' => 'yandex-captcha']) }}
         id="{{ $id }}"
         data-sitekey="{{ $clientKey }}"
         data-theme="{{ $theme }}"
         data-size="{{ $size }}"
         style="min-height: 65px;">
    </div>

    @once
        @push('scripts')
            <script>
                function initYandexCaptcha() {
                    const unrenderedCaptchas = document.querySelectorAll('.yandex-captcha:not([data-rendered])');
                    
                    if (unrenderedCaptchas.length === 0) {
                        return;
                    }
                    
                    if (typeof window.smartCaptcha === 'undefined') {
                        setTimeout(initYandexCaptcha, 100);
                        return;
                    }
                    
                    unrenderedCaptchas.forEach(captcha => {
                        try {
                            const widgetId = window.smartCaptcha.render(captcha, {
                                sitekey: captcha.getAttribute('data-sitekey'),
                                theme: captcha.getAttribute('data-theme') || 'light',
                                size: captcha.getAttribute('data-size') || 'normal',
                                callback: function(token) {
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
                                        
                                        const errorElement = form.querySelector('.captcha-error');
                                        if (errorElement) {
                                            errorElement.style.display = 'none';
                                        }
                                    }
                                },
                                'expired-callback': function() {
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
                            captcha.setAttribute('data-widget-id', widgetId);
                        } catch (error) {
                            // Капча может не работать на localhost
                        }
                    });
                }
                
                // Загрузка скрипта
                if (!document.querySelector('script[src*="smartcaptcha.yandexcloud.net"]')) {
                    const script = document.createElement('script');
                    script.src = 'https://smartcaptcha.yandexcloud.net/captcha.js';
                    script.async = true;
                    script.defer = true;
                    script.onload = function() {
                        setTimeout(initYandexCaptcha, 100);
                    };
                    document.head.appendChild(script);
                } else {
                    initYandexCaptcha();
                }
                
                // Инициализация при готовности DOM
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(initYandexCaptcha, 500);
                });
            </script>
        @endpush
    @endonce
@else
    <div class="alert alert-warning">
        <strong>Внимание:</strong> Яндекс капча не настроена. Добавьте YANDEX_CAPTCHA_CLIENT_KEY в .env файл.
    </div>
@endif