// Только переключение — без хранения текстов!
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

        // Скрываем все тексты
        document.querySelectorAll(".content-text").forEach((text) => {
            text.classList.remove("active");
        });

        // Показываем нужный текст
        const targetId = this.getAttribute("data-target");
        const targetText = document.getElementById(targetId);
        if (targetText) {
            targetText.classList.add("active");
        }
    });
});
