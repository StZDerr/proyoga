# Оптимизация производительности проекта

## Выполненные оптимизации

### 1. Ленивая загрузка Яндекс SmartCaptcha (экономия ~1161 КБ)

**Что было**: Скрипт капчи загружался сразу при загрузке страницы на всех страницах с формами.

**Что сделано**:

-   Капча загружается только при взаимодействии с формой (focus, mouseenter, touchstart)
-   Для модальных окон - загрузка при открытии модального окна
-   Удалена дублирующая загрузка из `seo-meta.blade.php`

**Файлы**:

-   `resources/views/components/yandex-captcha.blade.php`
-   `resources/views/components/seo-meta.blade.php`

**Результат**: Капча не блокирует начальную загрузку страницы, экономия ~1.3 секунды на мобильных устройствах.

---

### 2. Оптимизация Vite-бандлов

**Что было**: Один большой бандл с неиспользуемым кодом (560 КБ неиспользуемого JS).

**Что сделано**:

-   Добавлен code splitting в `vite.config.js`
-   Vendor chunk для библиотек (Bootstrap, SweetAlert2)
-   Минификация с удалением `console.log` в продакшене
-   Оптимизация Terser для лучшей компрессии

**Файлы**:

-   `vite.config.js`

**Настройки**:

```javascript
build: {
    rollupOptions: {
        output: {
            manualChunks: {
                'vendor': ['bootstrap', 'sweetalert2'],
            },
        },
    },
    cssMinify: true,
    minify: 'terser',
    terserOptions: {
        compress: {
            drop_console: true,
            drop_debugger: true,
        },
    },
}
```

---

### 3. Объединение общих файлов

**Что было**: На каждой странице дублировались импорты navbar.css, footer.css, arrow.css, cookies.css и их JS.

**Что сделано**:

-   Создан `resources/css/base.css` - объединяет все общие CSS
-   Создан `resources/js/base.js` - объединяет все общие JS
-   Обновлены view файлы для использования `base.css` и `base.js`

**Файлы**:

-   `resources/css/base.css` (новый)
-   `resources/js/base.js` (новый)
-   `resources/views/welcome.blade.php` (обновлён)

**Результат**: Меньше HTTP-запросов, лучшее кеширование общих ресурсов.

---

### 4. Preload критичных ресурсов

**Что сделано**:

-   Добавлен preload для главного изображения hero-секции
-   Используется `fetchpriority="high"` для приоритизации загрузки

**Файлы**:

-   `resources/views/welcome.blade.php`

**Код**:

```html
<link
    rel="preload"
    as="image"
    href="{{ asset('images/main-hero.jpg') }}"
    fetchpriority="high"
/>
```

---

## Следующие шаги для дальнейшей оптимизации

### 1. Оптимизация изображений

#### Конвертация в WebP

```bash
# Установить cwebp (Windows - скачать с https://developers.google.com/speed/webp/download)
# Конвертировать все изображения
cd public/images
for %%f in (*.jpg *.png) do cwebp -q 80 %%f -o %%~nf.webp
```

#### Использование в Blade

```html
<picture>
    <source srcset="{{ asset('images/photo.webp') }}" type="image/webp" />
    <img src="{{ asset('images/photo.jpg') }}" alt="..." loading="lazy" />
</picture>
```

#### Lazy loading для изображений

Добавить на все изображения ниже fold:

```html
<img src="..." alt="..." loading="lazy" decoding="async" />
```

---

### 2. Дальнейшая оптимизация CSS

#### Установка PurgeCSS

```bash
npm install -D @fullhuman/postcss-purgecss
```

#### Настройка в `postcss.config.js`

```javascript
import purgecss from "@fullhuman/postcss-purgecss";

export default {
    plugins: [
        purgecss({
            content: [
                "./resources/**/*.blade.php",
                "./resources/**/*.js",
                "./resources/**/*.vue",
            ],
            safelist: {
                standard: [/^swal/, /^bs-/, /^modal/, /^fade/],
                deep: [],
                greedy: [/navbar/, /dropdown/],
            },
        }),
    ],
};
```

---

### 3. Оптимизация Яндекс Метрики

