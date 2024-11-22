function calcular() {

    var numero1 = parseFloat(document.getElementById('numero1').value);
    var numero2 = parseFloat(document.getElementById('numero2').value);

    var descuento = numero1 * numero2 / 100;
    var resultado = numero1 - descuento;
    document.getElementById('precioFinal').innerText = 'El precio final es de ' + resultado + '$';

}