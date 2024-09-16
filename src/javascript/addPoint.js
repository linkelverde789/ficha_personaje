const costosPuntos = {
    8: 0, 9: 1, 10: 2, 11: 3, 12: 4,
    13: 5, 14: 7, 15: 9, 16: Infinity, 17: Infinity, 18: Infinity, 19: Infinity, 20: Infinity
};

function obtenerCosto(puntuacion) {
    return costosPuntos[puntuacion];
}

function incrementarAtributo(atributo) {
    event.preventDefault();

    const numberElement = document.getElementById(`${atributo}_base`);
    const limitElement = document.getElementById("limite");
    const BElement = document.getElementById(`${atributo}B`);

    let number = parseInt(numberElement.textContent, 10);
    let limit = parseInt(limitElement.textContent, 10);

    const costoActual = obtenerCosto(number);
    const costoSiguiente = obtenerCosto(number + 1);

    if (costoSiguiente <= limit && number < 15) {
        numberElement.textContent = number + 1;
        number++;

        limitElement.textContent = limit - (costoSiguiente - costoActual);

        document.getElementById(`${atributo}_base_hidden`).value = number;
        const bonificador = Math.floor((number - 10) / 2);
        BElement.textContent = bonificador;

        checkHP(bonificador);
    } else {
        alert("No tienes suficientes puntos o has alcanzado el máximo permitido.");
    }
}

["Fuerza", "Destreza", "Constitución", "Inteligencia", "Sabiduría", "Carisma"].forEach(atributo => {
    document.getElementById(`${atributo}_+`).addEventListener('click', function () {
        incrementarAtributo(atributo);
    });
});
