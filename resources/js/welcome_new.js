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

        // === ПРЕВЬЮ АВАТАРОВ (видео в кружках) ===
        const initAvatarPreviews = () => {
            const avatarVideos = [];

            stories.forEach((story) => {
                const avatarImg = story.querySelector(".avatar");
                if (!avatarImg) return;

                const mediaEls = Array.from(
                    story.querySelectorAll(".story-media")
                );
                const videoSrc = mediaEls
                    .map((el) => el.dataset.src)
                    .find((src) => src && getMediaType(src) === "video");

                if (!videoSrc) return;

                const video = document.createElement("video");
                video.className = "avatar avatar-video";
                video.src = videoSrc;
                video.muted = true;
                video.loop = true;
                video.autoplay = true;
                video.playsInline = true;
                video.preload = "metadata";

                video.style.objectFit = "cover";
                video.style.width = avatarImg.width
                    ? `${avatarImg.width}px`
                    : "80px";
                video.style.height = avatarImg.height
                    ? `${avatarImg.height}px`
                    : "80px";
                video.style.borderRadius = "50%";
                video.style.display = "block";

                try {
                    const imgStyle = window.getComputedStyle(avatarImg);
                    if (imgStyle.border) video.style.border = imgStyle.border;
                    if (imgStyle.padding)
                        video.style.padding = imgStyle.padding;
                } catch (e) {}

                avatarImg.replaceWith(video);
                avatarVideos.push(video);

                // Некоторый браузеры требуют явного вызова play()
                video.play().catch(() => {});
            });

            if (avatarVideos.length) {
                const io = new IntersectionObserver(
                    (entries) => {
                        entries.forEach((entry) => {
                            const v = entry.target;
                            if (entry.isIntersecting) v.play().catch(() => {});
                            else v.pause();
                        });
                    },
                    { threshold: 0.5 }
                );

                avatarVideos.forEach((v) => io.observe(v));
            }
        };

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
            document.body.classList.add("lightbox-open"); // Добавить класс на body
            updateStoryBorders();
            scrollToStory(idx);
        };

        // === ЗАКРЫТИЕ ЛАЙТБОКСА ===
        const closeLightbox = () => {
            lightbox.classList.remove("active");
            document.body.classList.remove("lightbox-open"); // Убрать класс с body
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
        initAvatarPreviews();
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
                const slideCount =
                    swiperContainer.querySelectorAll(".swiper-slide").length;
                // Loop требует минимум slidesPerView * 2 слайдов
                // При 3 slidesPerView нужно минимум 6 слайдов
                const enableLoop = slideCount >= 6;

                const myCustomSwiper = new Swiper(
                    ".my-custom-swiper-container",
                    {
                        modules: [Pagination, Navigation],
                        loop: enableLoop,
                        loopedSlides: enableLoop ? 6 : undefined,
                        slidesPerView: 1,
                        spaceBetween: 5,
                        centeredSlides: true,
                        initialSlide: enableLoop ? 1 : 0,
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
    const gallery3Container = document.querySelector(".gallery3-swiper");
    if (gallery3Container) {
        const slideCount =
            gallery3Container.querySelectorAll(".swiper-slide").length;
        // Loop включается только если слайдов достаточно (минимум 3 для безопасности)
        const enableLoop = slideCount >= 3;

        const gallery3Swiper = new Swiper(".gallery3-swiper", {
            modules: [Navigation, Pagination],
            slidesPerView: 1.5,
            spaceBetween: 30,
            loop: enableLoop,
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
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 15,
                    centeredSlides: true,
                },
                576: {
                    slidesPerView: 1.5,
                    spaceBetween: 20,
                    centeredSlides: true,
                },
                768: {
                    slidesPerView: 2.2,
                    spaceBetween: 30,
                    centeredSlides: true,
                },
                1024: {
                    slidesPerView: 2.5,
                    spaceBetween: 30,
                    centeredSlides: true,
                },
            },
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
