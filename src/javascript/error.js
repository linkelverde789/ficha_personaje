fetch('../learnSpell.php', {
    method: 'POST'
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        alert("El hechizo ha sido aprendido correctamente.");
        window.location.href = 'hechizos.php';
        
    } else {
        alert("Error: " + data.message);
        window.location.href = 'hechizos.php';
        
    }
})
.catch(error => {
    alert("Error en la comunicación con el servidor: " + error.message);
});
