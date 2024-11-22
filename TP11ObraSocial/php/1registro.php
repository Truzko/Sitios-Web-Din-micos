<?php
require '0conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $plan_cobertura_id = $_POST['plan_cobertura_id'];
    $usuario = $_POST['usuario'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    // Insertar en la tabla usuarios
    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, clave, rol) VALUES (?, ?, 'afiliado')");
    $stmt->bind_param("ss", $usuario, $clave);
    $stmt->execute();

    $id_usuario = $stmt->insert_id; // Obtener el id del usuario recién creado

    // Insertar en la tabla afiliados
    $stmt = $conn->prepare("INSERT INTO afiliados (id_usuario, nombre, apellido, direccion, telefono, email, fecha_nacimiento, plan_cobertura_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssi", $id_usuario, $nombre, $apellido, $direccion, $telefono, $email, $fecha_nacimiento, $plan_cobertura_id);
    $stmt->execute();

    $id_afiliado = $stmt->insert_id; // Obtener el id del afiliado recién creado

    // Obtener el costo del plan de cobertura seleccionado
    $stmt = $conn->prepare("SELECT costo FROM planes WHERE id_plan = ?");
    $stmt->bind_param("i", $plan_cobertura_id);
    $stmt->execute();
    $stmt->bind_result($costo);
    $stmt->fetch();
    $stmt->close();

    // Generar una factura inicial con estado 'pendiente' para el nuevo afiliado
    $fecha_vencimiento = date('Y-m-d', strtotime('+1 month')); // Fecha de vencimiento un mes desde hoy
    $estado = 'pendiente';

    $stmt = $conn->prepare("INSERT INTO facturas (id_afiliado, fecha_vencimiento, monto, estado) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $id_afiliado, $fecha_vencimiento, $costo, $estado);
    $stmt->execute();

    echo "Afiliado y factura registrados con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro de Afiliados</title>
</head>
<body>
<div class="container">
    <h2>Registro de Afiliados</h2>
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
        </div>
        <div class="form-group">
            <label for="plan_cobertura_id">Plan de Cobertura</label>
            <select class="form-control" id="plan_cobertura_id" name="plan_cobertura_id">
                <option value="1">Básico</option>
                <option value="2">Intermedio</option>
                <option value="3">Premium</option>
            </select>
        </div>
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
        <div class="form-group">
            <label for="clave">Contraseña</label>
            <input type="password" class="form-control" id="clave" name="clave" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
</body>
</html>
