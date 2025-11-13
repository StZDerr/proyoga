import Swiper from "swiper";
import "swiper/css";

document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".gallery3-swiper", {
        slidesPerView: 3,
        spaceBetween: 20,
        navigation: {
            nextEl: ".gallery3-next",
            prevEl: ".gallery3-prev",
        },
        breakpoints: {
            1200: { slidesPerView: 3 },
            768: { slidesPerView: 2 },
            0: { slidesPerView: 1 },
        },
        loop: true,
    });
});
