// Управление модальным окном теста
class YogaTest {
    constructor() {
        this.questions = [];
        this.currentQuestionIndex = 0;
        this.answers = [];
        this.modal = document.getElementById("testModal");
        this.initEventListeners();
    }

    initEventListeners() {
        // Обработчик открытия модального окна
        if (this.modal) {
            // Bootstrap событие
            this.modal.addEventListener("shown.bs.modal", () => {
                this.loadQuestions();
            });
        }

        // Обработчик закрытия модального окна
        this.modal?.addEventListener("hidden.bs.modal", () => {
            this.resetTest();
        });

        // Кнопки навигации
        document.getElementById("next-btn")?.addEventListener("click", () => {
            this.nextQuestion();
        });

        document.getElementById("prev-btn")?.addEventListener("click", () => {
            this.prevQuestion();
        });

        document.getElementById("submit-btn")?.addEventListener("click", () => {
            this.submitTest();
        });
    }

    async loadQuestions() {
        try {
            this.showLoader();

            const baseUrl = window.location.origin;
            const response = await fetch(`${baseUrl}/api/test/questions`);
            const data = await response.json();

            if (data.success) {
                this.questions = data.questions;
                this.renderQuestions();
                this.showTest();
                this.updateNavigation();
            } else {
                throw new Error("Ошибка загрузки вопросов");
            }
        } catch (error) {
            console.error("Ошибка загрузки теста:", error);
            this.showError(
                "Не удалось загрузить вопросы теста. Попробуйте обновить страницу."
            );
        }
    }

    renderQuestions() {
        const container = document.getElementById("questions-container");
        if (!container) return;

        container.innerHTML = "";

        this.questions.forEach((question, index) => {
            const questionDiv = document.createElement("div");
            questionDiv.className = `test-question ${
                index === 0 ? "" : "d-none"
            }`;
            questionDiv.dataset.questionIndex = index;

            let optionsHtml = "";
            question.options.forEach((option, optionIndex) => {
                optionsHtml += `
                    <div class="test-option">
                        <input type="radio" 
                               id="option_${question.id}_${option.id}" 
                               name="question_${question.id}" 
                               value="${option.id}"
                               data-question-id="${question.id}"
                               data-option-id="${option.id}">
                        <label for="option_${question.id}_${option.id}">
                            ${option.option_text}
                        </label>
                    </div>
                `;
            });

            questionDiv.innerHTML = `
                <h6>Вопрос ${index + 1} из ${this.questions.length}</h6>
                <p class="mb-4">${question.question}</p>
                ${optionsHtml}
            `;

            container.appendChild(questionDiv);
        });

        // Добавляем обработчики для radio buttons
        container.addEventListener("change", (e) => {
            if (e.target.type === "radio") {
                this.saveAnswer(e.target);
                this.updateNavigation();
            }
        });
    }

    saveAnswer(radioInput) {
        const questionId = parseInt(radioInput.dataset.questionId);
        const optionId = parseInt(radioInput.dataset.optionId);

        // Удаляем предыдущий ответ на этот вопрос, если есть
        this.answers = this.answers.filter(
            (answer) => answer.question_id !== questionId
        );

        // Добавляем новый ответ
        this.answers.push({
            question_id: questionId,
            option_id: optionId,
        });
    }

    nextQuestion() {
        if (this.currentQuestionIndex < this.questions.length - 1) {
            this.hideCurrentQuestion();
            this.currentQuestionIndex++;
            this.showCurrentQuestion();
        } else {
            // Показываем форму контактных данных
            this.showContactForm();
        }
        this.updateProgress();
        this.updateNavigation();
    }

    prevQuestion() {
        if (this.currentQuestionIndex > 0) {
            this.hideCurrentQuestion();
            this.currentQuestionIndex--;
            this.showCurrentQuestion();
        } else if (this.isContactFormVisible()) {
            // Возвращаемся к последнему вопросу
            this.hideContactForm();
            this.currentQuestionIndex = this.questions.length - 1;
            this.showCurrentQuestion();
        }
        this.updateProgress();
        this.updateNavigation();
    }

