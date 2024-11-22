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

// Obtener detalles de la habitación
$habitacion_id = $_GET['id'];
$query = "SELECT * FROM habitaciones WHERE id = $habitacion_id";
$resultado = $conexion->query($query);
$habitacion = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Habitación</title>
        <link rel="stylesheet" href="css/verMas.css">
</head>
<body>
    <h1><?php echo $habitacion['nombre']; ?></h1>

    <div class="habitacion-detalle">

        <?php if($habitacion['id']== 3){ $rutaImagen = '/TP5hotel/imagenes/habitacionsuite.jpg';} ?>
        <?php if($habitacion['id']== 2){ $rutaImagen = '/TP5hotel/imagenes/habitaciondoble.jpg';} ?>
        <?php if($habitacion['id']== 1){ $rutaImagen = '/TP5hotel/imagenes/habitacionsimple.jpg';} ?>
        <img src="<?php echo $rutaImagen; ?>" ">
       
       <?php if($habitacion['id']== 3){ echo "La Habitacion Suite es un ejemplo perfecto de lujo y sofisticación. Esta espaciosa suite de 200 centímetros cuadrados 
             ofrece un refugio elegante y acogedor para nuestros huéspedes.";};

        
         if($habitacion['id']== 2){ echo "La habitación doble cachau ofrece el equilibrio perfecto entre 
        comodidad y funcionalidad, ideal para parejas que buscan una estancia relajante y veloz. 
        Esta habitación espaciosa está equipada con una cama veloz ultra supreme, vestidas con sábanas de alta calidad y 
        almohadas suaves que garantizan un descanso reparador y cachau.";};

         if($habitacion['id']== 1){ echo "La habitación simple de nuestro hotel está diseñada para
         proporcionar una estancia confortable y funcional a los viajeros individuales. "
         ;};?>
           
        </div>  

          <a class="boton-reserva" href="reserva.php?habitacion_id=<?php echo $habitacion['id']; ?>">Reservar</a> <br>
      
        </div>
</body>
</html>

<?php
/*<img src="<?php echo $habitacion['imagen']; ?>" alt="<?php echo $habitacion['nombre']; ?>">*/
$conexion->close();
?>
