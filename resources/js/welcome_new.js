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

document.addEventListener("DOMContentLoaded", function () {
    // === ИНИЦИАЛИЗАЦИЯ STORIES ===
    (function initializeStories() {
        const wrapper = document.getElementById("storiesWrapper");
        if (!wrapper) return;

        const stories = wrapper.querySelectorAll(".story");
        const lightbox = document.getElementById("lightbox");
        const mediaContainer = lightbox.querySelector(
            ".lightbox-media-container"
        );
        const progressContainer = lightbox.querySelector(".progress-container");
        const closeBtn = lightbox.querySelector(".lightbox-close");
        const navPrev = document.getElementById("navPrev");
        const navNext = document.getElementById("navNext");

        let currentStoryIndex = 0;
        let currentMediaIndex = 0;
        let mediaItems = [];
        let progressBars = [];
        let autoAdvanceInterval = null;
        let mediaDuration = 0;
        const PHOTO_DURATION = 15;

        const viewedMedia = new Map();

        // === ОПРЕДЕЛЕНИЕ ТИПА ФАЙЛА ===
        const getMediaType = (src) => {
            const ext = src.split(".").pop().toLowerCase();
            return ["mp4", "webm", "ogg", "mov", "avi"].includes(ext)
                ? "video"
                : "image";
        };

        // === ПРОСМОТРЕННЫЕ ===
        const markMediaAsViewed = (storyIdx, mediaIdx) => {
            if (!viewedMedia.has(storyIdx))
                viewedMedia.set(storyIdx, new Set());
            viewedMedia.get(storyIdx).add(mediaIdx);
            updateStoryBorders();
        };

        const isStoryFullyViewed = (storyIdx) => {
            const els = stories[storyIdx].querySelectorAll(".story-media");
            const viewed = viewedMedia.get(storyIdx) || new Set();
            return els.length > 0 && viewed.size === els.length;
        };

        const updateStoryBorders = () => {
            stories.forEach((story, i) => {
                const viewed = isStoryFullyViewed(i);
                story.classList.toggle("viewed", viewed);
                const av = story.querySelector(".avatar");
                if (av) {
                    av.style.border = viewed
                        ? "3px solid #e0e0e0"
                        : "3px solid #2ecc71";
                    av.style.padding = viewed ? "5px" : "4px";
                }
            });
        };

        // === ПРОГРЕСС-БАРЫ ===
        const createProgressBars = () => {
            progressContainer.innerHTML = "";
            progressBars = [];
            mediaItems.forEach((_, i) => {
                const bar = document.createElement("div");
                bar.className = "progress-bar";
                const fill = document.createElement("div");
                fill.className = "progress-fill";
                bar.appendChild(fill);
                progressContainer.appendChild(bar);
                progressBars.push(fill);
            });
        };

        const resetProgress = () => {
            progressBars.forEach((fill, i) => {
                fill.style.width = i < currentMediaIndex ? "100%" : "0%";
            });
        };

        // === ЗАГРУЗКА МЕДИА ===
        const loadCurrentMedia = () => {
            const item = mediaItems[currentMediaIndex];
            const isVideo = item.type === "video";

            mediaContainer.innerHTML = "";

            if (isVideo) {
                const video = document.createElement("video");
                video.className = "lightbox-video";
                video.src = item.src;
                video.muted = false;
                video.playsInline = true;
                mediaContainer.appendChild(video);

                video.oncanplay = () => {
                    mediaDuration = video.duration || 5;
                    video.play().catch(() => {});
                    createProgressBars();
                    resetProgress();
                    startAutoAdvance();
                };

                video.onerror = () => {
                    mediaDuration = 5;
                    createProgressBars();
                    resetProgress();
                    startAutoAdvance();
                };
            } else {
                const img = new Image();
                img.className = "lightbox-image";
                img.src = item.src;
                img.alt = "Story photo";

                img.onload = () => {
                    mediaContainer.appendChild(img);
                    mediaDuration = PHOTO_DURATION;
                    createProgressBars();
                    resetProgress();
                    startAutoAdvance();
                };

                img.onerror = () => {
                    mediaDuration = PHOTO_DURATION;
                    createProgressBars();
                    resetProgress();
                    startAutoAdvance();
                };
            }
        };

        // === ПЕРЕХОД К СЛЕДУЮЩЕМУ МЕДИА ===
        const goToNextMedia = () => {
            markMediaAsViewed(currentStoryIndex, currentMediaIndex);

            if (currentMediaIndex < mediaItems.length - 1) {
                currentMediaIndex++;
                loadCurrentMedia();
            } else {
                closeLightbox();
            }
        };

        // === АВТОПРОКРУТКА ===
        const startAutoAdvance = () => {
            clearInterval(autoAdvanceInterval);
            const startTime = Date.now();

            autoAdvanceInterval = setInterval(() => {
                const elapsed = (Date.now() - startTime) / 1000;
                const percent = (elapsed / mediaDuration) * 100;
                if (progressBars[currentMediaIndex]) {
                    progressBars[currentMediaIndex].style.width = `${Math.min(
                        percent,
                        100
                    )}%`;
                }
                if (elapsed >= mediaDuration) {
                    goToNextMedia();
                }
            }, 50);
        };

        // === ОТКРЫТИЕ ЛАЙТБОКСА ===
        const openLightbox = (idx) => {
            currentStoryIndex = idx;
            const story = stories[idx];
            mediaItems = Array.from(story.querySelectorAll(".story-media")).map(
                (el) => ({
                    src: el.dataset.src,
                    type: getMediaType(el.dataset.src),
                })
            );
            currentMediaIndex = 0;

            loadCurrentMedia();
            lightbox.classList.add("active");
            updateStoryBorders();
            scrollToStory(idx);
        };

        // === ЗАКРЫТИЕ ЛАЙТБОКСА ===
        const closeLightbox = () => {
            lightbox.classList.remove("active");
            clearInterval(autoAdvanceInterval);
            mediaContainer.innerHTML = "";
        };

        // === ПРОКРУТКА ===
        const STORY_WIDTH = 194;

        const updateLayout = () => {
            const contW = wrapper.parentElement.clientWidth;
            const totalW = stories.length * STORY_WIDTH - 24;
            const needsScroll = totalW > contW;

            wrapper.style.justifyContent = needsScroll
                ? "flex-start"
                : "center";
            wrapper.style.scrollSnapType = needsScroll ? "x mandatory" : "none";

            navPrev.style.display = needsScroll ? "flex" : "none";
            navNext.style.display = needsScroll ? "flex" : "none";
            updateNavButtons();
        };

        const scrollToStory = (idx) => {
            const story = stories[idx];
            const offset =
                story.offsetLeft -
                wrapper.parentElement.clientWidth / 2 +
                story.offsetWidth / 2;
            wrapper.scrollTo({ left: offset, behavior: "smooth" });
        };

        const updateNavButtons = () => {
            const max = wrapper.scrollWidth - wrapper.clientWidth;
            const atStart = wrapper.scrollLeft <= 10;
            const atEnd = wrapper.scrollLeft >= max - 10;

            navPrev.style.opacity = atStart ? "0" : "1";
            navPrev.style.pointerEvents = atStart ? "none" : "auto";
            navNext.style.opacity = atEnd ? "0" : "1";
            navNext.style.pointerEvents = atEnd ? "none" : "auto";
        };

        // === СОБЫТИЯ ===
        stories.forEach((s, i) =>
            s.addEventListener("click", () => openLightbox(i))
        );
        mediaContainer.addEventListener("click", goToNextMedia);
        closeBtn.addEventListener("click", closeLightbox);
        lightbox.addEventListener(
            "click",
            (e) => e.target === lightbox && closeLightbox()
        );
        document.addEventListener(
            "keydown",
            (e) =>
                e.key === "Escape" &&
                lightbox.classList.contains("active") &&
                closeLightbox()
        );

        navPrev.addEventListener("click", () =>
            wrapper.scrollBy({ left: -wrapper.clientWidth, behavior: "smooth" })
        );
        navNext.addEventListener("click", () =>
            wrapper.scrollBy({ left: wrapper.clientWidth, behavior: "smooth" })
        );

        wrapper.addEventListener("scroll", updateNavButtons);
        window.addEventListener("resize", updateLayout);

        // === ИНИЦИАЛИЗАЦИЯ ===
        updateStoryBorders();
        updateLayout();
        setTimeout(updateLayout, 100);
    })();

    // === ИНИЦИАЛИЗАЦИЯ SWIPER (основной) ===
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
                        loopedSlides: 6,
                        slidesPerView: 1,
                        spaceBetween: 5,
                        centeredSlides: true,
                        initialSlide: 1,
                        navigation: {
                            nextEl: ".stock-next",
                            prevEl: ".stock-prev",
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        breakpoints: {
                            768: { slidesPerView: 2, centeredSlides: true },
                            1024: { slidesPerView: 3, centeredSlides: true },
                        },
                        on: {
                            init: function () {
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
        }
    }, 100);

    // === ИНИЦИАЛИЗАЦИЯ SWIPER (преподаватели) ===
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
                        640: { slidesPerView: 2, spaceBetween: 20 },
                        768: { slidesPerView: 3, spaceBetween: 30 },
                        1024: { slidesPerView: 4, spaceBetween: 30 },
                    },
                });
            } catch (error) {
                console.error("Error initializing Teachers Swiper:", error);
            }
        }
    }, 200);

    // === ИНИЦИАЛИЗАЦИЯ SWIPER (галерея 3) ===
    const gallery3Swiper = new Swiper(".gallery3-swiper", {
        modules: [Navigation, Pagination],
        slidesPerView: 1.5,
        spaceBetween: 30,
        loop: true,
        centeredSlides: true,
        navigation: {
            nextEl: ".gallery3-next",
            prevEl: ".gallery3-prev",
        },
        pagination: {
            el: ".gallery3-pagination",
            clickable: true,
        },
        breakpoints: {
            0: { slidesPerView: 1.2, spaceBetween: 15, centeredSlides: true },
            576: { slidesPerView: 1.5, spaceBetween: 20, centeredSlides: true },
            768: { slidesPerView: 2.2, spaceBetween: 30, centeredSlides: true },
            1024: {
                slidesPerView: 2.5,
                spaceBetween: 30,
                centeredSlides: true,
            },
        },
    });

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

    // === ПЕРЕКЛЮЧЕНИЕ КАТЕГОРИЙ (текст) ===
    document.querySelectorAll(".category-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            document.querySelectorAll(".category-btn").forEach((b) => {
                b.classList.remove("active");
                b.classList.add("inactive");
            });

            this.classList.remove("inactive");
            this.classList.add("active");

            document.querySelectorAll(".content-text").forEach((text) => {
                text.classList.remove("active");
            });

            const targetId = this.getAttribute("data-target");
            const targetText = document.getElementById(targetId);
            if (targetText) {
                targetText.classList.add("active");
            }
        });
    });
});
