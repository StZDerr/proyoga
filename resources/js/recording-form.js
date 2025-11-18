// resources/js/recording-form.js
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll(".recording-form");

    forms.forEach(function (form) {
        // Submit handler для каждой формы отдельно
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const name = (form.querySelector('input[name="name"]') || {}).value;
            const phoneInput = form.querySelector('input[name="phone"]');
            const phoneDigits = phoneInput
                ? phoneInput.getAttribute("data-phone-digits") || ""
                : "";
            const privacyAgreement = form.querySelector(
                'input[name="privacy_agreement"]'
            )
                ? form.querySelector('input[name="privacy_agreement"]').checked
                : false;
            const captchaTokenInput = form.querySelector(
                'input[name="smart-token"]'
            );
            const captchaToken = captchaTokenInput
                ? captchaTokenInput.value
                : null;

            // Валидация
            if (!name || name.trim().length < 2) {
                Swal.fire({
                    icon: "warning",
                    title: "Ошибка!",
                    text: "Пожалуйста, введите корректное имя (минимум 2 символа)",
                    confirmButtonColor: "#1D7D6F",
                });
                (
                    form.querySelector("#userName") ||
                    form.querySelector('input[name="name"]')
                ).focus();
                return;
            }

            if (!phoneInput || phoneDigits.length !== 11) {
                Swal.fire({
                    icon: "warning",
                    title: "Ошибка!",
                    text: "Введите номер телефона в формате +7 (XXX) XXX-XX-XX",
                    confirmButtonColor: "#1D7D6F",
                });
                if (phoneInput) phoneInput.focus();
                return;
            }

            if (!privacyAgreement) {
                Swal.fire({
                    icon: "warning",
                    title: "Ошибка!",
                    text: "Пожалуйста, согласитесь с политикой конфиденциальности",
                    confirmButtonColor: "#1D7D6F",
                });
                (
                    form.querySelector("#privacyPolicy") ||
                    form.querySelector('input[name="privacy_agreement"]')
                ).focus();
                return;
            }

            if (!captchaToken) {
                Swal.fire({
                    icon: "warning",
                    title: "Ошибка!",
                    text: "Пожалуйста, пройдите проверку капчи",
                    confirmButtonColor: "#1D7D6F",
                });
                return;
            }

            // Отправка данных на сервер
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton ? submitButton.textContent : null;

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = "Отправка...";
            }

            fetch("/contact/send", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    name: name,
                    phone: phoneInput ? phoneInput.value : "",
                    email: "",
                    message: `Заявка на запись на занятие от ${name}. Телефон: ${
                        phoneInput ? phoneInput.value : ""
                    }`,
                    service: form.querySelector('input[name="service"]')
                        ? form.querySelector('input[name="service"]').value
                        : "",
                    privacy_agreement: "on",
                    "smart-token": captchaToken,
                    page_url: window.location.href,
                    page_title: document.title,
                }),
            })
                .then((response) => {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = originalText;
                    }
                    if (!response.ok)
                        throw new Error(
                            `HTTP error! status: ${response.status}`
                        );
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        window.location.href = "/thanks";
                    } else {
                        throw new Error(data.message || "Ошибка отправки");
                    }
                })
                .catch((error) => {
                    console.error("Ошибка:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Ошибка!",
                        text: "Произошла ошибка при отправке заявки. Попробуйте еще раз.",
                        confirmButtonColor: "#1D7D6F",
                    });
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = originalText;
                    }
                });
        });

        // Маска телефона для phone input в этой форме
        const phoneInput = form.querySelector('input[name="phone"]');
        if (phoneInput) {
            // Обернём навешивание, чтобы не дублировать обработчики, если скрипт вызван повторно
            if (!phoneInput.dataset.maskInitialized) {
                phoneInput.dataset.maskInitialized = "1";

                phoneInput.addEventListener("keydown", function (e) {
                    const allowedKeys = [
                        "Backspace",
                        "Delete",
                        "Tab",
                        "Escape",
                        "Enter",
                        "ArrowLeft",
                        "ArrowRight",
                        "ArrowUp",
                        "ArrowDown",
                    ];
                    if (
                        e.ctrlKey &&
                        ["a", "c", "v", "x"].includes(e.key.toLowerCase())
                    )
                        return;
                    if (
                        !allowedKeys.includes(e.key) &&
                        (e.key < "0" || e.key > "9")
                    ) {
                        e.preventDefault();
                        return false;
                    }
                });

                phoneInput.addEventListener("input", function (e) {
                    let value = e.target.value.replace(/\D/g, "");
                    if (value.length > 0 && value[0] === "8") {
                        value = "7" + value.slice(1);
                    }
                    if (value.length > 11) value = value.slice(0, 11);

                    let formatted = "";
                    if (value.length > 0) {
                        formatted = "+7";
                        if (value.length > 1)
                            formatted += " (" + value.slice(1, 4);
                        if (value.length > 4)
                            formatted += ") " + value.slice(4, 7);
                        if (value.length > 7)
                            formatted += "-" + value.slice(7, 9);
                        if (value.length > 9)
                            formatted += "-" + value.slice(9, 11);
                    }

                    e.target.value = formatted;
                    e.target.setAttribute("data-phone-digits", value);
                });

                phoneInput.addEventListener("paste", function (e) {
                    setTimeout(() => {
                        const paste = phoneInput.value;
                        const digitsOnly = paste.replace(/\D/g, "");
                        if (digitsOnly) {
                            const event = new Event("input", { bubbles: true });
                            phoneInput.value = digitsOnly;
                            phoneInput.dispatchEvent(event);
                        }
                    }, 0);
                });
            }
        }
    });

    // Защита: если модальное окно открывается и капча рендерится динамически,
    // инициируем повторную инициализацию Yandex SmartCaptcha
    document.addEventListener("shown.bs.modal", function () {
        if (typeof initYandexCaptcha === "function") {
            setTimeout(initYandexCaptcha, 50);
        }
    });
});
