document.addEventListener("DOMContentLoaded", () => {
    const menuToggle = document.getElementById("menuToggle");
    const menu = document.getElementById("menu");
    const overlay = document.querySelector(".overlay"); // Добавляем поиск overlay

    if (!menuToggle || !menu) {
        // burger.js: элементы меню не найдены
        return;
    }

    const toggleMenu = () => {
        menuToggle.classList.toggle("active");
        menu.classList.toggle("show");
        document.body.classList.toggle("menu-open"); // блокируем скролл
    };

    menuToggle.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    // Добавляем проверку существования overlay
    if (overlay) {
        overlay.addEventListener("click", () => toggleMenu());
    }

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && menu.classList.contains("show")) {
            toggleMenu();
        }
    });
});
