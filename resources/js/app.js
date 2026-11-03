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

    document.querySelectorAll('[data-comment-item]').forEach((item) => {
        const body = item.querySelector('[data-comment-body]');
        const editor = item.querySelector('[data-comment-editor]');
        const editButton = item.querySelector('[data-comment-edit]');
        const cancelButton = item.querySelector('[data-comment-cancel]');
        const deleteButton = item.querySelector('[data-comment-delete]');

        editButton?.addEventListener('click', () => {
            if (! body || ! editor) {
                return;
            }

            body.hidden = true;
            editor.hidden = false;
        });

        cancelButton?.addEventListener('click', () => {
            if (! body || ! editor) {
                return;
            }

            editor.hidden = true;
            body.hidden = false;
        });

        editor?.addEventListener('submit', (event) => {
            event.preventDefault();

            if (! body || ! editor) {
                return;
            }

            const textarea = editor.querySelector('textarea');

            if (textarea) {
                body.textContent = textarea.value;
            }

            editor.hidden = true;
            body.hidden = false;
        });

        deleteButton?.addEventListener('click', () => {
            item.remove();
        });
    });
});
