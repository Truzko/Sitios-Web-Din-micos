function celsiusAFahrenheit(celsius) {
    return (celsius * 9 / 5) + 32;
}

function fahrenheitACelsius(fahrenheit) {
    return (fahrenheit - 32) * 5 / 9;
}

function realizarConversion() {
    const tipoConversion = prompt(
        "¿Qué tipo de conversión deseas realizar?\n" +
        "1: Celsius a Fahrenheit\n" +
        "2: Fahrenheit a Celsius"
    );

    if (tipoConversion === "1") {
        const celsius = parseFloat(prompt("Inserta la temperatura en grados Celsius:"));
        if (!isNaN(celsius)) {
            const fahrenheit = celsiusAFahrenheit(celsius);
            alert(`${celsius} grados Celsius equivalen a ${fahrenheit.toFixed(2)} grados Fahrenheit.`);
        } else {
            alert("Por favor, ingresa un número válido.");
        }
    } else if (tipoConversion === "2") {
        const fahrenheit = parseFloat(prompt("Inserta la temperatura en grados Fahrenheit:"));
        if (!isNaN(fahrenheit)) {
            const celsius = fahrenheitACelsius(fahrenheit);
            alert(`${fahrenheit} grados Fahrenheit equivalen a ${celsius.toFixed(2)} grados Celsius.`);
        } else {
            alert("Por favor, ingresa un número válido.");
        }
    } else {
        alert("Opción no válida. Por favor, elige 1 o 2.");
    }
}