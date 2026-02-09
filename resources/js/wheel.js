document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("wheelDynamic");
    if (!container) return;

    const spinDurationMs = 7500;
    const spinTurns = 6;
    let segmentsCache = [];
    let wheelSvg = null;
    let currentRotation = 0;
    let isSpinning = false;

    const modal = document.querySelector(".spin-modal");
    const modalPrize = modal?.querySelector("[data-spin-prize]");
    const modalPhone = modal?.querySelector("[data-spin-phone]");
    const modalClose = modal?.querySelector(".spin-modal__close");
    const modalBackdrop = modal?.querySelector(".spin-modal__backdrop");
    const modalContent = modal?.querySelector(".spin-modal__content");
    const modalAction = modal?.querySelector(".spin-modal__action");

    const openModal = (prizeName, phone) => {
        if (!modal) {
            return;
        }
        if (modalPrize) modalPrize.textContent = prizeName || "—";
        if (modalPhone) modalPhone.textContent = phone || "—";
        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");

        // Ensure modal is a direct child of body (avoid stacking context issues)
        try {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
        } catch (e) {
            // ignore
        }

        document.body.style.overflow = "hidden";
    };

    const closeModal = () => {
        if (!modal) return;
        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    };

    if (modalClose) modalClose.addEventListener("click", closeModal);
    if (modalBackdrop) modalBackdrop.addEventListener("click", closeModal);
    if (modalAction) modalAction.addEventListener("click", closeModal);

    const size = 600;
    const cx = size / 2;
    const cy = size / 2;
    const radius = 250; // scaled for 600x600
    const textRadius = 215;

    const toRad = (deg) => (deg * Math.PI) / 180;

    const polarToCartesian = (centerX, centerY, r, angleDeg) => {
        const angleRad = toRad(angleDeg - 90);
        return {
            x: centerX + r * Math.cos(angleRad),
            y: centerY + r * Math.sin(angleRad),
        };
    };

    const describeWedge = (centerX, centerY, r, startAngle, endAngle) => {
        const start = polarToCartesian(centerX, centerY, r, endAngle);
        const end = polarToCartesian(centerX, centerY, r, startAngle);
        const largeArcFlag = endAngle - startAngle <= 180 ? "0" : "1";
        return [
            "M",
            centerX,
            centerY,
            "L",
            start.x,
            start.y,
            "A",
            r,
            r,
            0,
            largeArcFlag,
            0,
            end.x,
            end.y,
            "Z",
        ].join(" ");
    };

    const hexToRgb = (hex) => {
        const clean = (hex || "").replace("#", "");
        if (clean.length !== 6) return { r: 0, g: 0, b: 0 };
        const r = parseInt(clean.slice(0, 2), 16);
        const g = parseInt(clean.slice(2, 4), 16);
        const b = parseInt(clean.slice(4, 6), 16);
        return { r, g, b };
    };

    const getTextColor = (hex) => {
        const { r, g, b } = hexToRgb(hex);
        const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
        return luminance > 0.6 ? "#0f4b4a" : "#ffffff";
    };

    const setWheelRotation = (deg, durationMs = 0) => {
        if (!wheelSvg) return;
        if (durationMs > 0) {
            wheelSvg.style.transition = `transform ${durationMs}ms cubic-bezier(0.1, 0.85, 0.2, 1)`;
        } else {
            wheelSvg.style.transition = "none";
        }
        wheelSvg.style.transform = `rotate(${deg}deg)`;
    };

    const buildWheel = (segments) => {
        container.innerHTML = "";
        const svg = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "svg",
        );
        svg.setAttribute("viewBox", `0 0 ${size} ${size}`);
        svg.setAttribute("width", size);
        svg.setAttribute("height", size);
        svg.classList.add("wheel-svg");
        svg.style.transformOrigin = "50% 50%";
        svg.style.willChange = "transform";

        const defs = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "defs",
        );
        svg.appendChild(defs);

        // Outer ring
        const ring = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "circle",
        );
        ring.setAttribute("cx", cx);
        ring.setAttribute("cy", cy);
        ring.setAttribute("r", radius + 12);
        ring.setAttribute("fill", "#f1fbf9");
        ring.setAttribute("stroke", "#ffffff");
        ring.setAttribute("stroke-width", "10");
        svg.appendChild(ring);

        segments.forEach((seg, i) => {
            const wedge = document.createElementNS(
                "http://www.w3.org/2000/svg",
                "path",
            );
            wedge.setAttribute(
                "d",
                describeWedge(cx, cy, radius, seg.start, seg.end),
            );
            wedge.setAttribute("fill", seg.color || "#d7f0eb");
            wedge.setAttribute("stroke", "#ffffff");
            wedge.setAttribute("stroke-width", "2");
            svg.appendChild(wedge);

            const angle = (seg.start + seg.end) / 2;
            const endPoint = polarToCartesian(cx, cy, textRadius, angle);

            // make inner start point so labels don't start at the exact center (gives padding)
            // increased padding so multi-line labels don't overlap the center
            const innerRadius = Math.min(200, radius * 0.75);
            const innerPoint = polarToCartesian(cx, cy, innerRadius, angle);

            // draw a white separator line at the segment start angle
            // extend separator all the way to the center
            const sepInner = 0;
            const sepOuter = radius + 12;
            const sepStart = polarToCartesian(cx, cy, sepInner, seg.start);
            const sepEnd = polarToCartesian(cx, cy, sepOuter, seg.start);
            const sepLine = document.createElementNS(
                "http://www.w3.org/2000/svg",
                "line",
            );
            sepLine.setAttribute("x1", sepStart.x);
            sepLine.setAttribute("y1", sepStart.y);
            sepLine.setAttribute("x2", sepEnd.x);
            sepLine.setAttribute("y2", sepEnd.y);
            sepLine.setAttribute("stroke", "#ffffff");
            sepLine.setAttribute("stroke-width", "10");
            sepLine.setAttribute("stroke-linecap", "butt");
            sepLine.setAttribute("pointer-events", "none");
            svg.appendChild(sepLine);

            // place multi-line radial label using <text> + <tspan>
            const angleDeg = angle;
            const isFlipped = angleDeg > 90 && angleDeg < 270;
            const rotation = isFlipped ? angleDeg + 180 : angleDeg;

            const textX = innerPoint.x;
            const textY = innerPoint.y;

            const raw = (seg.name || "").trim();
            // simple word-wrap by characters per line (tighter wrap)
            const maxChars = 10;
            const words = raw.split(/\s+/).filter(Boolean);
            const lines = [];
            let cur = "";
            for (const w of words) {
                if (!cur) {
                    cur = w;
                    continue;
                }
                if ((cur + " " + w).length <= maxChars) {
                    cur = cur + " " + w;
                } else {
                    lines.push(cur);
                    cur = w;
                }
            }
            if (cur) lines.push(cur);
            if (lines.length === 0) lines.push("");

            // apply requested text styling: lowercase, bold, specific size/spacing
            for (let li = 0; li < lines.length; li++)
                lines[li] = lines[li].toLowerCase();

            // When flipped, we need to reverse the visual stacking of lines so the
            // top-to-bottom reading order remains the same as the original text.
            const renderLines = isFlipped ? lines.slice().reverse() : lines;

            const text = document.createElementNS(
                "http://www.w3.org/2000/svg",
                "text",
            );
            text.setAttribute("x", textX);
            text.setAttribute("y", textY);
            text.setAttribute("text-anchor", "middle");
            // keep a fixed readable font size (do not decrease for multiple lines)
            // Increase font on small viewports for better readability
            const viewportWidth = Math.max(
                document.documentElement.clientWidth || 0,
                window.innerWidth || 0,
            );
            let baseFont = 15.66;
            if (viewportWidth <= 420) baseFont = 19.2;
            else if (viewportWidth <= 520) baseFont = 18;
            else if (viewportWidth <= 768) baseFont = 17;
            const fontSize = baseFont;
            text.setAttribute("font-size", String(fontSize));
            text.setAttribute("font-family", "Montserrat, sans-serif");
            text.setAttribute("font-weight", "700");
            text.setAttribute("fill", getTextColor(seg.color));
            text.setAttribute("letter-spacing", "0");
            text.setAttribute(
                "transform",
                `rotate(${rotation} ${textX} ${textY})`,
            );

            // first line
            const first = document.createElementNS(
                "http://www.w3.org/2000/svg",
                "tspan",
            );
            first.setAttribute("x", textX);
            first.setAttribute("dy", "0");
            first.textContent = renderLines[0];
            text.appendChild(first);

            // subsequent lines — move outward (or inward when flipped)
            // line-height 83% -> 0.83em
            const step = "0.83em";
            for (let li = 1; li < renderLines.length; li++) {
                const t = document.createElementNS(
                    "http://www.w3.org/2000/svg",
                    "tspan",
                );
                t.setAttribute("x", textX);
                t.setAttribute("dy", isFlipped ? `-${step}` : step);
                t.textContent = renderLines[li];
                text.appendChild(t);
            }

            svg.appendChild(text);
        });

        container.appendChild(svg);
        wheelSvg = svg;
        setWheelRotation(currentRotation, 0);
    };

    const normalizeSegments = (data) => {
        const list = Array.isArray(data) ? data : [];
        let total = list.reduce((s, p) => s + (p.chance || 0), 0);

        if (total <= 0) {
            total = list.length || 1;
            let acc = 0;
            return list.map((p) => {
                const start = (acc / total) * 360;
                acc += 1;
                const end = (acc / total) * 360;
                return {
                    id: p.id,
                    name: p.name,
                    color: p.color || "#d7f0eb",
                    start,
                    end,
                };
            });
        }

        let acc = 0;
        return list.map((p) => {
            const start = (acc / total) * 360;
            acc += p.chance || 0;
            const end = (acc / total) * 360;
            return {
                id: p.id,
                name: p.name,
                color: p.color || "#d7f0eb",
                start,
                end,
            };
        });
    };

    const loadSegments = async () => {
        try {
            const res = await fetch("/spin/prizes");
            if (!res.ok) return;
            const data = await res.json();
            const segments = normalizeSegments(data);
            segmentsCache = segments;
            buildWheel(segments);
        } catch (e) {
            // silent fail
        }
    };

    loadSegments();

    const form = document.querySelector(".spin-form-fields");
    if (form) {
        const nameInput = form.querySelector('input[name="name"]');
        const phoneInput = form.querySelector('input[name="phone"]');
        const agreeInput = form.querySelector('input[name="agree"]');
        const button = form.querySelector(".spin-button");
        const errorBox = form.querySelector(".spin-error");

        const setError = (msg) => {
            if (!errorBox) return;
            errorBox.textContent = msg || "";
        };

        const isValidName = (value) => {
            const trimmed = (value || "").trim();
            if (!trimmed) return false;
            return /^[A-Za-zА-Яа-яЁё\s-]+$/.test(trimmed);
        };

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            if (isSpinning) return;
            setError("");

            if (!agreeInput || !agreeInput.checked) return;

            if (!nameInput || !nameInput.value.trim()) {
                setError("Введите имя");
                if (nameInput) nameInput.focus();
                return;
            }

            if (!isValidName(nameInput.value)) {
                setError("Имя должно содержать только буквы");
                if (nameInput) nameInput.focus();
                return;
            }
            if (!phoneInput || !phoneInput.value.trim()) {
                setError("Введите номер телефона");
                if (phoneInput) phoneInput.focus();
                return;
            }

            if (segmentsCache.length === 0) {
                setError("Колесо ещё загружается. Попробуйте снова.");
                return;
            }

            isSpinning = true;
            if (button) button.disabled = true;

            try {
                const csrf = document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content");
                const formData = new FormData(form);
                const res = await fetch("/spin", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrf || "",
                        Accept: "application/json",
                    },
                    body: formData,
                });

                if (res.status === 422) {
                    const data = await res.json();
                    const msg =
                        data?.errors?.name?.[0] ||
                        data?.errors?.phone?.[0] ||
                        data?.errors?.agree?.[0] ||
                        "Проверьте данные";
                    setError(msg);
                    isSpinning = false;
                    if (button && agreeInput?.checked) button.disabled = false;
                    return;
                }

                if (!res.ok) {
                    setError("Ошибка сервера. Попробуйте позже.");
                    isSpinning = false;
                    if (button && agreeInput?.checked) button.disabled = false;
                    return;
                }

                const data = await res.json();

                const prize = data?.prize;
                if (!prize) {
                    setError("Не удалось определить приз.");
                    isSpinning = false;
                    if (button && agreeInput?.checked) button.disabled = false;
                    return;
                }

                const segment =
                    segmentsCache.find(
                        (s) => String(s.id) === String(prize.id),
                    ) || segmentsCache[0];
                const midAngle = (segment.start + segment.end) / 2;
                const targetRotation =
                    currentRotation + spinTurns * 360 - midAngle;
                currentRotation = targetRotation;
                setWheelRotation(currentRotation, spinDurationMs);

                const phone = phoneInput.value.trim();
                const prizeName = prize.name;

                setTimeout(() => {
                    openModal(prizeName, phone);
                    isSpinning = false;
                }, spinDurationMs + 150);
            } catch (err) {
                setError("Ошибка сети. Попробуйте позже.");
                isSpinning = false;
                if (button && agreeInput?.checked) button.disabled = false;
            }
        });
    }
});
