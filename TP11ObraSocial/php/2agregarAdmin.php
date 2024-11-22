<?php
session_start();
require '0conexion.php';



// Procesar el formulario al enviar los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_usuario = $_POST['usuario'];
    $nueva_clave = $_POST['clave'];

    // Verificar si el nombre de usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $nuevo_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $error = "El nombre de usuario ya existe. Intenta con otro.";
    } else {
        // Hashear la contraseña y guardar el nuevo administrador
        $hash_clave = password_hash($nueva_clave, PASSWORD_DEFAULT);
        $rol = 'administrador';

        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, clave, rol, fecha_creacion) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $nuevo_usuario, $hash_clave, $rol);

        if ($stmt->execute()) {
            $mensaje = "Administrador añadido exitosamente.";
        } else {
            $error = "Error al añadir el administrador. Intenta de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Agregar Administrador</title>
</head>
<body>
<div class="container">
    <h2>Agregar Nuevo Administrador</h2>
    
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
        <div class="form-group">
            <label for="clave">Contraseña</label>
            <input type="password" class="form-control" id="clave" name="clave" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Administrador</button>
    </form>
</div>
</body>
</html>
