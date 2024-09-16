function addRollEvent(diceType, maxValue) {
    document.getElementById(diceType).addEventListener('click', function () {
        document.getElementById(diceType.replace('boton_d', '')).textContent = diceType.replace('boton_', '').toUpperCase() + ': ' + roll(maxValue);
    });
}

addRollEvent('boton_d20', 20);
addRollEvent('boton_d16', 16);
addRollEvent('boton_d12', 12);
addRollEvent('boton_d10', 10);
addRollEvent('boton_d8', 8);
addRollEvent('boton_d6', 6);
addRollEvent('boton_d4', 4);

function roll(max) {
    return Math.floor(Math.random() * max + 1);
}

document.querySelectorAll('button').forEach(button => {
    button.addEventListener('click', function() {
        const diceId = this.id.replace('boton_', ''); 
        const diceElement = document.getElementById(diceId);
        
        diceElement.classList.add('glow');
        
        setTimeout(() => {
            diceElement.classList.remove('glow');
        }, 500);
    });
});
