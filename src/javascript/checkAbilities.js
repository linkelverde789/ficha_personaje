function obtenerHabilidades() {
    let habilidades;
    const transfondo=document.getElementById('transfondo').value;

    switch (transfondo) {
        case 'Acólito':
            habilidades = ['Persuasión', 'Religión'];
            break;
        case 'Criminal':
            habilidades = ['Engaño', 'Sigilo'];
            break;
        case 'Erudito':
            habilidades = ['Arcanos', 'Historia'];
            break;
        case 'Héroe del Pueblo':
            habilidades = ['Trato con animales', 'Supervivencia'];
            break;
        case 'Noble':
            habilidades = ['Historia', 'Persuasión'];
            break;
        case 'Forastero':
            habilidades = ['Atletismo', 'Supervivencia'];
            break;
        case 'Soldado':
            habilidades = ['Atletismo', 'Intimidación'];
            break;
        case 'Artista':
            habilidades = ['Acrobacias', 'Interpretación'];
            break;
        case 'Marinero':
            habilidades = ['Atletismo', 'Percepción'];
            break;
        case 'Charlatán':
            habilidades = ['Engaño', 'Juego de manos'];
            break;
        case 'Huérfano':
            habilidades = ['Sigilo', 'Juego de manos'];
            break;
        case 'Artesano del Gremio':
            habilidades = ['Persuasión', 'Perspicacia'];
            break;
        case 'Ermitaño':
            habilidades = ['Medicina', 'Religión'];
            break;
        case 'Nómada':
            habilidades = ['Atletismo', 'Supervivencia'];
            break;
        default:
            habilidades = [];
            break;
    }
    document.getElementById('habilidades').textContent=habilidades.join(', ');
    const field=document.getElementById('divHabilidad');
    field.style.display='block'
}
