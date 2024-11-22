<?php
$server= "localhost";
$user = "root";
$pass= "";
$db= "tphotel";

$conexion = new mysqli($server, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$query = "SELECT * FROM reservas";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Reservas</title>
    <link rel="stylesheet" href="css/totalReservas.css">
</head>
<body>
    <h1>Historial de Reservas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Habitación</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($reserva = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $reserva['id']; ?></td>
                    <td><?php echo $reserva['habitacion_id']; ?></td>
                    <td><?php echo $reserva['checkin']; ?></td>
                    <td><?php echo $reserva['checkout']; ?></td>
                    <td><?php echo $reserva['nombre']; ?></td>
                    <td><?php echo $reserva['email']; ?></td>
                    <td><?php echo $reserva['telefono']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conexion->close();
?>
