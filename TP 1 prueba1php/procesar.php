<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesamiento de Datos</title>
</head>
<body>
    <h2>Datos Recibidos:</h2>
    <?php
    // Verificar si se han enviado los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar el nombre y el nivel de estudios del formulario
        $nombre = $_POST["nombre"];
        $nivel_estudios = $_POST["estudios"];

        // Mostrar el nombre y el nivel de estudios
        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Nivel de Estudios:</strong> $nivel_estudios</p>";
    } else {
        // Si no se han enviado los datos del formulario, mostrar un mensaje de error
        echo "<p>Error: No se recibieron datos del formulario.</p>";
    }
    ?>
</body>
</html>