    hideCurrentQuestion() {
        const currentQuestion = document.querySelector(
            `[data-question-index="${this.currentQuestionIndex}"]`
        );
        currentQuestion?.classList.add("d-none");
    }

    showCurrentQuestion() {
        const currentQuestion = document.querySelector(
            `[data-question-index="${this.currentQuestionIndex}"]`
        );
        currentQuestion?.classList.remove("d-none");
    }

    showContactForm() {
        const questionsContainer = document.getElementById(
            "questions-container"
        );
        const contactForm = document.getElementById("contact-form");

        questionsContainer?.classList.add("d-none");
        contactForm?.classList.remove("d-none");
    }

    hideContactForm() {
        const questionsContainer = document.getElementById(
            "questions-container"
        );
        const contactForm = document.getElementById("contact-form");

        questionsContainer?.classList.remove("d-none");
        contactForm?.classList.add("d-none");
    }

    isContactFormVisible() {
        const contactForm = document.getElementById("contact-form");
        return contactForm && !contactForm.classList.contains("d-none");
    }

    updateProgress() {
        const progressBar = document.querySelector(".progress-bar");
        if (progressBar) {
            let progress;
            if (this.isContactFormVisible()) {
                progress = 100;
            } else {
                progress =
                    ((this.currentQuestionIndex + 1) / this.questions.length) *
                    100;
            }
            progressBar.style.width = progress + "%";
            progressBar.setAttribute("aria-valuenow", progress);
        }
    }

    updateNavigation() {
        const nextBtn = document.getElementById("next-btn");
        const prevBtn = document.getElementById("prev-btn");
        const submitBtn = document.getElementById("submit-btn");

        if (!nextBtn || !prevBtn || !submitBtn) return;

        // Кнопка "Назад"
        if (this.currentQuestionIndex === 0 && !this.isContactFormVisible()) {
            prevBtn.classList.add("d-none");
        } else {
            prevBtn.classList.remove("d-none");
        }

        // Кнопка "Далее" / "Отправить"
        if (this.isContactFormVisible()) {
            nextBtn.classList.add("d-none");
            submitBtn.classList.remove("d-none");
        } else {
            submitBtn.classList.add("d-none");

            // Проверяем, есть ли ответ на текущий вопрос
            const currentQuestionId =
                this.questions[this.currentQuestionIndex]?.id;
            const hasAnswer = this.answers.some(
                (answer) => answer.question_id === currentQuestionId
            );

            if (hasAnswer) {
                nextBtn.classList.remove("d-none");
                nextBtn.disabled = false;
            } else {
                nextBtn.classList.remove("d-none");
                nextBtn.disabled = true;
            }
        }
    }

