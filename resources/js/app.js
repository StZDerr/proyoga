import "./bootstrap";
import * as bootstrap from "bootstrap";
import "../css/app.css";

// Делаем Bootstrap глобально доступным
window.bootstrap = bootstrap;

import Swal from "sweetalert2";
window.Swal = Swal; // чтобы SweetAlert был доступен глобально

// Функция отправки форм
function submitForm(formId, formType) {
    const form = document.getElementById(formId);
    if (!form) return;

    const formData = new FormData(form);
    formData.append("form_type", formType);

    // Показываем загрузку
    Swal.fire({
        title: "Отправка...",
        text: "Пожалуйста, подождите",
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        },
    });

    fetch("/contact/send", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN":
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content") || "",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Успешно!",
                    text: data.message || "Ваше сообщение отправлено",
                    confirmButtonColor: "#1D7D6F",
                });
                form.reset();
                // Закрываем модальное окно если оно есть
                const modal = form.closest(".modal");
                if (modal) {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) modalInstance.hide();
                }
            } else {
                let errorText = "Произошла ошибка при отправке";
                if (data.errors) {
                    errorText = Object.values(data.errors).flat().join("\n");
                } else if (data.message) {
                    errorText = data.message;
                }

                Swal.fire({
                    icon: "error",
                    title: "Ошибка",
                    text: errorText,
                    confirmButtonColor: "#dc3545",
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "Ошибка",
                text: "Произошла ошибка при отправке формы",
                confirmButtonColor: "#dc3545",
            });
        });
}

// Делаем функцию глобально доступной
window.submitForm = submitForm;

// Обработчики для форм
document.addEventListener("DOMContentLoaded", function () {
    // Форма записи на занятие
    const recordingForm = document.getElementById("recordingForm");
    if (recordingForm) {
        recordingForm.addEventListener("submit", function (e) {
            e.preventDefault();
            submitForm("recordingForm", "recording");
        });
    }

    // Форма обратной связи
    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        contactForm.addEventListener("submit", function (e) {
            e.preventDefault();
            submitForm("contactForm", "contact");
        });
    }
});
