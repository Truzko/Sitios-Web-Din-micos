<?php
$habitacion_id = isset($_GET['habitacion_id']) ? $_GET['habitacion_id'] : '';
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';

$server= "localhost";
$user = "root";
$pass= "";
$db= "tphotel";

$conexion = new mysqli($server, $user, $pass, $db);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reserva.css"> 
    <title>Formulario de Reserva</title>

</head>
<body>
    <form action="confirmarReserva.php" method="post">
        <label for="habitacion_id">ID de Habitación:</label>
        <input type="text" id="habitacion_id" name="habitacion_id" required><br>
        
        <label for="checkin">Fecha de Check-in:</label>
        <input type="date" id="checkin" name="checkin" required><br>
        
        <label for="checkout">Fecha de Check-out:</label>
        <input type="date" id="checkout" name="checkout" required><br>
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br>

        <label for="huespedes">Cantidad de Huespedes:</label>
        <input type="number" id="huespedes" name="huespedes" required><br> <!--Añadir a la base de datos-->
        
        <button type="submit">Reservar</button>
    </form>
</body>
</html>
