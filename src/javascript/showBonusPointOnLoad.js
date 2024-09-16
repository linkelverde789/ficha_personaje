function show(atributo) {
    const stat = document.getElementById(`${atributo}_base`);

    const value = parseInt(stat.textContent);

    const result = Math.floor((value - 10) / 2);

    document.getElementById(`${atributo}B`).textContent = result;
}

["Fuerza", "Destreza", "Constitución", "Inteligencia", "Sabiduría", "Carisma"].forEach(atributo => {
    document.addEventListener('DOMContentLoaded', function () {
        show(atributo);
    });
});
