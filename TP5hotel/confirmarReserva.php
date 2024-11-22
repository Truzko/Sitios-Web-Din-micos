<?php
// Recuperar datos del formulario
$habitacion_id = $_POST['habitacion_id'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];

// Conectar a la base de datos 
$server= "localhost";
$user = "root";
$pass= "";
$db= "tphotel";

$conexion = new mysqli($server, $user, $pass, $db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar disponibilidad nuevamente para evitar reservas duplicadas
$query = "SELECT * FROM habitaciones WHERE id = $habitacion_id AND id NOT IN (
    SELECT habitacion_id FROM reservas WHERE ('$checkin' < checkout AND '$checkout' > checkin)
)";
$resultado = $conexion->query($query);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
    <link rel="stylesheet" href="css/confirmarReserva.css">
</head>
<body>
<?php
if ($resultado->num_rows > 0) {
    // Insertar reserva en la base de datos
    $query = "INSERT INTO reservas (habitacion_id, checkin, checkout, nombre, email, telefono) VALUES ('$habitacion_id', '$checkin', '$checkout', '$nombre', '$email', '$telefono')";
    if ($conexion->query($query) === TRUE) {
        echo "<div class='confirmation'>";
        echo "<h2>Reserva confirmada</h2>";
        echo "<p>Gracias por reservar con nosotros.</p>";
        echo "<p><strong>ID de Habitación:</strong> " . $habitacion_id . "</p>";
        echo "<p><strong>Check-in:</strong> " . $checkin . "</p>";
        echo "<p><strong>Check-out:</strong> " . $checkout . "</p>";
        echo "<p><strong>Nombre:</strong> " . $nombre . "</p>";
        echo "</div>";
    } else {
        echo "Error: " . $query . "<br>" . $conexion->error;
    }
} else {
    echo "Lo sentimos, la habitación ya no está disponible para las fechas seleccionadas.";
}

$conexion->close();
?>
</body>
</html>

