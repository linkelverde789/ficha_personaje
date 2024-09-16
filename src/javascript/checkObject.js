document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const selects = form.querySelectorAll('select');
            let valid = true;

            selects.forEach(select => {
                if (select.value === "none") {
                    valid = false;
                    alert('Por favor, selecciona una opción válida.');
                }
            });

            if (!valid) {
                e.preventDefault();
            }
        });
    });
});
