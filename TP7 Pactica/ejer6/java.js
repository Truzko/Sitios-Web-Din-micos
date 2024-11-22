function calcular() {
    var numero1 = parseFloat(document.getElementById('numero1').value);
    let array = [0,1];
    for(let i = 0 ; i < numero1 ; i++){
        array.push(array[i] +  array[i+1]);
    document.getElementById('figo').innerText = array[i];
    console.log(array[i]);
    }
}