**Текущее состояние**: Метрика загружается с задержкой 2 секунды после загрузки страницы.

**Дополнительная оптимизация**:

```javascript
// В seo-meta.blade.php увеличить задержку или загружать по событию scroll
window.addEventListener(
    "scroll",
    function () {
        // загрузить метрику
    },
    { once: true }
);
```

---

### 4. Service Worker для кеширования

#### Создать `public/sw.js`

```javascript
const CACHE_NAME = "proyoga-v1";
const STATIC_ASSETS = ["/css/base.css", "/js/base.js", "/fonts/..."];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(STATIC_ASSETS);
        })
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
```

#### Регистрация в `app.js`

```javascript
if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker.register("/sw.js");
    });
}
```

---

### 5. Critical CSS (инлайн критичных стилей)

#### Установка пакета

```bash
npm install -D critical
```

#### Использование

```javascript
// В build процессе
import { generate } from "critical";

generate({
    inline: true,
    base: "public/",
    src: "index.html",
    target: "index.html",
    width: 1300,
    height: 900,
});
```

---

### 6. HTTP/2 Server Push (на уровне сервера)

В nginx.conf добавить:

```nginx
location / {
    http2_push /build/assets/base.css;
    http2_push /build/assets/base.js;
}
```

---

### 7. Defer/Async для сторонних скриптов

Все сторонние скрипты должны загружаться асинхронно:

```html
<script src="..." defer></script>
<!-- или -->
<script src="..." async></script>
```

---

## Тестирование производительности

### После внедрения оптимизаций:

1. **Пересобрать Vite**:

```bash
npm run build
```

2. **Очистить кеш Laravel**:

```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

3. **Протестировать в PageSpeed Insights**:

-   https://pagespeed.web.dev/
-   Проверить mobile и desktop версии

4. **Проверить в Chrome DevTools**:

-   Lighthouse
-   Performance tab
-   Coverage tool (показывает неиспользуемый код)

---

## Ожидаемые улучшения

### До оптимизации:

-   ❌ 560 КБ неиспользуемого JavaScript
-   ❌ 1.8 секунды выполнения JavaScript
-   ❌ 41 КБ неиспользуемого CSS
-   ❌ SmartCaptcha: 1161 КБ, 1348ms
-   ❌ Яндекс Метрика: 218 КБ, 321ms

### После оптимизации (ожидается):

-   ✅ Уменьшение неиспользуемого JS до ~200 КБ (экономия 360 КБ)
-   ✅ Сокращение времени выполнения JS до ~800ms (экономия 1 секунды)
-   ✅ Уменьшение неиспользуемого CSS до ~10 КБ (экономия 31 КБ)
-   ✅ SmartCaptcha загружается только при взаимодействии (экономия 1348ms на начальной загрузке)
-   ✅ Улучшение FCP (First Contentful Paint) на 30-40%
-   ✅ Улучшение LCP (Largest Contentful Paint) на 20-30%
-   ✅ Улучшение TBT (Total Blocking Time) на 50-60%

---

## Мониторинг после внедрения

1. **Регулярно проверяйте** PageSpeed Insights (раз в неделю)
2. **Отслеживайте метрики** в Яндекс.Метрике:
    - Время загрузки страниц
    - Показатель отказов
    - Глубина просмотра
3. **Используйте Real User Monitoring** (RUM) для отслеживания производительности реальных пользователей

---

## Checklist внедрения

-   [x] Ленивая загрузка SmartCaptcha
-   [x] Code splitting в Vite
-   [x] Объединение общих CSS/JS файлов
-   [x] Preload критичных ресурсов
-   [ ] Оптимизация изображений (WebP)
-   [ ] Lazy loading для изображений
-   [ ] PurgeCSS для удаления неиспользуемых стилей
-   [ ] Service Worker для кеширования
-   [ ] Critical CSS инлайн
-   [ ] Оптимизация загрузки Яндекс Метрики

---

## Контакты для поддержки

При возникновении проблем:

1. Проверьте логи: `storage/logs/laravel.log`
2. Проверьте консоль браузера на ошибки JavaScript
3. Проверьте Network tab в DevTools для анализа загрузки ресурсов
