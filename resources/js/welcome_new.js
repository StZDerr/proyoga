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
            ".lightbox-media-container",
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
                    story.querySelectorAll(".story-media"),
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
                    { threshold: 0.5 },
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
                        100,
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
                }),
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
            s.addEventListener("click", () => openLightbox(i)),
        );
        mediaContainer.addEventListener("click", goToNextMedia);
        closeBtn.addEventListener("click", closeLightbox);
        lightbox.addEventListener(
            "click",
            (e) => e.target === lightbox && closeLightbox(),
        );
        document.addEventListener(
            "keydown",
            (e) =>
                e.key === "Escape" &&
                lightbox.classList.contains("active") &&
                closeLightbox(),
        );

        navPrev.addEventListener("click", () =>
            wrapper.scrollBy({
                left: -wrapper.clientWidth,
                behavior: "smooth",
            }),
        );
        navNext.addEventListener("click", () =>
            wrapper.scrollBy({ left: wrapper.clientWidth, behavior: "smooth" }),
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
            ".my-custom-swiper-container",
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
                    },
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
        ".gallery3-swiper .swiper-wrapper",
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

    // === HOLIDAY GARLAND: мигающая гирлянда с цветными лампочками ===
    (function initHolidayGarland() {
        if (
            window.matchMedia &&
            window.matchMedia("(prefers-reduced-motion: reduce)").matches
        )
            return;

        const root = document.querySelector(".back-color-ns");
        if (!root) return;

        let container = root.querySelector(".holiday-garland");
        if (!container) {
            container = document.createElement("div");
            container.className = "holiday-garland";
            container.setAttribute("aria-hidden", "true");
            root.appendChild(container);
        }

        // Inline стили для гирлянды
        container.style.position = "absolute";
        container.style.top = "30px";
        container.style.left = "0";
        container.style.width = "100%";
        container.style.height = "60px";
        container.style.pointerEvents = "none";
        container.style.zIndex = "10000";
        container.style.overflow = "visible";

        // Добавляем CSS стили для гирлянды
        if (!document.getElementById("holiday-garland-styles")) {
            const style = document.createElement("style");
            style.id = "holiday-garland-styles";
            style.textContent = `
.holiday-garland { position: relative; }
.holiday-garland .wire { position: absolute; top: 0; left: 0; width: 100%; height: 30px; }
.holiday-garland .bulb { position: relative; width: 14px; height: 20px; border-radius: 40% 40% 50% 50%; background: currentColor; box-shadow: 0 6px 18px currentColor, 0 0 28px currentColor; animation: bulb-blink 1.5s ease-in-out infinite; transform-origin: top center; border: 1px solid rgba(255,255,255,0.12); }
.holiday-garland .bulb::before { content: ''; position: absolute; top: -8px; left: 50%; transform: translateX(-50%); width: 2px; height: 8px; background: #eee; border-radius: 1px; }
.holiday-garland .bulb::after { content: ''; position: absolute; top: 3px; left: 50%; transform: translateX(-50%); width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.85); filter: blur(0.8px); box-shadow: 0 0 8px rgba(255,255,255,0.6); }
@keyframes bulb-blink { 0%, 100% { opacity: 1; filter: brightness(1.6) saturate(1.4); } 50% { opacity: 0.32; filter: brightness(0.35) saturate(0.7); } }
@media (prefers-reduced-motion: reduce) { .holiday-garland .bulb { animation: none; opacity: 1; transform: none; filter: none; } }
`;
            document.head.appendChild(style);
        }

        // Генерация волнистого провода через SVG
        const colors = [
            "#ff0044", // яркий красный
            "#00ff66", // яркий зелёный
            "#0066ff", // насыщенный синий
            "#fff200", // насыщенный жёлтый
            "#ff00c8", // фуксия
            "#00f0ff", // яркий бирюзовый
            "#ff7a00", // насыщенный оранжевый
            "#ff1493", // ярко-розовый
        ];
        const bulbCount = window.innerWidth <= 768 ? 10 : 20;
        const wire = document.createElement("div");
        wire.className = "wire";

        // Создаем SVG с волнистой линией
        const svg = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "svg",
        );
        svg.setAttribute("viewBox", "0 0 100 30");
        svg.setAttribute("preserveAspectRatio", "none");
        svg.style.position = "absolute";
        svg.style.top = "0";
        svg.style.left = "0";
        svg.style.width = "100%";
        svg.style.height = "30px";

        const path = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "path",
        );
        const amplitude = 7; // амплитуда волны
        const frequency = 3; // количество волн
        let pathData = "M 0 15 ";
        for (let i = 0; i <= 100; i++) {
            const x = i;
            const y =
                15 + amplitude * Math.sin((i / 100) * frequency * Math.PI * 2);
            pathData += `L ${x} ${y} `;
        }
        path.setAttribute("d", pathData);
        path.setAttribute("stroke", "#fff");
        path.setAttribute("stroke-width", "0.5");
        path.setAttribute("fill", "none");
        path.setAttribute("vector-effect", "non-scaling-stroke");
        svg.appendChild(path);
        wire.appendChild(svg);

        container.appendChild(wire);

        for (let i = 0; i < bulbCount; i++) {
            const bulb = document.createElement("div");
            bulb.className = "bulb";
            const color = colors[i % colors.length];
            bulb.style.color = color;
            const leftPercent = (i / (bulbCount - 1)) * 100;
            bulb.style.left = `${leftPercent}%`;
            // Позиционируем лампочки по волне (синхронизируем с параметрами SVG)
            const amplitude = 7;
            const frequency = 3;
            const waveY =
                15 +
                amplitude *
                    Math.sin((leftPercent / 100) * frequency * Math.PI * 2);
            bulb.style.top = `${waveY}px`;
            bulb.style.position = "absolute";
            bulb.style.transform = "translateX(-50%)";
            bulb.style.animationDelay = `${Math.random() * 1.5}s`;
            bulb.style.animationDuration = `${1.2 + Math.random() * 0.8}s`;
            container.appendChild(bulb);
        }
    })();

    // === HOLIDAY SNOW: бесконечные снежинки в .back-color-ns ===
    (function initHolidaySnow() {
        // Уважение к prefers-reduced-motion
        if (
            window.matchMedia &&
            window.matchMedia("(prefers-reduced-motion: reduce)").matches
        )
            return;

        const root = document.querySelector(".back-color-ns");
        if (!root) return;

        // Создаём контейнер для снежинок, если его нет
        let container = root.querySelector(".holiday-snow");
        if (!container) {
            container = document.createElement("div");
            container.className = "holiday-snow";
            container.setAttribute("aria-hidden", "true");
            // Помещаем контейнер в конец, чтобы он отрисовывался поверх фонового изображения
            root.appendChild(container);

            // Гарантируем inline-стили, если внешние CSS не подхватятся
            container.style.position = "absolute";
            container.style.inset = "0";
            container.style.pointerEvents = "none";
            container.style.zIndex = "99999";
            container.style.width = "100%";
            container.style.height = "100%";

            // Убедимся, что фон (img) находится под снежинками
            const bgImg = root.querySelector("img");
            if (bgImg) {
                bgImg.style.position = "relative";
                bgImg.style.zIndex = "1";
                bgImg.style.display = "block";
            }

            // Временная отладочная снежинка для проверки видимости (удалится через 5 сек)
            const debugFlake = document.createElement("span");
            debugFlake.className = "snowflake debug-flake";
            debugFlake.style.position = "absolute";
            debugFlake.style.left = "50%";
            debugFlake.style.top = "8px";
            debugFlake.style.fontSize = "40px";
            debugFlake.style.zIndex = "100000";
            debugFlake.style.lineHeight = "0";
            debugFlake.innerHTML = snowSVG(40);
            container.appendChild(debugFlake);
            setTimeout(() => {
                if (debugFlake.parentNode)
                    debugFlake.parentNode.removeChild(debugFlake);
            }, 5000);
        }

        // Добавляем стили один раз
        if (!document.getElementById("holiday-snow-styles")) {
            const style = document.createElement("style");
            style.id = "holiday-snow-styles";
            style.textContent = `
.holiday-snow { position: absolute; inset: 0; pointer-events: none; z-index: 9999; }
.back-color-ns { position: relative; overflow: hidden; }
.back-color-ns > img { position: relative; z-index: 1; display: block; }
/* Снежинки начинаются немного выше контейнера и падают вниз (анимация по top) */
.holiday-snow .snowflake { position: absolute; top: -10%; user-select: none; will-change: top, opacity; transform-origin: center; display: inline-block; line-height: 1; text-shadow: 0 2px 6px rgba(0,0,0,0.15); filter: drop-shadow(0 2px 6px rgba(0,0,0,0.25)); }
.holiday-snow .snowflake svg { display: block; width: auto; height: auto; max-width: 100%; max-height: 100%; pointer-events: none; }
@keyframes holiday-fall { 0% { top: -10%; transform: rotate(0deg); opacity: 0; } 10% { opacity: 1; } 100% { top: 110%; transform: rotate(360deg); opacity: 0.9; } }
@keyframes holiday-drift { 0% { transform: translateX(0); } 50% { transform: translateX(12px); } 100% { transform: translateX(0); } }
.holiday-snow .snowflake { animation-name: holiday-fall, holiday-drift; animation-timing-function: linear, ease-in-out; animation-iteration-count: 1, infinite; }
@media (prefers-reduced-motion: reduce) { .holiday-snow, .holiday-snow .snowflake { animation: none !important; opacity: .9; } }
@media (max-width: 768px) { .holiday-snow .snowflake { font-size: 12px !important; opacity: .9; } }
`;
            document.head.appendChild(style);
        }

        // Настройки генерации (увеличена плотность)
        const MIN_INTERVAL = 60; // ms
        const MAX_INTERVAL = 350; // ms
        const MAX_ACTIVE = window.innerWidth <= 768 ? 80 : 300;
        let active = 0;
        let running = true;

        function rand(min, max) {
            return Math.random() * (max - min) + min;
        }

        // Генерирует SVG снежинки белого цвета заданного размера
        function snowSVG(size) {
            const s = Math.max(8, Math.round(size));
            const stroke = Math.max(1, Math.round(s / 12));
            return `<svg viewBox="0 0 24 24" width="${s}" height="${s}" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><g stroke="#ffffff" stroke-width="${stroke}" stroke-linecap="round" stroke-linejoin="round" fill="none"><line x1="12" y1="2" x2="12" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="4.5" y1="4.5" x2="19.5" y2="19.5"/><line x1="19.5" y1="4.5" x2="4.5" y2="19.5"/></g></svg>`;
        }

        function createFlake() {
            if (!running || active >= MAX_ACTIVE) return;
            const el = document.createElement("span");
            el.className = "snowflake";
            el.setAttribute("aria-hidden", "true");
            // определяем размер сначала
            const size = Math.floor(
                rand(
                    window.innerWidth <= 768 ? 9 : 12,
                    window.innerWidth <= 768 ? 18 : 40,
                ),
            );
            el.innerHTML = snowSVG(size);
            el.style.lineHeight = "0";
            el.style.left = Math.random() * 100 + "%";
            el.style.fontSize = size + "px";
            const duration = rand(6.5, 14.5);
            el.style.animationDuration = duration + "s, " + rand(3, 7) + "s";
            el.style.animationDelay = "0s, " + rand(0, 1.2) + "s";
            el.style.opacity = rand(0.45, 0.98).toFixed(2);
            container.appendChild(el);
            active++;

            // Небольшой кластер рядом иногда
            if (Math.random() < 0.14) {
                const extraCount = Math.floor(rand(1, 4));
                for (let i = 0; i < extraCount; i++) {
                    if (active >= MAX_ACTIVE) break;
                    const ex = document.createElement("span");
                    ex.className = "snowflake";
                    ex.setAttribute("aria-hidden", "true");
                    ex.innerHTML = snowSVG(12);
                    ex.style.lineHeight = "0";
                    const baseLeft = parseFloat(el.style.left);
                    const offset = (Math.random() - 0.5) * 6; // небольшой сдвиг
                    ex.style.left = `calc(${baseLeft}% + ${offset}px)`;
                    const exSize = Math.floor(
                        rand(Math.max(8, size - 6), size),
                    );
                    ex.style.fontSize = exSize + "px";
                    ex.style.animationDuration =
                        rand(duration * 0.75, duration * 1.1) +
                        "s, " +
                        rand(3, 7) +
                        "s";
                    ex.style.animationDelay = "0s, " + rand(0, 1.2) + "s";
                    ex.style.opacity = rand(0.4, 0.9).toFixed(2);
                    container.appendChild(ex);
                    active++;
                    ex.addEventListener(
                        "animationend",
                        function onEndEx() {
                            ex.removeEventListener("animationend", onEndEx);
                            if (ex.parentNode) ex.parentNode.removeChild(ex);
                            active--;
                        },
                        { once: true },
                    );
                }
            }

            el.addEventListener(
                "animationend",
                function onEnd() {
                    el.removeEventListener("animationend", onEnd);
                    if (el.parentNode) el.parentNode.removeChild(el);
                    active--;
                },
                { once: true },
            );
        }

        // Быстрый старт — начальный всплеск снежинок
        function initialBurst() {
            const burstCount = window.innerWidth <= 768 ? 18 : 60;
            for (let i = 0; i < burstCount; i++) {
                setTimeout(createFlake, Math.floor(rand(0, 900)));
            }
        }

        function scheduleNext() {
            const interval = Math.floor(rand(MIN_INTERVAL, MAX_INTERVAL));
            setTimeout(function () {
                createFlake();
                scheduleNext();
            }, interval);
        }

        initialBurst();
        scheduleNext();

        document.addEventListener("visibilitychange", function () {
            running = !document.hidden;
        });
    })();

    // === ИНИЦИАЛИЗАЦИЯ ТАЙМЕРА ПРОМО ===
    (function initPromoCountdown() {
        const STORAGE_KEY = "promo_target_ts";
        const timerRoot = document.getElementById("promo-timer");
        if (!timerRoot) return;

        function parseDateString(s) {
            if (!s) return null;
            s = s.trim();
            if (/^\d{4}-\d{2}-\d{2}$/.test(s)) return new Date(s + "T23:59:59");
            const d = new Date(s);
            return isNaN(d.getTime()) ? null : d;
        }

        const promoCards = Array.from(
            document.querySelectorAll(".promotion-card"),
        );
        const now = new Date();
        let target = null;

        // Try to load stored target first — prevents restart on page reload
        try {
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored) {
                const ts = Date.parse(stored);
                if (!isNaN(ts)) {
                    target = new Date(ts);
                } else {
                    localStorage.removeItem(STORAGE_KEY);
                }
            }
        } catch (e) {
            // localStorage may be unavailable (privacy mode) — ignore
            console.warn("localStorage unavailable for promo timer", e);
        }

        // If no stored target, compute from promo cards or fallback and store it
        if (!target) {
            promoCards.forEach((card) => {
                const end = card.dataset.end;
                const d = parseDateString(end);
                if (d && d > now && (!target || d < target)) target = d;
            });

            if (!target) {
                // fallback: 3 days from now
                target = new Date(Date.now() + 3 * 24 * 3600 * 1000);
            }

            try {
                localStorage.setItem(STORAGE_KEY, target.toISOString());
            } catch (e) {
                // ignore
            }
        }

        const elDays = document.getElementById("count-days");
        const elHours = document.getElementById("count-hours");
        const elMin = document.getElementById("count-minutes");
        const elSec = document.getElementById("count-seconds");

        function pad(v) {
            return String(v).padStart(2, "0");
        }

        function update() {
            const diff = target - new Date();
            if (diff <= 0) {
                elDays.textContent = "00";
                elHours.textContent = "00";
                elMin.textContent = "00";
                elSec.textContent = "00";
                clearInterval(interval);
                return;
            }
            let s = Math.floor(diff / 1000);
            const days = Math.floor(s / 86400);
            s %= 86400;
            const hours = Math.floor(s / 3600);
            s %= 3600;
            const minutes = Math.floor(s / 60);
            const seconds = s % 60;

            elDays.textContent = pad(days);
            elHours.textContent = pad(hours);
            elMin.textContent = pad(minutes);
            elSec.textContent = pad(seconds);
        }

        update();
        const interval = setInterval(update, 1000);
    })();

    // === SPIN POPUP: open/close handlers ===
    (function initSpinPopup() {
        const spinBtn = document.querySelector(".spin-cta-button");
        const spinPopup = document.getElementById("spinPopup");
        if (!spinBtn || !spinPopup) return;

        const spinClose = spinPopup.querySelector(".spin-popup__close");
        const spinBackdrop = spinPopup.querySelector(".spin-popup__backdrop");

        function openSpinPopup() {
            try {
                if (spinPopup.parentElement !== document.body)
                    document.body.appendChild(spinPopup);
            } catch (e) {}
            spinPopup.classList.add("is-open");
            spinPopup.setAttribute("aria-hidden", "false");
            document.body.style.overflow = "hidden";
            const phone = spinPopup.querySelector(".spin-input");
            if (phone) phone.focus();
        }

        function closeSpinPopup() {
            spinPopup.classList.remove("is-open");
            spinPopup.setAttribute("aria-hidden", "true");
            document.body.style.overflow = "";
        }

        spinBtn.addEventListener("click", (e) => {
            e.preventDefault();
            openSpinPopup();
        });

        if (spinClose) spinClose.addEventListener("click", closeSpinPopup);
        if (spinBackdrop)
            spinBackdrop.addEventListener("click", closeSpinPopup);
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && spinPopup.classList.contains("is-open"))
                closeSpinPopup();
        });
    })();
});
