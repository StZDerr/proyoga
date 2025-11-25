import IMask from "imask";

const phoneInput = document.getElementById("phone");

if (phoneInput) {
    IMask(phoneInput, {
        mask: "+{7} (000) 000-00-00", // Маска для России
        lazy: false, // Показывает шаблон сразу
        placeholderChar: "-", // Символ-заполнитель
    });
}
