// импорт стилей Swiper
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

// lightGallery
import lightGallery from "lightgallery";
import lgZoom from "lightgallery/plugins/zoom";
import lgThumbnail from "lightgallery/plugins/thumbnail";
import "lightgallery/css/lightgallery.css";
import "lightgallery/css/lg-zoom.css";
import "lightgallery/css/lg-thumbnail.css";

// импорт классов Swiper
import { Swiper } from "swiper";
import { Pagination, Navigation } from "swiper/modules";

// инициализация уникального слайдера
document.addEventListener("DOMContentLoaded", function () {
    // Небольшая задержка для уверенности что все загрузилось
    setTimeout(() => {
        const swiperContainer = document.querySelector(
            ".my-custom-swiper-container"
        );

        if (swiperContainer) {
            try {
                const myCustomSwiper = new Swiper(
                    ".my-custom-swiper-container",
                    {
                        modules: [Pagination, Navigation],
                        loop: true,
                        loopedSlides: 6, // количество слайдов для создания дубликатов
                        slidesPerView: 1,
                        spaceBetween: 5,
                        centeredSlides: true,
                        // slideToClickedSlide: true,
                        initialSlide: 1, // начинаем со второго слайда для корректного отображения
                        navigation: {
                            nextEl: ".stock-next",
                            prevEl: ".stock-prev",
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        breakpoints: {
                            768: {
                                slidesPerView: 2,
                                centeredSlides: true,
                            },
                            1024: {
                                slidesPerView: 3,
                                centeredSlides: true,
                            },
                        },
                        on: {
                            init: function () {
                                // Принудительно обновляем после инициализации
                                this.update();
                                setTimeout(() => {
                                    this.updateSlides();
                                    this.updateProgress();
                                    this.updateSlidesClasses();
                                }, 50);
                            },
                            resize: function () {
                                this.update();
                            },
                        },
                    }
                );
            } catch (error) {
                console.error("Error initializing Swiper:", error);
            }
        } else {
            console.error("Swiper container not found");
        }
    }, 100);

    // Инициализация свайпера преподавателей
    setTimeout(() => {
        const teachersContainer = document.querySelector(".teachers-swiper");
        if (teachersContainer) {
            try {
                const teachersSwiper = new Swiper(".teachers-swiper", {
                    modules: [Navigation],
                    slidesPerView: 1,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: ".teachers-next",
                        prevEl: ".teachers-prev",
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                    },
                    on: {
                        init: function () {
                            // Teachers swiper инициализирован
                        },
                    },
                });
            } catch (error) {
                console.error("Error initializing Teachers Swiper:", error);
            }
        } else {
            console.error("Teachers swiper container not found");
        }
    }, 200);
    const gallery3Swiper = new Swiper(".gallery3-swiper", {
        modules: [Navigation, Pagination],
        slidesPerView: 1.5, // Показываем 1 полный + части соседних
        spaceBetween: 30,
        loop: true,
        centeredSlides: true, // Центрируем слайды
        navigation: {
            nextEl: ".gallery3-next",
            prevEl: ".gallery3-prev",
        },
        pagination: {
            el: ".gallery3-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2, // На мобильных показываем 1 + части
                spaceBetween: 15,
                centeredSlides: true,
            },
            576: {
                slidesPerView: 1.5, // Показываем 1 + половины соседних
                spaceBetween: 20,
                centeredSlides: true,
            },
            768: {
                slidesPerView: 2.2, // На больших экранах чуть больше
                spaceBetween: 30,
                centeredSlides: true,
            },
            1024: {
                slidesPerView: 2.5, // На десктопе показываем 2 + части
                spaceBetween: 30,
                centeredSlides: true,
            },
        },
        on: {
            init: function () {
                // Gallery3 swiper инициализирован
            },
        },
    });

    // Инициализация lightGallery
    const galleryWrapper = document.querySelector(
        ".gallery3-swiper .swiper-wrapper"
    );
    if (galleryWrapper) {
        lightGallery(galleryWrapper, {
            selector: "a.gallery3-item",
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
            licenseKey: "GPLv3", // Используем GPLv3 лицензию для разработки
        });
    }
});
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
