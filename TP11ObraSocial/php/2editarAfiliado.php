<?php
require '0conexion.php'; // Asegúrate de tener una conexión a la base de datos aquí

if (isset($_GET['id'])) {
    $id_afiliado = $_GET['id'];
    
    // Obtener los datos del afiliado
    $stmt = $conn->prepare("SELECT * FROM afiliados WHERE id_afiliado = ?");
    $stmt->bind_param("i", $id_afiliado);
    $stmt->execute();
    $result = $stmt->get_result();
    $afiliado = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualizar los datos del afiliado
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $plan_cobertura_id = $_POST['plan_cobertura_id'];
    $estado_cuenta = $_POST['estado_cuenta'];
    
    $stmt = $conn->prepare("UPDATE afiliados SET nombre = ?, apellido = ?, direccion = ?, telefono = ?, email = ?, fecha_nacimiento = ?, plan_cobertura_id = ?, estado_cuenta = ? WHERE id_afiliado = ?");
    $stmt->bind_param("ssssssisi", $nombre, $apellido, $direccion, $telefono, $email, $fecha_nacimiento, $plan_cobertura_id, $estado_cuenta, $id_afiliado);
    
    if ($stmt->execute()) {
        header("Location: 2Administracion.php"); // Redirige a administracion.php después de guardar los cambios
        exit();
    } else {
        echo "Error al actualizar los datos del afiliado.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Editar Afiliado</title>
</head>
<body>
<div class="container">
    <h2>Editar Afiliado</h2>
    <form action="2editarAfiliado.php?id=<?php echo $id_afiliado; ?>" method="post">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $afiliado['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?php echo $afiliado['apellido']; ?>" required>
        </div>
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?php echo $afiliado['direccion']; ?>" required>
        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?php echo $afiliado['telefono']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $afiliado['email']; ?>" required>
        </div>
        <div class="form-group">
            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo $afiliado['fecha_nacimiento']; ?>" required>
        </div>
        <div class="form-group">
            <label>Plan de Cobertura</label>
            <input type="number" name="plan_cobertura_id" class="form-control" value="<?php echo $afiliado['plan_cobertura_id']; ?>" required>
        </div>
        <div class="form-group">
            <label>Estado de Cuenta</label>
            <input type="text" name="estado_cuenta" class="form-control" value="<?php echo $afiliado['estado_cuenta']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
</body>
</html>
