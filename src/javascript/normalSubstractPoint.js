function substractPoints(atributo) {
    event.preventDefault();
    const numberElement = document.getElementById(`${atributo}_base`);
    const BElement = document.getElementById(`${atributo}B`);

    let number = parseInt(numberElement.textContent, 10);

    if (number > 8) {

        numberElement.textContent = number - 1;
        number--;
        document.getElementById(`${atributo}_base_hidden`).value = number;
        const bonificador = Math.floor((number - 10) / 2);
        BElement.textContent = bonificador;
    } else {
        alert("Ya no puedes quitar más puntos.");
    }
}

["Fuerza", "Destreza", "Constitución", "Inteligencia", "Sabiduría", "Carisma"].forEach(atributo => {
    document.getElementById(`${atributo}_-`).addEventListener('click', function () {
        substractPoints(atributo);
    });
});