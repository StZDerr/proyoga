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
    const scrollThreshold = 200;
    let ticking = false;
    let lastScrollTop = 0;
    let isTransitioning = false;

    const updateHeader = (currentScroll) => {
        if (isTransitioning) {
            ticking = false;
            return;
        }

        const scrollingDown = currentScroll > lastScrollTop;
        const shouldBeScrolled = currentScroll > scrollThreshold;

        // Применяем изменения только если состояние действительно должно измениться
        // и пользователь скроллит в соответствующем направлении
        if (shouldBeScrolled && !isScrolled && scrollingDown) {
            // Скроллим вниз и прошли порог - сворачиваем
            isScrolled = true;
            isTransitioning = true;
            header.classList.add("scrolled");

            setTimeout(() => {
                isTransitioning = false;
            }, 500);
        } else if (!shouldBeScrolled && isScrolled && !scrollingDown) {
            // Скроллим вверх и вернулись выше порога - разворачиваем
            isScrolled = false;
            isTransitioning = true;
            header.classList.remove("scrolled");

            setTimeout(() => {
                isTransitioning = false;
            }, 500);
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
