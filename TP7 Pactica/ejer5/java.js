function calcular() {
//Tiene que dar numeros primos y da numeros inpares
    var numero1 = parseFloat(document.getElementById('numero1').value);
    var numero2 = parseFloat(document.getElementById('numero2').value);

    for(i=numero1 ; i<=numero2; i++){
        
        if(i%2 != 0){
        document.getElementById('resulatado').innerText = i;
        console.log(i);
        
        }    
    }
}