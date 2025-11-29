document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show'); // موبایل: کلاس show اضافه شد
        });
    }

    // باز و بسته شدن submenu
    const submenuLinks = document.querySelectorAll('.nav-item.has-submenu > .sidebar-link');
    submenuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const parentLi = this.parentElement;
            parentLi.classList.toggle('open');
        });
    });
});