    async submitTest() {
        const form = document.getElementById("test-contact-form");
        const formData = new FormData(form);

        const name = formData.get("name");
        const phone = formData.get("phone");
        const email = formData.get("email");

        if (!name || !phone) {
            alert("Пожалуйста, заполните обязательные поля (Имя и Телефон)");
            return;
        }

        if (this.answers.length !== this.questions.length) {
            alert("Пожалуйста, ответьте на все вопросы");
            return;
        }

        try {
            const baseUrl = window.location.origin;
            const response = await fetch(`${baseUrl}/api/test/submit`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
                body: JSON.stringify({
                    name: name,
                    phone: phone,
                    email: email,
                    answers: this.answers,
                }),
            });

            const data = await response.json();

            if (data.success) {
                this.showResult(data.message);
            } else {
                throw new Error(data.message || "Ошибка отправки данных");
            }
        } catch (error) {
            console.error("Ошибка отправки теста:", error);
            this.showError(
                "Произошла ошибка при отправке теста. Попробуйте еще раз."
            );
        }
    }

    showLoader() {
        document.getElementById("test-loader")?.classList.remove("d-none");
        document.getElementById("test-container")?.classList.add("d-none");

        // Убираем класс, чтобы картинка была скрыта
        const imageContainer = this.modal?.querySelector(".test-mobile-layout");
        if (imageContainer) {
            imageContainer.classList.remove("show-image");
        }
    }

    showTest() {
        document.getElementById("test-loader")?.classList.add("d-none");
        document.getElementById("test-container")?.classList.remove("d-none");

        // Добавляем класс, чтобы показать картинку
        const imageContainer = this.modal?.querySelector(".test-mobile-layout");
        if (imageContainer) {
            imageContainer.classList.add("show-image");
        }
    }

    showResult(message) {
        document.getElementById("contact-form")?.classList.add("d-none");
        document.getElementById("test-result")?.classList.remove("d-none");

        // Скрываем кнопки навигации
        document.getElementById("next-btn")?.classList.add("d-none");
        document.getElementById("prev-btn")?.classList.add("d-none");
        document.getElementById("submit-btn")?.classList.add("d-none");

        // Обновляем сообщение если передано
        if (message) {
            const resultContainer = document.querySelector(
                "#test-result .alert p"
            );
            if (resultContainer) {
                resultContainer.textContent = message;
            }
        }
    }

    showError(message) {
        document.getElementById("test-error")?.classList.remove("d-none");

        const errorContainer = document.querySelector("#test-error .alert p");
        if (errorContainer && message) {
            errorContainer.textContent = message;
        }
    }

    resetTest() {
        this.questions = [];
        this.currentQuestionIndex = 0;
        this.answers = [];

        // Скрываем все секции
        document.getElementById("test-loader")?.classList.add("d-none");
        document.getElementById("test-container")?.classList.add("d-none");
        document.getElementById("contact-form")?.classList.add("d-none");
        document.getElementById("test-result")?.classList.add("d-none");
        document.getElementById("test-error")?.classList.add("d-none");

        // Очищаем контейнеры
        const qc = document.getElementById("questions-container");
        if (qc) qc.innerHTML = "";
        document.getElementById("test-contact-form")?.reset();

        // Сбрасываем прогресс
        const progressBar = document.querySelector(".progress-bar");
        if (progressBar) {
            progressBar.style.width = "0%";
            progressBar.setAttribute("aria-valuenow", "0");
        }

        // Скрываем картинку при закрытии модалки
        const imageContainer = this.modal?.querySelector(".test-mobile-layout");
        if (imageContainer) {
            imageContainer.classList.remove("show-image");
        }
    }
}

// Инициализация после загрузки страницы
document.addEventListener("DOMContentLoaded", function () {
    // Функция для инициализации теста
    function initYogaTest() {
        if (typeof bootstrap !== "undefined") {
            new YogaTest();
            return true;
        }
        return false;
    }

    // Пробуем инициализировать сразу
    if (!initYogaTest()) {
        // Если Bootstrap не найден, ждем его загрузки
        let attempts = 0;
        const maxAttempts = 50; // 5 секунд максимум

        const checkBootstrap = setInterval(() => {
            attempts++;

            if (initYogaTest()) {
                clearInterval(checkBootstrap);
            } else if (attempts >= maxAttempts) {
                clearInterval(checkBootstrap);
                // Инициализируем без Bootstrap (базовая функциональность)
                new YogaTest();
            }
        }, 100);
    }
});

// Функция для открытия модального окна теста (можно вызывать из любого места)
function openTestModal() {
    const modalElement = document.getElementById("testModal");
    if (!modalElement) {
        return;
    }

    // Пробуем использовать Bootstrap
    if (typeof bootstrap !== "undefined") {
        const testModal = new bootstrap.Modal(modalElement);
        testModal.show();
    } else {
        // Альтернативный способ - показываем модальное окно вручную
        modalElement.style.display = "block";
        modalElement.classList.add("show");
        modalElement.setAttribute("aria-modal", "true");
        modalElement.setAttribute("role", "dialog");

        // Добавляем backdrop
        const backdrop = document.createElement("div");
        backdrop.className = "modal-backdrop fade show";
        backdrop.id = "test-modal-backdrop";
        document.body.appendChild(backdrop);

        // Добавляем обработчик закрытия
        const closeBtn = modalElement.querySelector(".btn-close");
        if (closeBtn) {
            closeBtn.onclick = function () {
                modalElement.style.display = "none";
                modalElement.classList.remove("show");
                const backdrop = document.getElementById("test-modal-backdrop");
                if (backdrop) backdrop.remove();
            };
        }

        // Инициируем событие показа модального окна
        const event = new Event("shown.bs.modal");
        modalElement.dispatchEvent(event);
    }
}
