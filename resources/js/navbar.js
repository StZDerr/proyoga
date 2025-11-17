import Headroom from "headroom.js";

document.addEventListener("DOMContentLoaded", () => {
    const header = document.querySelector(".site-header");
    const headroom = new Headroom(header, {
        tolerance: 5,
        offset: 100,
        classes: {
            initial: "headroom",
            pinned: "headroom--pinned",
            unpinned: "headroom--unpinned",
            top: "headroom--top",
            notTop: "headroom--not-top",
        },
    });
    headroom.init();

    // Burger menu
    const menuToggle = document.getElementById("menuToggle");
    const menu = document.getElementById("menu");

    const toggleMenu = () => {
        menuToggle.classList.toggle("active");
        menu.classList.toggle("show");
        document.body.classList.toggle("menu-open");
    };

    menuToggle.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && menu.classList.contains("show")) toggleMenu();
    });
});
