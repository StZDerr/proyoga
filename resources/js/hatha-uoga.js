// lightGallery
import lightGallery from "lightgallery";
import lgZoom from "lightgallery/plugins/zoom";
import lgThumbnail from "lightgallery/plugins/thumbnail";
import "lightgallery/css/lightgallery.css";
import "lightgallery/css/lg-zoom.css";
import "lightgallery/css/lg-thumbnail.css";

// импорт стилей Swiper
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

// импорт классов Swiper
import { Swiper } from "swiper";
import { Pagination, Navigation } from "swiper/modules";

document.addEventListener("DOMContentLoaded", function () {
    // === ИНИЦИАЛИЗАЦИЯ SWIPER (галерея 3) ===
    const gallery3Container = document.querySelector(".gallery3-swiper");
    if (gallery3Container) {
        const slideCount =
            gallery3Container.querySelectorAll(".swiper-slide").length;

        // логика: включаем loop/centered только при трех и более слайдах
        const enableLoop = slideCount >= 4;
        const centered = slideCount >= 4;

        // желаемые slidesPerView для брейкпоинтов (будем ограничивать значением slideCount)
        const desired = {
            0: 1.2,
            576: 1.5,
            768: 2.2,
            1024: 2.5,
        };

        const breakpoints = {};
        Object.keys(desired).forEach((bp) => {
            let val = Math.min(desired[bp], slideCount);
            if (slideCount < 2) val = 1;
            // для двух слайдов лучше показывать по одному
            if (slideCount === 2) val = 1;

            breakpoints[bp] = {
                slidesPerView: val,
                spaceBetween: bp >= 768 ? 30 : bp >= 576 ? 20 : 15,
                centeredSlides: centered && val > 1,
            };
        });

        // если ровно 2 слайда — отключаем центрирование и loop
        if (slideCount === 2) {
            Object.keys(breakpoints).forEach((bp) => {
                breakpoints[bp].slidesPerView = 1;
                breakpoints[bp].centeredSlides = false;
            });
        }

        const gallery3Swiper = new Swiper(".gallery3-swiper", {
            modules: [Navigation, Pagination],
            loop: enableLoop,
            centeredSlides: centered,
            watchOverflow: true,
            navigation: {
                nextEl: ".gallery3-next",
                prevEl: ".gallery3-prev",
            },
            pagination: {
                el: ".gallery3-pagination",
                clickable: true,
            },
            breakpoints: breakpoints,
        });
    }

    // === ИНИЦИАЛИЗАЦИЯ lightGallery ===
    const galleryWrapper = document.querySelector(
        ".gallery3-swiper .swiper-wrapper"
    );
    if (galleryWrapper) {
        lightGallery(galleryWrapper, {
            selector: "a.gallery3-item",
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
            licenseKey: "GPLv3",
        });
    }
});
