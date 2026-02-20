document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("promotionModal");
    const modalImage = document.getElementById("promotionModalImage");
    const modalTitle = document.getElementById("promotionModalTitle");
    const modalDescription = document.getElementById(
        "promotionModalDescription",
    );
    const modalDates = document.querySelector(".promotion-modal-dates");
    const closeBtn = document.querySelector(".promotion-modal-close");

    document.querySelectorAll(".promotion-card").forEach((card) => {
        card.addEventListener("click", () => {
            modalImage.src = card.dataset.photo;
            modalTitle.textContent = card.dataset.title;
            const descriptionTemplate = card.querySelector(
                ".promotion-description-template",
            );

            if (descriptionTemplate?.innerHTML?.trim()) {
                modalDescription.innerHTML = descriptionTemplate.innerHTML;
            } else {
                modalDescription.textContent = "Описание отсутствует";
            }

            let start = card.dataset.start
                ? new Date(card.dataset.start).toLocaleDateString()
                : null;
            let end = card.dataset.end
                ? new Date(card.dataset.end).toLocaleDateString()
                : null;
            modalDates.textContent =
                start || end
                    ? `Период проведения: ${start ?? "—"} — ${end ?? "—"}`
                    : "";

            modal.style.display = "flex";
        });
    });

    closeBtn.addEventListener("click", () => (modal.style.display = "none"));
    modal.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });
});
