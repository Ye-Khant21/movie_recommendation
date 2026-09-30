document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-nav-toggle]');
    const menu = document.querySelector('[data-nav-menu]');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

    document.querySelectorAll('[data-ui-form]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const notice = form.querySelector('[data-form-success]');

            if (notice) {
                notice.hidden = false;
            }

            form.reset();
        });
    });
});
