document.getElementById('formulario').addEventListener('submit', function (event) {
    const password = document.getElementById('password').value.trim();
    const confirm = document.getElementById('confirm').value.trim();

    if(password!==confirm){
        alert('Las contraseñas no coinciden');
        event.preventDefault();
        return;
    }
    if(password.length<8){
        alert('La contraseña debe tener al menos 8 caracteres');
        event.preventDefault();
        return;
    }
});