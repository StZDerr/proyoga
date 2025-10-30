// импорт стилей Swiper
import "swiper/css";
import "swiper/css/navigation";

// импорт классов Swiper
import { Swiper } from "swiper";
import { Navigation } from "swiper/modules";

document.addEventListener("DOMContentLoaded", function () {
    // Инициализация свайпера преподавателей
    setTimeout(() => {
        const teachersContainer = document.querySelector(".teachers-swiper");
        if (teachersContainer) {
            console.log("Teachers swiper container found, initializing...");

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
                            console.log("Teachers swiper initialized");
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
});
