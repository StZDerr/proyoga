import "@tabler/core/dist/js/tabler.min.js";

// Инициализация админ панели
document.addEventListener("DOMContentLoaded", function () {
    // Простая анимация загрузки статистики
    const statCards = document.querySelectorAll(".card-body .h1");
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = "0";
            card.style.transform = "translateY(20px)";
            card.style.transition = "all 0.6s ease";

            setTimeout(() => {
                card.style.opacity = "1";
                card.style.transform = "translateY(0)";
            }, 100);
        }, index * 200);
    });

    // Добавление интерактивности к прогресс барам
    const progressBars = document.querySelectorAll(".progress-bar");
    progressBars.forEach((bar) => {
        const width = bar.style.width;
        bar.style.width = "0%";
        bar.style.transition = "width 1.5s ease-in-out";

        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });

    // Обновление времени в режиме реального времени
    function updateTime() {
        const timeElements = document.querySelectorAll("[data-time]");
        timeElements.forEach((element) => {
            const time = new Date(element.dataset.time);
            const now = new Date();
            const diff = Math.floor((now - time) / 1000 / 60); // в минутах

            if (diff < 60) {
                element.textContent = `${diff}м назад`;
            } else if (diff < 1440) {
                element.textContent = `${Math.floor(diff / 60)}ч назад`;
            } else {
                element.textContent = `${Math.floor(diff / 1440)}д назад`;
            }
        });
    }

    // Обновляем время каждую минуту
    updateTime();
    setInterval(updateTime, 60000);

    // Добавление эффекта при клике на карточки
    const cards = document.querySelectorAll(".card");
    cards.forEach((card) => {
        card.addEventListener("click", function (e) {
            // Создаем эффект ripple
            const ripple = document.createElement("div");
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                pointer-events: none;
            `;

            this.style.position = "relative";
            this.style.overflow = "hidden";
            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // CSS для анимации ripple
    const style = document.createElement("style");
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    console.log("🧘‍♀️ Админ панель ИстокиЯ инициализирована");
});
