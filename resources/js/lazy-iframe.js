// Отложенная загрузка iframe для карты Яндекс
document.addEventListener("DOMContentLoaded", function () {
    const lazyIframes = document.querySelectorAll("iframe.lazy-iframe");

    if ("IntersectionObserver" in window) {
        const iframeObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const iframe = entry.target;
                        const src = iframe.getAttribute("data-src");

                        if (src) {
                            iframe.src = src;
                            iframe.removeAttribute("data-src");
                            iframe.classList.remove("lazy-iframe");
                        }

                        observer.unobserve(iframe);
                    }
                });
            },
            {
                rootMargin: "200px", // Загружаем за 200px до появления в viewport
            }
        );

        lazyIframes.forEach((iframe) => {
            iframeObserver.observe(iframe);
        });
    } else {
        // Fallback для старых браузеров
        lazyIframes.forEach((iframe) => {
            const src = iframe.getAttribute("data-src");
            if (src) {
                iframe.src = src;
            }
        });
    }
});
