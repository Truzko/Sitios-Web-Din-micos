<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
</head>
<body>
    <h1>Confirmación de Pedido</h1>
    <h2>Detalles del Pedido:</h2>
    <?php
    // Verificar si se han enviado los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar los datos del formulario
        $nombre = $_POST["nombre"];
        $direccion = $_POST["direccion"];
        
        // Mostrar los datos del cliente
        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Dirección:</strong> $direccion</p>";
        
        // Mostrar los detalles del pedido
        if(isset($_POST["jamon_queso"])) {
            $cantidad_jamon_queso = $_POST["cantidad_jamon_queso"];
            echo "<p>Jamon y Queso (Cantidad: $cantidad_jamon_queso)</p>";
        }
        if(isset($_POST["napolitana"])) {
            $cantidad_napolitana = $_POST["cantidad_napolitana"];
            echo "<p>Napolitana (Cantidad: $cantidad_napolitana)</p>";
        }
        if(isset($_POST["mozzarella"])) {
            $cantidad_mozzarella = $_POST["cantidad_mozzarella"];
            echo "<p>Mozzarella (Cantidad: $cantidad_mozzarella)</p>";
        }
    } else {
        // Si no se han enviado los datos del formulario, mostrar un mensaje de error
        echo "<p>Error: No se recibieron datos del formulario.</p>";
    }
    ?>
</body>
</html>
