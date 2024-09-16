function showForm(){
    var tipo = document.getElementById('choseObject').value;
document.getElementById('weapon').style.display = tipo == 'arma' ? 'block' : 'none';
document.getElementById('armor').style.display = tipo == 'armadura' ? 'block' : 'none';
document.getElementById('shield').style.display = tipo == 'escudo' ? 'block' : 'none';
document.getElementById('other').style.display = tipo == 'otros' ? 'block' : 'none';

}