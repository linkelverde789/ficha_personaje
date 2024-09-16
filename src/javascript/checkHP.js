function checkHP() {
    const clase = document.getElementById('clase').value;
    let vida = 0;
    let bonificador = parseInt(document.getElementById('ConstituciónB').textContent, 10);

    if (isNaN(bonificador)) {
        bonificador = 0;
    }
    switch (clase) {
        case 'Barbaro':
            vida = 12;
            break;
        case 'Guerrero':
            vida = 10;
            break;
        case 'Paladin':
            vida = 10;
            break;
        case 'Explorador':
            vida = 10;
            break;
        case 'Bardo':
            vida = 8;
            break;
        case 'Clerigo':
            vida = 8;
            break;
        case 'Druida':
            vida = 8;
            break;
        case 'Monje':
            vida = 8;
            break;
        case 'Picaro':
            vida = 8;
            break;
        case 'Brujo':
            vida = 8;
            break;
        case 'Hechicero':
            vida = 6;
            break;
        case 'Mago':
            vida = 6;
            break;
        default:
            vida = 10;
            break;
    }
    document.getElementById('HP').textContent = vida + bonificador;
    document.getElementById('HP_hidden').value = vida + bonificador;
    if (document.getElementById('hit').style.display == 'none') {
        document.getElementById('hit').style.display = 'block';
    }
}