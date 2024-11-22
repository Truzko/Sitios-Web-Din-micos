<?php
$server= "localhost";
$user = "root";
$pass= "";
$db= "tphotel";

$conexion = new mysqli($server, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$checkin = $_GET['checkin'];
$checkout = $_GET['checkout'];
$huespedes = $_GET['huespedes'];

// Consulta SQL para buscar habitaciones disponibles con la capacidad especificada
$query = "SELECT * FROM habitaciones 
          WHERE capacidad >= $huespedes 
          AND id NOT IN (
              SELECT habitacion_id FROM reservas 
              WHERE ('$checkin' < checkout AND '$checkout' > checkin)
          )";

$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones Disponibles</title>
    <link rel="stylesheet" href="css/buscar.css">
</head>
<body>
    <h1>Habitaciones Disponibles</h1>
    <div class="habitaciones">
        <?php while ($habitacion = $resultado->fetch_assoc()) { ?>
            <div class="habitacion">
                <h2><?php echo $habitacion['nombre']; ?></h2>
                <p><?php echo $habitacion['descripcion']; ?></p>

                <p>Precio por noche: $<?php echo $habitacion['precio']; ?></p>
                <a href="verMas.php?id=<?php echo $habitacion['id']; ?>&checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>">Ver más</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>

<?php
$conexion->close();
?>
