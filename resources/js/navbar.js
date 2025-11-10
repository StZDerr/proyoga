document.addEventListener("DOMContentLoaded", () => {
    const menuToggle = document.getElementById("menuToggle");
    const menu = document.getElementById("menu");
    const overlay = document.querySelector(".overlay"); // Добавляем поиск overlay
    const header = document.querySelector(".site-header");

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

    // Функция для скрытия элементов при скролле
    let isScrolled = false;
    const scrollThreshold = 100; // Порог для сворачивания
    let ticking = false;
    let lastScrollTop = 0;

    const updateHeader = (currentScroll) => {
        // Определяем направление скролла
        const scrollingDown = currentScroll > lastScrollTop;

        // Сворачиваем только при скролле вниз и превышении порога
        if (scrollingDown && currentScroll > scrollThreshold && !isScrolled) {
            isScrolled = true;
            header.classList.add("scrolled");
        }
        // Разворачиваем только когда вернулись в самый верх (0-10px)
        else if (currentScroll < 10 && isScrolled) {
            isScrolled = false;
            header.classList.remove("scrolled");
        }

        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        ticking = false;
    };

    const requestTick = (scrollTop) => {
        if (!ticking) {
            window.requestAnimationFrame(() => updateHeader(scrollTop));
            ticking = true;
        }
    };

    window.addEventListener(
        "scroll",
        () => {
            const scrollTop =
                window.pageYOffset || document.documentElement.scrollTop;
            requestTick(scrollTop);
        },
        { passive: true }
    );
});
