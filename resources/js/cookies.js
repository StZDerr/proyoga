// Управление Cookie-попапом (чистый JS, без зависимостей)
document.addEventListener("DOMContentLoaded", () => {
    const cookiePopup = document.getElementById("cookiePopup");
    const cookieIcon = document.getElementById("cookieIcon");
    const saveBtn = document.getElementById("saveCookieSettings");
    const headers = document.querySelectorAll(".cookie-header");

    const LOCAL_KEY = "cookieSettings";

    // Установить видимость по сохранённым настройкам
    function applySaved() {
        try {
            const saved = JSON.parse(localStorage.getItem(LOCAL_KEY));
            if (!saved) {
                // показываем иконку, скрываем попап
                cookiePopup.setAttribute("aria-hidden", "true");
                cookiePopup.style.display = "none";
                cookieIcon.style.display = "block";
                return;
            }
            // если настройки есть — не показываем больше попап/иконку
            cookiePopup.setAttribute("aria-hidden", "true");
            cookiePopup.style.display = "none";
            cookieIcon.style.display = "none";

            // установить чекбоксы в соответствии с сохранением (если нужно)
            document.getElementById("technical-cookie").checked =
                !!saved.technical;
            document.getElementById("analytics-cookie").checked =
                !!saved.analytics;
            document.getElementById("functional-cookie").checked =
                !!saved.functional;
        } catch (e) {
            // при ошибке в localStorage просто показываем иконку
            cookiePopup.setAttribute("aria-hidden", "true");
            cookiePopup.style.display = "none";
            cookieIcon.style.display = "block";
            console.warn("cookieSettings parse error", e);
        }
    }

    // Показать/скрыть попап
    function openPopup() {
        cookiePopup.style.display = "block";
        // небольшая задержка чтобы сработал transition, если используется
        requestAnimationFrame(() => {
            cookiePopup.setAttribute("aria-hidden", "false");
            cookieIcon.style.display = "none";
            cookieIcon.setAttribute("aria-hidden", "true");
        });
    }
    function closePopup() {
        cookiePopup.setAttribute("aria-hidden", "true");
        // скрывать полностью после анимации
        setTimeout(() => {
            if (cookiePopup.getAttribute("aria-hidden") === "true") {
                cookiePopup.style.display = "none";
                cookieIcon.style.display = "block";
                cookieIcon.setAttribute("aria-hidden", "false");
            }
        }, 280);
    }

    // Переключение открытого контента в категориях
    function toggleContent(target) {
        const content = document.getElementById(target + "-content");
        if (!content) return;
        const isActive = content.classList.contains("active");
        // закрываем все
        document
            .querySelectorAll(".cookie-content")
            .forEach((c) => c.classList.remove("active"));
        if (!isActive) content.classList.add("active");
    }

    // Сохранить настройки
    function saveCookieSettings() {
        const technical = document.getElementById("technical-cookie").checked;
        const analytics = document.getElementById("analytics-cookie").checked;
        const functional = document.getElementById("functional-cookie").checked;

        const cookieSettings = {
            technical,
            analytics,
            functional,
            timestamp: new Date().getTime(),
        };
        localStorage.setItem(LOCAL_KEY, JSON.stringify(cookieSettings));

        // скрываем попап и икону (пользователь дал ответ)
        cookiePopup.setAttribute("aria-hidden", "true");
        cookiePopup.style.display = "none";
        cookieIcon.style.display = "none";
        console.log("Cookie settings saved:", cookieSettings);

        // тут можно инициализировать аналитические скрипты, если analytics=true
    }

    // Ивенты
    cookieIcon && cookieIcon.addEventListener("click", openPopup);
    cookieIcon &&
        cookieIcon.addEventListener("keydown", (e) => {
            if (e.key === "Enter" || e.key === " ") openPopup();
        });

    saveBtn && saveBtn.addEventListener("click", saveCookieSettings);

    headers.forEach((h) => {
        h.addEventListener("click", () => {
            const t = h.dataset.target;
            toggleContent(t);
        });
    });

    // Закрытие попапа по ESC
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closePopup();
        }
    });

    // Клик вне попапа — закрывает (удобно на десктопе)
    document.addEventListener("click", (e) => {
        if (!cookiePopup || !cookieIcon) return;
        if (cookiePopup.contains(e.target) || cookieIcon.contains(e.target))
            return;
        // если открыт — закрываем
        if (cookiePopup.getAttribute("aria-hidden") === "false") closePopup();
    });

    // Инициализация: применяем сохранённое состояние
    applySaved();

    // При ресайзе — закрываем раскрытые секции на мобильных
    window.addEventListener("resize", () => {
        if (window.innerWidth <= 700)
            document
                .querySelectorAll(".cookie-content")
                .forEach((c) => c.classList.remove("active"));
    });
});
