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

            // Здесь в будущем будет отправка на сервер
            console.log("Данные формы:", {
                name: name,
                phone: phone,
                privacy_agreement: privacyAgreement,
            });

            // Сообщение об успехе
            Swal.fire({
                icon: "success",
                title: "Спасибо!",
                text: `Ваша заявка принята. Мы свяжемся с вами по номеру ${phone}`,
                confirmButtonColor: "#1D7D6F",
            });

            this.reset();
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
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData(
                    "text"
                );
                const digitsOnly = paste.replace(/\D/g, "");

                if (digitsOnly) {
                    const event = new Event("input", { bubbles: true });
                    e.target.value = digitsOnly;
                    e.target.dispatchEvent(event);
                }
            });
        }
    }
});
