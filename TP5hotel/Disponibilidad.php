
<?php
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

// Obtener habitaciones disponibles
$query = "SELECT * FROM habitaciones";
$resultado = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones Disponibles</title>
    <link rel="stylesheet" href="css/Dhabitaciones.css">
</head>
<body>
    <h1 class="nombre">Hotel Rikon</h1>

    <h3>Porque un campeon del mundo duerme donde quiere, cuando quiere:</h3>

    <script>
        function validarFechas() {
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;

            if (checkin >= checkout) {
                alert('La fecha de Check-in debe ser menor que la fecha de Check-out.');
                return false;
            }
            return true;
        }
    </script>

    <h1>Buscar Habitaciones</h1>
    <div class="busqueda">

        <form action="busca.php" method="get" onsubmit="return validarFechas()">

            <label for="checkin">Fecha de Check-in:</label>
            <input type="date" id="checkin" name="checkin" required>

            <label for="checkout">Fecha de Check-out:</label>
            <input type="date" id="checkout" name="checkout" required>

            <label for="huespedes">Cantidad de Huéspedes:</label>
            <input type="number" id="huespedes" name="huespedes" min="1" required>

            <button class="buscar" type="submit">Buscar</button>
        </form>

        <form action="TotalReservas.php" method="post">
            <button class="buscar" type="submit">Reservas</button>
        </form>
    </div>
</body>
</html>

    <div class="habitaciones">
        <?php 
        while ($habitacion = $resultado->fetch_assoc()) { 
        ?>
            <div class="habitacion">
                <h2><?php echo $habitacion['nombre']; ?></h2>
                <p><?php echo $habitacion['descripcion']; ?></p>
                <?php if($habitacion['id']== 3){ $rutaImagen = '/TP5hotel/imagenes/habitacionsuite.jpg';} ?>
                <?php if($habitacion['id']== 2){ $rutaImagen = '/TP5hotel/imagenes/habitaciondoble.jpg';} ?>
                <?php if($habitacion['id']== 1){ $rutaImagen = '/TP5hotel/imagenes/habitacionsimple.jpg';} ?>
                <img src="<?php echo $rutaImagen; ?>" ">
                <p>Precio por noche: $<?php echo $habitacion['precio']; ?></p>
              
            </div>
            <br>
            <a class="verMas" href="verMas.php?id=<?php echo $habitacion['id']; ?>">Ver más</a>

        <?php 
        } 
        ?>
    </div>
    
    <?php
    $conexion->close();
    ?>
    
    <br>
    <br>

    <footer>
        Todos los derechos reservados
    </footer>
</body>
</html>


