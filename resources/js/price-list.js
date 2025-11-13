import lightGallery from "lightgallery";
import "lightgallery/css/lightgallery.css";

// Ждем загрузки DOM
document.addEventListener("DOMContentLoaded", function () {
    // === Переключение категорий ===
    document.querySelectorAll(".category-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            // Снимаем активность со всех кнопок
            document.querySelectorAll(".category-btn").forEach((b) => {
                b.classList.remove("active");
                b.classList.add("inactive");
            });

            // Активируем текущую
            this.classList.remove("inactive");
            this.classList.add("active");

            // Скрываем все контенты
            document.querySelectorAll(".content-text").forEach((text) => {
                text.classList.remove("active");
            });

            // Показываем нужный контент
            const targetId = this.getAttribute("data-target");
            const targetText = document.getElementById(targetId);
            if (targetText) {
                targetText.classList.add("active");
            }
        });
    });

    // === Инициализация LightGallery для изображений ===
    const lightboxElements = document.querySelectorAll(
        ".content-text.active .lightbox, .content-text:not(.active) .lightbox"
    );
    lightboxElements.forEach((el) => {
        lightGallery(el, {
            selector: "this",
            download: false, // отключаем кнопку скачивания
            licenseKey: window.LG_LICENSE_KEY || undefined,

            // plugins: [lgZoom, lgThumbnail], // если используете плагины
        });
    });
});
