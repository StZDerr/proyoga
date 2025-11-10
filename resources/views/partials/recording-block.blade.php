<div id="recording" class="recording mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-12">
                <img src="{{ asset('images/recording-img.webp') }}" alt="" loading="lazy" width="600"
                    height="400">
            </div>
            <div class="mt-3 col-xl-6 col-12">
                <div class="title">
                    Получить констультацию
                </div>
                <div class="desc mt-3">
                    Мы поможем подобрать направление, которое подходит именно Вам, проконсультируем по всем
                    вопросам и запишем на занятие
                </div>

                {{-- Форма записи --}}
                <form class="recording-form mt-4" id="recordingForm">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" class="form-control recording-input" id="userName" name="name"
                            placeholder="Ваше имя" required autocomplete="name" minlength="2" maxlength="50"
                            pattern="[а-яёА-ЯЁa-zA-Z\s\-]+" title="Введите ваше имя (только буквы, пробелы и дефисы)">
                    </div>

                    <div class="form-group mb-3">
                        <input type="tel" class="form-control recording-input" id="userPhone" name="phone"
                            placeholder="Номер телефона" required autocomplete="tel" inputmode="numeric"
                            pattern="[0-9\s\(\)\-\+]*" minlength="18" maxlength="18"
                            title="Введите номер телефона в формате +7 (XXX) XXX-XX-XX">
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input recording-checkbox" id="privacyPolicy"
                            name="privacy_agreement" required>
                        <label class="form-check-label recording-checkbox-label" for="privacyPolicy">
                            Я согласен(-на) с <a href="{{ route('privacy-policy') }}"> политикой конфиденциальности</a>
                        </label>
                    </div>

                    <button type="submit" class="btn recording-submit-btn w-100">
                        Получить констультацию
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
