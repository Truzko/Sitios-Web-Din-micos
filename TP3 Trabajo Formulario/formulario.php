<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario procesado - Mi web</title>
</head>
<body>

<h1>Formulario procesado</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $nombre = $_GET["nombre"];
    $apellidos = $_GET["apellidos"];
    $sexo = $_GET["sexo"];
    $correo = $_GET["correo"];
    $info = isset($_GET["info"]) ? "Sí" : "No";
    $condiciones = isset($_GET["condiciones"]) ? "Aceptado" : "No aceptado";
    $poblacion = $_GET["poblacion"];
    $descripcion = $_GET["descripcion"];

    echo "<p>Nombre: $nombre</p>";
    echo "<p>Apellidos: $apellidos</p>";
    echo "<p>Sexo: $sexo</p>";
    echo "<p>Correo electrónico: $correo</p>";
    echo "<p>Desea recibir información: $info</p>";
    echo "<p>Condiciones aceptadas: $condiciones</p>";
    echo "<p>Población: $poblacion</p>";
    echo "<p>Descripción: $descripcion</p>";
} else {
    echo "<p>No se han recibido datos del formulario.</p>";
}
?>

</body>
</html>
