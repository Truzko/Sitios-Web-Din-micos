function sumar() {

    var numero1 = parseFloat(document.getElementById('numero1').value);
    var numero2 = parseFloat(document.getElementById('numero2').value);
    var numero3 = parseFloat(document.getElementById('numero3').value);

    var resultado = numero1 + numero2 + numero3;

    document.getElementById('gastosTotales').innerText = 'gastos totales: ' + resultado + '$';

}