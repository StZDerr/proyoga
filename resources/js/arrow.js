const btn = document.getElementById("arrowUp");

// Показать кнопку при прокрутке вниз
window.addEventListener("scroll", () => {
    if (window.scrollY > 200) {
        btn.classList.add("show");
    } else {
        btn.classList.remove("show");
    }
});

// Прокрутка вверх при клике
btn.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});
