<!-- Модальное окно теста -->
<div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testModalLabel">Тест на определение уровня гибкости</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Прелоадер -->
                <div id="test-loader" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Загрузка...</span>
                    </div>
                    <p class="mt-3">Загружаем вопросы теста...</p>
                </div>
                <div class="row test-mobile-layout">
                    <div class="col-lg-6 col-12">
                        <img src="{{ asset('images/directions-background.webp') }}" alt="">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div id="test-container" class="d-none">
                            <div class="test-content-wrapper">
                                <!-- Прогресс бар -->
                                <div class="progress mb-4">
                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <!-- Контейнер для вопросов -->
                                <div id="questions-container">
                                    <!-- Вопросы будут загружены динамически -->
                                </div>

                                <!-- Форма контактных данных -->
                                <div id="contact-form" class="d-none">
                                    <h5 class="mb-4">Оставьте ваши контактные данные для получения персональной
                                        программы
                                    </h5>
                                    <form id="test-contact-form">
                                        <div class="mb-3">
                                            <label for="user-name" class="form-label">Имя *</label>
                                            <input type="text" class="form-control" id="user-name" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="user-phone" class="form-label">Телефон *</label>
                                            <input type="tel" class="form-control" id="user-phone" name="phone"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="user-email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="user-email" name="email">
                                        </div>
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="test-privacy"
                                                name="privacy_agreement" required>
                                            <label class="form-check-label" for="test-privacy">
                                                Я согласен(-на) на <a href="{{ route('personal-data') }}"> обработку
                                                    персональных данных</a>
                                            </label>
                                        </div>

                                        {{-- Яндекс капча --}}
                                        <div class="mb-3">
                                            <x-yandex-captcha class="mb-3" />
                                            <div class="captcha-error text-danger small" style="display: none;"></div>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted">
                                                * Обязательные поля. Мы свяжемся с вами для записи на бесплатное
                                                занятие.
                                            </small>
                                        </div>
                                    </form>
                                </div>

                                <!-- Результат -->
                                <div id="test-result" class="d-none text-center">
                                    <div class="alert alert-success">
                                        <h5>Спасибо! Тест успешно отправлен!</h5>
                                        <p>Мы свяжемся с вами в ближайшее время для записи на бесплатное занятие и
                                            предоставления
                                            персональной программы.</p>
                                    </div>
                                </div>

                                <!-- Ошибка -->
                                <div id="test-error" class="d-none">
                                    <div class="alert alert-danger">
                                        <p>Произошла ошибка при отправке теста. Попробуйте еще раз.</p>
                                    </div>
                                </div>

                                <!-- Навигационные кнопки -->
                                <div class="test-navigation">

                                    <button type="button" id="submit-btn" class="submit-btn d-none">Отправить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Контейнер для теста -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
