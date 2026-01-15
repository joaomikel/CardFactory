document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.querySelector('.menu-btn');
    const sidebar = document.querySelector('.sidebar');
    const closeBtn = document.querySelector('.close-btn');

    // Abrir menú lateral
    menuBtn.addEventListener('click', () => {
        sidebar.style.left = '0';
    });

    // Cerrar menú lateral
    closeBtn.addEventListener('click', () => {
        sidebar.style.left = '-100%';
    });
});