<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Preconnect для Google Fonts (оптимизация загрузки) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Preload критичных ресурсов --}}
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Tenor+Sans:wght@400&display=swap">

    {{-- Preload главного изображения hero секции --}}
    <link rel="preload" as="image" href="{{ asset('images/main-hero.jpg') }}" fetchpriority="high">

    {{-- Асинхронная загрузка шрифтов --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Tenor+Sans:wght@400&display=swap"
        rel="stylesheet" media="print" onload="this.media='all'">

    {{-- Fallback для браузеров без JS --}}
    <noscript>
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Tenor+Sans:wght@400&display=swap"
            rel="stylesheet">
    </noscript>

    {{-- Общие стили и JS через Vite (оптимизировано) --}}
    @vite(['resources/css/app.css', 'resources/css/base.css', 'resources/css/taplink.css', 'resources/css/performance.css', 'resources/css/welcome.css', 'resources/css/contacts-block.css', 'resources/css/recording.css', 'resources/css/modal-test.css', 'resources/js/app.js', 'resources/js/base.js', 'resources/js/welcome_new.js', 'resources/js/recording-form.js', 'resources/js/yoga-test.js', 'resources/js/promotion-modal.js', 'resources/js/lazy-iframe.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')
    <main class="page">
        <div class="background-gor">
            <div class="container">
                <div class="pageBanner">
                    <h1 class="pageTitle">Доброго времени суток</h1>
                    <div class="mainText">
                        <p class="text">
                            Наша компания представляет формат «одного окна», где мы представляем несколько
                            направлений бизнеса. На данной странице вы найдете все ссылки для быстрой связи с нами.
                        </p>
                        <p class="text">
                            Мы стремимся предоставить высококачественные услуги во всех наших направлениях бизнеса и
                            гордимся
                            нашими
                            профессиональными навыками. Более подробную информацию о каждом направлении вы можете найти,
                            перейдя
                            по
                            соответствующей ссылке или связавшись с нами. Мы готовы ответить на все ваши вопросы и
                            предложить
                            наилучшие решения для вас.
                        </p>
                    </div>
                    <div class="bannerDiscount">
                        <svg xmlns="http://www.w3.org/2000/svg" width="211" height="91" viewBox="0 0 211 91"
                            fill="none">
                            <path
                                d="M0 38.7664V32.8672C2.50105 32.8672 4.37475 32.2857 5.56169 31.1817C7.04537 29.7827 7.31664 27.5916 7.63034 25.0549C8.02881 21.8525 8.47818 18.2202 11.5218 15.3717C13.8448 13.1974 17.092 12.0934 21.1784 12.085V17.9843C18.635 17.9843 16.7698 18.5573 15.5828 19.6698C14.0992 21.0519 13.8279 23.243 13.5142 25.7797C13.1157 28.9821 12.6664 32.6144 9.62271 35.4713C7.28274 37.6288 4.05255 38.7412 0 38.7664ZM36.5748 38.5389C41.4158 38.3113 45.5701 36.2803 47.6896 33.0948C48.8164 31.3325 49.4054 29.2835 49.3852 27.1955L49.3174 12.1103H43.3827L43.476 27.1112C43.4978 28.0584 43.2447 28.9917 42.7468 29.7996C41.6956 31.3755 39.1606 32.4795 36.295 32.6144C33.4294 32.7492 30.5468 31.8222 29.2581 30.2378C28.6333 29.4219 28.2568 28.4451 28.1729 27.4231V12.0766H22.2382V27.9287C22.4262 30.1354 23.2603 32.2389 24.6375 33.9796C26.9945 36.8871 31.0725 38.5642 35.6591 38.5642C35.9728 38.5642 36.278 38.5557 36.6002 38.5389H36.5748ZM88.0117 17.5544C85.8922 14.3689 81.7294 12.3294 76.8884 12.1019C74.656 11.9778 72.4209 12.2899 70.3093 13.0205C68.7344 12.4826 67.0897 12.1732 65.4259 12.1019C60.4662 11.8659 56.0067 13.5682 53.4971 16.6611C52.1199 18.4018 51.2858 20.5054 51.0978 22.7121V38.5642H57.0325V23.1756C57.1244 22.154 57.5034 21.1786 58.1262 20.3608C59.2538 18.9787 61.5175 18.0854 64.0609 17.9758C64.4255 17.9758 64.79 17.9758 65.1631 17.9758C67.0254 18.0225 68.8385 18.5795 70.4026 19.5855C72.2333 18.363 74.4276 17.7954 76.6255 17.9758H76.8375C79.6268 18.1528 82.0601 19.24 83.0774 20.7738C83.5643 21.5589 83.8198 22.464 83.815 23.3863L83.7217 38.4631L89.6564 38.5052L89.7497 23.3357C89.7406 21.2828 89.1373 19.2758 88.0117 17.5544ZM97.7446 23.1756C97.8351 22.1536 98.2142 21.1779 98.8383 20.3608C100.127 18.7764 102.882 17.8326 105.867 17.9843C108.851 18.136 111.267 19.2231 112.319 20.799C112.806 21.5834 113.059 22.4896 113.048 23.4116L112.954 38.4883L118.889 38.5305L118.982 23.361C119 21.2945 118.411 19.2677 117.287 17.5292C115.159 14.3436 111.004 12.3041 106.163 12.0766C101.322 11.849 96.7527 13.543 94.2347 16.6359C92.8565 18.3753 92.0249 20.48 91.8438 22.6868V38.5389H97.7785L97.7446 23.1756ZM151.055 77.9543C155.888 77.7267 160.051 75.6873 162.17 72.5017C163.299 70.7405 163.888 68.6908 163.866 66.6025L163.772 51.5088H157.838L157.931 66.5097C157.953 67.4569 157.7 68.3902 157.202 69.1981C156.151 70.774 153.616 71.8781 150.742 72.0129C147.867 72.1477 145.002 71.2207 143.713 69.6363C143.089 68.8193 142.71 67.8435 142.619 66.8215V51.4835H136.685V66.9985V67.3019C136.873 69.5086 137.707 71.6121 139.084 73.3528C141.441 76.2519 145.519 77.9374 150.106 77.9374L151.055 77.9543ZM126.731 12.085H120.797V38.6316H126.731V12.085ZM35.7015 51.4835H29.7668V78.0301H35.7015V51.4835ZM179.72 25.5016C179.722 22.846 178.931 20.2496 177.448 18.0408C175.965 15.8319 173.856 14.1099 171.388 13.0925C168.921 12.0751 166.205 11.808 163.585 12.3251C160.964 12.8422 158.557 14.1201 156.667 15.9973C154.778 17.8744 153.49 20.2665 152.969 22.871C152.447 25.4754 152.714 28.1751 153.736 30.6287C154.758 33.0823 156.489 35.1795 158.71 36.655C160.931 38.1306 163.543 38.9181 166.214 38.9181C169.79 38.9026 173.215 37.4844 175.744 34.9719C178.273 32.4594 179.702 29.0559 179.72 25.5016ZM173.785 25.5016C173.785 26.99 173.341 28.4451 172.509 29.6827C171.677 30.9203 170.495 31.8849 169.111 32.4545C167.728 33.0241 166.206 33.1731 164.737 32.8827C163.268 32.5924 161.919 31.8756 160.861 30.8231C159.802 29.7706 159.081 28.4296 158.789 26.9698C158.497 25.5099 158.646 23.9968 159.219 22.6216C159.793 21.2465 160.763 20.0711 162.008 19.2442C163.253 18.4172 164.717 17.9758 166.214 17.9758C168.221 17.9781 170.146 18.7717 171.565 20.1825C172.985 21.5934 173.783 23.5063 173.785 25.5016ZM134.887 64.7568C134.886 62.104 134.093 59.5112 132.609 57.3061C131.125 55.1011 129.017 53.3828 126.551 52.3684C124.085 51.354 121.372 51.0889 118.755 51.6069C116.138 52.1248 113.733 53.4025 111.846 55.2783C109.959 57.1541 108.674 59.544 108.153 62.1457C107.632 64.7475 107.898 67.4444 108.919 69.8956C109.939 72.3468 111.668 74.4423 113.886 75.9172C116.105 77.3921 118.713 78.1802 121.382 78.1818C124.963 78.1796 128.397 76.7644 130.929 74.2472C133.462 71.73 134.885 68.3167 134.887 64.7568ZM128.953 64.7568C128.953 66.2436 128.509 67.697 127.678 68.9332C126.847 70.1695 125.666 71.1329 124.284 71.7019C122.902 72.2709 121.382 72.4198 119.915 72.1297C118.448 71.8397 117.1 71.1237 116.043 70.0724C114.985 69.021 114.265 67.6816 113.973 66.2234C113.681 64.7652 113.831 63.2537 114.403 61.8801C114.976 60.5064 115.945 59.3324 117.189 58.5064C118.432 57.6804 119.894 57.2395 121.39 57.2395C123.395 57.2439 125.315 58.0374 126.733 59.4462C128.15 60.855 128.948 62.7645 128.953 64.7568ZM99.8302 64.2427C99.8879 62.4008 100.673 60.6554 102.015 59.3843C103.357 58.1131 105.149 57.4183 107.003 57.4502L107.054 51.5509C103.642 51.5053 100.349 52.7961 97.8869 55.1442C95.4247 57.4923 93.991 60.7091 93.8955 64.0995V78.3756H99.8302V64.2427ZM51.5048 72.9905C50.5427 72.9959 49.5893 72.8109 48.6999 72.4463C47.8106 72.0816 47.0031 71.5447 46.3246 70.8668C45.1205 69.6149 44.4155 67.9704 44.3407 66.24V57.4502H51.013V51.5509H44.2729L44.2305 39.8114L38.2958 44.5224C38.2958 51.7982 38.3241 59.071 38.3806 66.3412C38.4906 69.5704 39.7947 72.646 42.0432 74.9793C44.5354 77.4649 47.9151 78.8705 51.4454 78.8897H51.5387L51.5048 72.9905ZM187.672 13.4166C187.732 11.5761 188.518 9.83286 189.86 8.56349C191.202 7.29412 192.993 6.60048 194.845 6.63243L194.896 0.733187C193.132 0.729446 191.386 1.07226 189.756 1.7419C188.126 2.41154 186.646 3.39479 185.4 4.63512C183.151 6.96455 181.847 10.0378 181.738 13.2649V13.3239L181.822 23.4368L181.941 38.6653L187.672 38.6232V24.5493C187.686 24.2671 187.714 23.9858 187.757 23.7065C188.015 22.0314 188.876 20.5061 190.179 19.4136C191.483 18.3211 193.14 17.7354 194.845 17.7651L194.896 11.8659C192.343 11.8815 189.845 12.6022 187.681 13.9475L187.672 13.4166ZM203.416 13.5261C203.487 11.693 204.278 9.96054 205.618 8.70016C206.959 7.43978 208.744 6.7519 210.589 6.78412L210.64 0.884876C207.228 0.837117 203.935 2.1274 201.474 4.47618C199.012 6.82495 197.581 10.0431 197.49 13.4334V13.484L197.566 23.4537L197.694 38.7664H203.425V24.5998C203.438 24.3176 203.466 24.0363 203.51 23.7571C203.74 22.3213 204.405 20.9895 205.417 19.9394C206.096 19.2622 206.904 18.7258 207.793 18.3612C208.682 17.9967 209.635 17.8112 210.597 17.8157L210.648 11.9165C208.094 11.9307 205.594 12.6483 203.425 13.9896L203.416 13.5261ZM148.732 24.9201C147.866 23.6434 146.732 22.5681 145.409 21.7682L145.748 21.4311C147.989 19.0929 149.292 16.0203 149.41 12.7929V11.5625H143.476V12.6581C143.416 14.4986 142.63 16.2418 141.288 17.5112C139.946 18.7805 138.155 19.4742 136.303 19.4422C135.828 19.4422 135.362 19.4422 134.896 19.5181V0L128.961 5.10706V38.6232H134.896V25.4847C135.703 25.3613 136.521 25.319 137.338 25.3583C140.203 25.4931 142.738 26.5971 143.789 28.1731C144.27 28.9607 144.522 29.8647 144.519 30.7856L144.468 38.6232H150.402L150.453 30.7519C150.456 28.6826 149.856 26.6568 148.724 24.9201H148.732ZM171.165 66.9985V66.8468C170.953 62.6331 173.616 58.8576 177.363 57.9727C178.885 57.6397 180.472 57.7586 181.926 58.3144C183.381 58.8703 184.639 59.8387 185.544 61.0993C185.646 61.2341 187.884 64.4703 186.452 68.0604C185.901 69.3602 184.997 70.4817 183.841 71.299C182.685 72.1163 181.322 72.597 179.906 72.6871H176.515V78.5863H180.135H180.245C182.795 78.4331 185.249 77.5702 187.328 76.0964C189.408 74.6226 191.028 72.5972 192.005 70.2515C194.548 63.8888 190.886 58.3519 190.462 57.7367C188.88 55.5011 186.665 53.7844 184.098 52.8057C181.531 51.8271 178.729 51.6308 176.049 52.242C169.478 53.7842 164.959 60.0206 165.282 67.0744V85.3452L171.216 89.5758L171.165 66.9985ZM90.1228 87.3931C90.966 86.0471 91.418 84.4953 91.4284 82.9096V66.5266C91.7506 59.4644 87.2317 53.2365 80.6611 51.6942C77.9822 51.0799 75.1799 51.2737 72.6125 52.251C70.045 53.2283 67.8292 54.9446 66.2483 57.1805C65.8244 57.7957 62.1449 63.3326 64.7053 69.7038C65.6821 72.0458 67.3004 74.0685 69.3762 75.5419C71.4519 77.0152 73.9018 77.8802 76.4475 78.0385H76.5577H80.1779V72.1393H76.7866C75.3708 72.0492 74.0083 71.5685 72.8521 70.7512C71.6959 69.9339 70.7919 68.8124 70.2415 67.5126C68.8087 63.9562 71.0469 60.6947 71.1487 60.5515C72.0545 59.2915 73.3131 58.3242 74.7678 57.7698C76.2224 57.2154 77.809 57.0984 79.3301 57.4334C83.0774 58.2761 85.7395 62.1274 85.5276 66.3075V82.8843C85.5319 83.4437 85.3495 83.9887 85.009 84.434C84.6684 84.8793 84.1888 85.1998 83.6454 85.3452L85.3411 91C87.3174 90.4044 89.0138 89.1248 90.1228 87.3931ZM128.953 38.6232H128.673H128.953Z"
                                fill="url(#paint0_linear_468_1185)" />
                            <defs>
                                <linearGradient id="paint0_linear_468_1185" x1="-0.0339406" y1="46.0226"
                                    x2="143.526" y2="-29.344" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#6AA9FF" />
                                    <stop offset="0.44" stop-color="#7E73FF" />
                                    <stop offset="1" stop-color="#CA66F1" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="discountContent">
                            <div class="discountTitle">Скидка 10%</div>
                            <p class="text">Клубная карта Sumnikoff Group дает вам возможность получить все услуги
                                холдинга по
                                спец условиями, как привелигерованному клиенту</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="taplinkWrapper">
                <div class="taplinkItem">
                    <img src="{{ asset('images/image 2183.webp') }}" class="taplinkIMG">
                    <div class="taplinkContent">
                        <div class="subTitle">Центр физического и ментального здоровья</div>
                        <div class="title">ИстокиЯ</div>
                        <ul class="list">
                            <li class="listItem">
                                Йога и смежные практики
                            </li>
                            <li class="listItem">
                                Тело и здоровье
                            </li>
                            <li class="listItem">
                                Психология и личностный рост
                            </li>
                            <li class="listItem">
                                Авторские и эксклюзивные программы
                            </li>
                            <li class="listItem">
                                Программные пакеты
                            </li>
                            <li class="listItem">
                                Выездные сессии
                            </li>
                        </ul>
                        <div class="contactWrapper">
                            <a href="tel:+79649264147" class="contactItem">+7 (964) 926-41-47</a>
                            <a href="mail:istokiya@mail.ru" class="contactItem">istokiya@mail.ru</a>
                        </div>
                        <div class="socialWrapper">
                            <a href="https://vk.com/myistokiya" class="socialItem" rel="nofollow" target="_blank">
                                <img src="{{ asset('images/svg/vk.svg') }}" alt="VKontakte" loading="lazy"
                                    width="40" height="40" />
                            </a>
                            <a href="https://ok.ru/group/70000041551267" class="socialItem" rel="nofollow"
                                target="_blank">
                                <img src="{{ asset('images/svg/ok.svg') }}" alt="ok" loading="lazy" width="40"
                                    height="40" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="taplinkItem">
                    <img src="{{ asset('images/image 2183.webp') }}" class="taplinkIMG">
                    <div class="taplinkContent">
                        <div class="subTitle">Центр физического и ментального здоровья</div>
                        <div class="title">ИстокиЯ</div>
                        <ul class="list">
                            <li class="listItem">
                                Йога и смежные практики
                            </li>
                            <li class="listItem">
                                Тело и здоровье
                            </li>
                            <li class="listItem">
                                Психология и личностный рост
                            </li>
                            <li class="listItem">
                                Авторские и эксклюзивные программы
                            </li>
                            <li class="listItem">
                                Программные пакеты
                            </li>
                            <li class="listItem">
                                Выездные сессии
                            </li>
                        </ul>
                        <div class="contactWrapper">
                            <a href="tel:+79649264147" class="contactItem">+7 (964) 926-41-47</a>
                            <a href="mail:istokiya@mail.ru" class="contactItem">istokiya@mail.ru</a>
                        </div>
                        <div class="socialWrapper">
                            <a href="https://vk.com/myistokiya" class="socialItem" rel="nofollow" target="_blank">
                                <img src="{{ asset('images/svg/vk.svg') }}" alt="VKontakte" loading="lazy"
                                    width="40" height="40" />
                            </a>
                            <a href="https://ok.ru/group/70000041551267" class="socialItem" rel="nofollow"
                                target="_blank">
                                <img src="{{ asset('images/svg/ok.svg') }}" alt="ok" loading="lazy"
                                    width="40" height="40" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="taplinkItem">
                    <img src="{{ asset('images/image 2183.webp') }}" class="taplinkIMG">
                    <div class="taplinkContent">
                        <div class="subTitle">Центр физического и ментального здоровья</div>
                        <div class="title">ИстокиЯ</div>
                        <ul class="list">
                            <li class="listItem">
                                Йога и смежные практики
                            </li>
                            <li class="listItem">
                                Тело и здоровье
                            </li>
                            <li class="listItem">
                                Психология и личностный рост
                            </li>
                            <li class="listItem">
                                Авторские и эксклюзивные программы
                            </li>
                            <li class="listItem">
                                Программные пакеты
                            </li>
                            <li class="listItem">
                                Выездные сессии
                            </li>
                        </ul>
                        <div class="contactWrapper">
                            <a href="tel:+79649264147" class="contactItem">+7 (964) 926-41-47</a>
                            <a href="mail:istokiya@mail.ru" class="contactItem">istokiya@mail.ru</a>
                        </div>
                        <div class="socialWrapper">
                            <a href="https://vk.com/myistokiya" class="socialItem" rel="nofollow" target="_blank">
                                <img src="{{ asset('images/svg/vk.svg') }}" alt="VKontakte" loading="lazy"
                                    width="40" height="40" />
                            </a>
                            <a href="https://ok.ru/group/70000041551267" class="socialItem" rel="nofollow"
                                target="_blank">
                                <img src="{{ asset('images/svg/ok.svg') }}" alt="ok" loading="lazy"
                                    width="40" height="40" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="taplinkItem">
                    <img src="{{ asset('images/image 2183.webp') }}" class="taplinkIMG">
                    <div class="taplinkContent">
                        <div class="subTitle">Центр физического и ментального здоровья</div>
                        <div class="title">ИстокиЯ</div>
                        <ul class="list">
                            <li class="listItem">
                                Йога и смежные практики
                            </li>
                            <li class="listItem">
                                Тело и здоровье
                            </li>
                            <li class="listItem">
                                Психология и личностный рост
                            </li>
                            <li class="listItem">
                                Авторские и эксклюзивные программы
                            </li>
                            <li class="listItem">
                                Программные пакеты
                            </li>
                            <li class="listItem">
                                Выездные сессии
                            </li>
                        </ul>
                        <div class="contactWrapper">
                            <a href="tel:+79649264147" class="contactItem">+7 (964) 926-41-47</a>
                            <a href="mail:istokiya@mail.ru" class="contactItem">istokiya@mail.ru</a>
                        </div>
                        <div class="socialWrapper">
                            <a href="https://vk.com/myistokiya" class="socialItem" rel="nofollow" target="_blank">
                                <img src="{{ asset('images/svg/vk.svg') }}" alt="VKontakte" loading="lazy"
                                    width="40" height="40" />
                            </a>
                            <a href="https://ok.ru/group/70000041551267" class="socialItem" rel="nofollow"
                                target="_blank">
                                <img src="{{ asset('images/svg/ok.svg') }}" alt="ok" loading="lazy"
                                    width="40" height="40" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="personalBlock">
                <img src="{{ asset('images/photo_2025-07-31_13-13-22.jpg.webp') }}" class="personalBlockIMG">
                <div class="personalContent">
                    <div class="title">Сумников Илья Алексеевич</div>
                    <p class="text">
                        Предприниматель, основатель веб-студии. <br>
                        В области маркетинга с 2005 года
                    </p>
                    <div class="contactWrapper">
                        <a href="tel:+79997824239" class="contactItem">+7 (999) 782-42-39</a>
                        <a href="https://www.rusprofile.ru/ip/308715430300052" class="contactItem" target="_blank"
                            rel="nofollow">rusprofile.ru</a>
                        <a href="https://vk.com/myistokiya" class="socialItem" rel="nofollow" target="_blank">
                            <img src="{{ asset('images/svg/vk.svg') }}" alt="VKontakte" loading="lazy"
                                width="40" height="40" />
                        </a>
                        <a href="https://ok.ru/group/70000041551267" class="socialItem" rel="nofollow"
                            target="_blank">
                            <img src="{{ asset('images/svg/ok.svg') }}" alt="ok" loading="lazy"
                                width="40" height="40" />
                        </a>
                    </div>
                    <div class="personalDate">
                        <div class="personalName">ИП</div>
                        <div class="personalVal">Сумников Илья Алексеевич</div>
                        <div class="personalName">ОГРНИП</div>
                        <div class="personalVal">308715430300052</div>
                        <div class="personalName">ИНН</div>
                        <div class="personalVal">710607061715</div>
                        <div class="personalName">Дата регистрации</div>
                        <div class="personalVal">29 октября 2008 г.</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('partials.footer')
</body>

</html>
