function obtenerCosto(puntuacion) {
    return costosPuntos[puntuacion];
}

function substractPoints(atributo) {
    event.preventDefault();
    const numberElement = document.getElementById(`${atributo}_base`);
    const limitElement = document.getElementById("limite");
    const BElement = document.getElementById(`${atributo}B`);

    let number = parseInt(numberElement.textContent, 10);
    let limit = parseInt(limitElement.textContent, 10);

    if (number > 8) {
        const costoActual = obtenerCosto(number);
        const costoPrevio = obtenerCosto(number - 1);

        numberElement.textContent = number - 1;
        number--;

        limitElement.textContent = limit + (costoActual - costoPrevio);

        document.getElementById(`${atributo}_base_hidden`).value = number;
        const bonificador = Math.floor((number - 10) / 2);
        BElement.textContent = bonificador;

        checkHP(bonificador);
    } else {
        alert("Ya no puedes quitar más puntos.");
    }
}

["Fuerza", "Destreza", "Constitución", "Inteligencia", "Sabiduría", "Carisma"].forEach(atributo => {
    document.getElementById(`${atributo}_-`).addEventListener('click', function () {
        substractPoints(atributo);
    });
});
