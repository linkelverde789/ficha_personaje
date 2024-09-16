function mostrarDescripcion() {

    const hechizoSeleccionado = document.getElementById("hechizos").value;

    const descripciones = document.querySelectorAll('p[id]');
    
    descripciones.forEach(function(p) {
        p.style.display = 'none';
    });

    if (hechizoSeleccionado) {
        const descripcion = document.getElementById(hechizoSeleccionado);
        if (descripcion) {
            descripcion.style.display = 'block';
        }
    }
}
