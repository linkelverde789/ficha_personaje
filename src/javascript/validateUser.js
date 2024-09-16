document.getElementById('check').addEventListener('click', function () {
    let error = true;
    const password = document.getElementById('password').value.trim();
    const username = document.getElementById('name').value.trim();
    const confirm = document.getElementById('confirm').value.trim();
    const email = document.getElementById('email').value.trim();

    if (email.length < 5) {
        alert('Correo incorrecto.');
        error = false;
    }

    if (username.length < 5) {
        alert('El nombre de usuario debe tener al menos 5 caracteres.');
        error = false;
    }

    if (password.length < 8) {
        alert('La contraseña debe tener al menos 8 caracteres');
        error = false;
    }

    if (password !== confirm) {
        alert('Las contraseñas no coinciden');
        error = false;
    }

    if (error) {
        alert('Todo correcto.');
    }
});
