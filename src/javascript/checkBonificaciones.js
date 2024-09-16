function calcularBonificadores(atributo, cantidad){
    const BElement = document.getElementById(`${atributo}B`);
    BElement.textContent = Math.floor((cantidad - 10) / 2);
}
function calcularBonificaciones() {
    const raza = document.getElementById('raza').value;
    document.getElementById('limite').textContent=27;
    
    let Fuerza = 10;
    let Destreza = 10;
    let Constitución = 10;
    let Inteligencia = 10;
    let Sabiduría = 10;
    let Carisma = 10;

    switch (raza) {
        case 'Humano':
            Fuerza++;
            Destreza++;
            Constitución++;
            Inteligencia++;
            Sabiduría++;
            Carisma++;
            break;
        case 'Elfo':
            Destreza += 2;
            Inteligencia++;
            break;
        case 'Enano':
            Constitución += 2;
            Sabiduría++;
            break;
        case 'Mediano':
            Destreza += 2;
            Carisma++;
            break;
        case 'Orco':
            Fuerza += 2;
            Constitución++;
            break;
        case 'Gnomo':
            Inteligencia += 2;
            Constitución++;
            break;
        case 'Semielfo':
            Carisma += 2;
            document.getElementById('limite').textContent=29;
            break;
        case 'Semiorco':
            Fuerza += 2;
            Constitución++;
            break;
        case 'Tiflin':
            Carisma += 2;
            Inteligencia++;
            break;
        case 'Dracónido':
            Fuerza += 2;
            Carisma++;
            break;
    }
    
    calcularBonificadores('Fuerza',Fuerza);
    calcularBonificadores('Destreza',Destreza);
    calcularBonificadores('Constitución',Constitución);
    calcularBonificadores('Inteligencia',Inteligencia);
    calcularBonificadores('Sabiduría',Sabiduría);
    calcularBonificadores('Carisma',Carisma);


    document.getElementById('Fuerza_base').textContent = Fuerza;
    document.getElementById('Destreza_base').textContent = Destreza;
    document.getElementById('Constitución_base').textContent = Constitución;
    document.getElementById('Inteligencia_base').textContent = Inteligencia;
    document.getElementById('Sabiduría_base').textContent = Sabiduría;
    document.getElementById('Carisma_base').textContent = Carisma;
}


