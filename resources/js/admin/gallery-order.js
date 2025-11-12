// code: импортируем Sortable из npm-пакета и реализуем отправку нового порядка через fetch
import Sortable from "sortablejs";

/**
 * Скрипт ожидает:
 * - контейнер с id="gallery-list" и data-reorder-url="URL_для_reorder"
 * - мета-тег <meta name="csrf-token" content="{{ csrf_token() }}">
 *
 * Подключается через Vite (см. ниже) — тогда route передаётся в data-атрибуте в blade.
 */

document.addEventListener("DOMContentLoaded", () => {
    const list = document.getElementById("gallery-list");
    if (!list) return;

    const reorderUrl = list.dataset.reorderUrl;
    if (!reorderUrl) {
        console.warn(
            "gallery-order: data-reorder-url not found on #gallery-list"
        );
        return;
    }

    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : null;

    // simple debounce
    function debounce(fn, wait = 300) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    const sortable = Sortable.create(list, {
        animation: 150,
        handle: ".draggable-card",
        draggable: ".gallery-item",
        onEnd: debounce(function () {
            const ids = Array.from(list.querySelectorAll(".gallery-item")).map(
                (n) => n.dataset.id
            );
            sendOrder(ids);
        }, 250),
    });

    async function sendOrder(ids) {
        try {
            const res = await fetch(reorderUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    ...(csrfToken ? { "X-CSRF-TOKEN": csrfToken } : {}),
                },
                body: JSON.stringify({ order: ids }),
            });

            if (!res.ok) {
                const text = await res.text();
                console.error("gallery-order: server error", res.status, text);
                alert("Ошибка при сохранении порядка (сервер вернул ошибку).");
                return;
            }

            const data = await res.json();
            if (data.status === "ok") {
                // обновим бейджи (если сервер вернул map id->order)
                if (data.updated && typeof data.updated === "object") {
                    for (const [id, order] of Object.entries(data.updated)) {
                        const el = list.querySelector(
                            `.gallery-item[data-id="${id}"]`
                        );
                        if (el) {
                            const badge = el.querySelector(".badge.bg-primary");
                            if (badge) badge.textContent = order;
                        }
                    }
                }
            } else {
                console.warn("gallery-order: response not ok", data);
                alert(
                    "Не удалось сохранить порядок: " +
                        (data.message || "Неизвестная ошибка")
                );
            }
        } catch (err) {
            console.error("gallery-order: fetch error", err);
            alert(
                "Ошибка при сохранении порядка. Проверьте соединение и попробуйте снова."
            );
        }
    }
});
