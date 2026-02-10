import IMask from "imask";

document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector(
        '.spin-form-fields input[name="phone"]',
    );
    if (!input) return;
    try {
        IMask(input, {
            mask: "+{7} (000) 000-00-00",
        });
    } catch (e) {
        console.error("IMask init error for spin input", e);
    }
    // Toggle spin button enabled state based on consent checkbox
    const form = document.querySelector(".spin-form-fields");
    if (form) {
        const checkbox = form.querySelector('input[name="agree"]');
        const button = form.querySelector("button.spin-button");
        const updateButton = () => {
            if (!button) return;
            button.disabled = !(checkbox && checkbox.checked);
        };
        // initialize
        updateButton();
        if (checkbox) checkbox.addEventListener("change", updateButton);
    }
});
