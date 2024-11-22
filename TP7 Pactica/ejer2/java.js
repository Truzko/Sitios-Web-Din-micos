function calcular() {

    var numero1 = parseFloat(document.getElementById('numero1').value);


    var resultado = numero1 * 7;

    document.getElementById('gastosTotales').innerText = 'su perro tiene ' + resultado + ' años humanos';

}