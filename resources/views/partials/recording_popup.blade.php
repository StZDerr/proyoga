<div class="modal fade" id="recordingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content p-3 p-md-4">

            <!-- Кнопка закрытия -->
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>

            <!-- Твой блок один-в-один -->
            <div id="recording" class="recording mt-3">
                <div class="container">
                    <div class="row">

                        <div class="col-xl-6 col-12">
                            <img src="{{ asset('images/recording-img.webp') }}" alt="" loading="lazy"
                                width="600" height="400">
                        </div>

                        <div class="mt-3 col-xl-6 col-12">
                            <div class="title">
                                Получить бесплатную консультацию на "{{ $subSubCategory->title }}"
                            </div>

                            <!-- Форма записи -->
                            <form class="recording-form mt-4" id="recordingForm">
                                @csrf
                                <input type="hidden" name="service"
                                    value="{{ "Получить бесплатную консультацию на \"{$subSubCategory->title}\"" }}">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control recording-input" id="userName"
                                        name="name" placeholder="Ваше имя" required autocomplete="name"
                                        minlength="2" maxlength="50" pattern="[а-яёА-ЯЁa-zA-Z\s\-]+"
                                        title="Введите ваше имя (только буквы, пробелы и дефисы)">
                                </div>

                                <div class="form-group mb-3">
                                    <input type="tel" class="form-control recording-input" id="userPhone"
                                        name="phone" placeholder="Номер телефона" required autocomplete="tel"
                                        inputmode="numeric" pattern="[0-9\s\(\)\-\+]*" minlength="18" maxlength="18"
                                        title="Введите номер телефона в формате +7 (XXX) XXX-XX-XX">
                                </div>

                                <div class="form-check mb-4">
                                    <input type="checkbox" class="form-check-input recording-checkbox"
                                        id="privacyPolicy" name="privacy_agreement" required>
                                    <label class="form-check-label recording-checkbox-label" for="privacyPolicy">
                                        Я согласен(-на) на <a href="{{ route('personal-data') }}">обработку персональных
                                            данных</a>
                                    </label>
                                </div>

                                <!-- Капча -->
                                <div class="mb-4">
                                    <x-yandex-captcha class="mb-3" />
                                    <div class="captcha-error text-danger small" style="display: none;"></div>
                                </div>

                                <button type="submit" class="btn recording-submit-btn w-100">
                                    Получить бесплатное занятие
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /конец твоего блока -->

        </div>
    </div>
</div>
