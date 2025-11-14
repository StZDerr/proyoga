// Обработчик формы записи на занятие
document.addEventListener("DOMContentLoaded", function () {
    const recordingForm = document.getElementById("recordingForm");

    if (recordingForm) {
        recordingForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const name = formData.get("name");
            const phone = formData.get("phone");
            const privacyAgreement = formData.get("privacy_agreement");
            const captchaToken = formData.get("smart-token");

            const phoneInput = document.getElementById("userPhone");
            const phoneDigits =
                phoneInput.getAttribute("data-phone-digits") || "";

            // Валидация
            if (!name || name.trim().length < 2) {
                Swal.fire({
                    icon: "warning",
                    title: "Ошибка!",
                    text: "Пожалуйста, введите корректное имя (минимум 2 символа)",
                    confirmButtonColor: "#1D7D6F",
                });
                document.getElementById("userName").focus();
                return;
            }

            if (!phone || phoneDigits.length !== 11) {
                Swal.fire({
                    icon: "warning",
                    title: "Ошибка!",
                    text: "Введите номер телефона в формате +7 (XXX) XXX-XX-XX",
                    confirmButtonColor: "#1D7D6F",
                });
                phoneInput.focus();
                return;
            }

            if (!privacyAgreement) {
                Swal.fire({
                    icon: "warning",
                    title: "Ошибка!",
                    text: "Пожалуйста, согласитесь с политикой конфиденциальности",
                    confirmButtonColor: "#1D7D6F",
                });
                document.getElementById("privacyPolicy").focus();
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
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;

            // Показываем процесс отправки
            submitButton.disabled = true;
            submitButton.textContent = "Отправка...";

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
                    phone: phone,
                    email: "",
                    message: `Заявка на запись на занятие от ${name}. Телефон: ${phone}`,
                    privacy_agreement: "on",
                    "smart-token": captchaToken,
                    page_url: window.location.href,
                    page_title: document.title,
                }),
            })
                .then((response) => {
                    // Быстро возвращаем кнопку в исходное состояние
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = originalText;
                    }

                    console.log("Response status:", response.status);
                    if (!response.ok) {
                        throw new Error(
                            `HTTP error! status: ${response.status}`
                        );
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("Response data:", data);
                    if (data.success) {
                        // Редирект на страницу благодарности для отслеживания конверсий
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

                    // Возвращаем кнопку в исходное состояние при ошибке
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = originalText;
                    }
                });
        });

        // Маска телефона (оставляем без изменений)
        const phoneInput = document.getElementById("userPhone");
        if (phoneInput) {
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
                ) {
                    return;
                }

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

                if (value.length > 11) {
                    value = value.slice(0, 11);
                }

                let formatted = "";
                if (value.length > 0) {
                    formatted = "+7";
                    if (value.length > 1) formatted += " (" + value.slice(1, 4);
                    if (value.length > 4) formatted += ") " + value.slice(4, 7);
                    if (value.length > 7) formatted += "-" + value.slice(7, 9);
                    if (value.length > 9) formatted += "-" + value.slice(9, 11);
                }

                e.target.value = formatted;
                e.target.setAttribute("data-phone-digits", value);
            });

            phoneInput.addEventListener("paste", function (e) {
                // Не блокируем вставку полностью, а обрабатываем после
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
