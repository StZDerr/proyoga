// personal gallery initialization
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

import lightGallery from "lightgallery";
import lgZoom from "lightgallery/plugins/zoom";
import lgThumbnail from "lightgallery/plugins/thumbnail";
import "lightgallery/css/lightgallery.css";
import "lightgallery/css/lg-zoom.css";
import "lightgallery/css/lg-thumbnail.css";

import { Swiper } from "swiper";
import { Pagination, Navigation } from "swiper/modules";

document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".personal-gallery-swiper");
    if (!container) return;

    const slideCount = container.querySelectorAll(".swiper-slide").length;
    const enableLoop = slideCount >= 3;

    const personalSwiper = new Swiper(".personal-gallery-swiper", {
        modules: [Navigation, Pagination],
        slidesPerView: 1,
        spaceBetween: 20,
        loop: enableLoop,
        navigation: {
            nextEl: ".gallery3-next",
            prevEl: ".gallery3-prev",
        },
        pagination: {
            el: ".personal-gallery-pagination",
            clickable: true,
        },
        breakpoints: {
            0: { slidesPerView: 1, spaceBetween: 10 },
            768: { slidesPerView: 2, spaceBetween: 20 },
            992: { slidesPerView: 3, spaceBetween: 24 },
        },
    });

    // lightGallery
    const galleryWrapper = document.querySelector(
        ".personal-gallery-swiper .swiper-wrapper",
    );
    if (galleryWrapper) {
        const lg = lightGallery(galleryWrapper, {
            selector: "a.gallery3-item",
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
            licenseKey: "GPLv3",
        });

        // add class to body when gallery opens to hide header
        // lightGallery emits custom events on document; listen to them instead of lg.on
        document.addEventListener("lgAfterOpen", function () {
            document.body.classList.add("lightbox-open");
        });
        document.addEventListener("lgAfterClose", function () {
            document.body.classList.remove("lightbox-open");
        });
    }
});
