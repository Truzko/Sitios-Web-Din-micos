<?php
session_start();
require '0conexion.php';

// Verificar que el usuario esté logueado y sea afiliado
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'afiliado') {
    header("Location: 1login.php");
    exit();
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Obtener el ID del afiliado asociado al usuario
$stmt = $conn->prepare("SELECT id_afiliado FROM afiliados WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $afiliado = $result->fetch_assoc();
    $id_afiliado = $afiliado['id_afiliado'];
} else {
    echo "No se encontró información del afiliado.";
    exit();
}

// Procesar el pago si se envió una solicitud POST con el ID de factura
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_factura'])) {
    $id_factura = $_POST['id_factura'];

    // Actualizar el estado de la factura a "pagada"
    $stmt = $conn->prepare("UPDATE facturas SET estado = 'pagada' WHERE id_factura = ? AND id_afiliado = ? AND estado = 'pendiente'");
    $stmt->bind_param("ii", $id_factura, $id_afiliado);
    $stmt->execute();
}

// **Nueva sección para registrar el uso de un servicio**
// Procesar el formulario si se envió una solicitud POST para usar un servicio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_servicio'])) {
    $id_servicio = $_POST['id_servicio'];

    // Insertar el uso del servicio en el historial
    $stmt = $conn->prepare("INSERT INTO historial_servicios (id_afiliado, id_servicio) VALUES (?, ?)");
    $stmt->bind_param("ii", $id_afiliado, $id_servicio);
    $stmt->execute();

    echo "<p class='alert alert-success'>Servicio registrado en el historial.</p>";
}

// Obtener información del afiliado (incluyendo plan)
$stmt = $conn->prepare("SELECT a.nombre, a.apellido, p.nombre_plan, p.costo
                         FROM afiliados a 
                         JOIN planes p ON a.plan_cobertura_id = p.id_plan 
                         WHERE a.id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $afiliado = $result->fetch_assoc();
} else {
    echo "No se encontró información del afiliado.";
    exit();
}

// Obtener beneficios del plan del afiliado
$stmt = $conn->prepare("
    SELECT s.id_servicio, s.nombre_servicio, s.descripcion, s.descuento, s.cantidad_gratuita 
    FROM servicios s 
    JOIN planes p ON s.id_plan = p.id_plan 
    WHERE p.id_plan = (SELECT plan_cobertura_id FROM afiliados WHERE id_afiliado = ?)
");
$stmt->bind_param("i", $id_afiliado);
$stmt->execute();
$beneficios = $stmt->get_result();

// Obtener facturas del afiliado
$stmt = $conn->prepare("SELECT id_factura, fecha_emision, fecha_vencimiento, monto, estado 
                         FROM facturas 
                         WHERE id_afiliado = ?");
$stmt->bind_param("i", $id_afiliado);
$stmt->execute();
$facturas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Mi Plan y Mis Facturas</title>
</head>
<body>

<div class="container">
    <h1>Bienvenido, <?php echo htmlspecialchars($afiliado['nombre'] . ' ' . $afiliado['apellido']); ?></h1>

    <!-- Información del Plan -->
    <h2>Mi Plan</h2>
    <ul class="list-group">
        <li class="list-group-item">Plan de Cobertura: <?php echo htmlspecialchars($afiliado['nombre_plan']); ?></li>
        <li class="list-group-item">Costo Mensual: $<?php echo htmlspecialchars($afiliado['costo']); ?></li>
    </ul>

    <!-- Beneficios del Plan -->
    <h2 class="mt-4">Beneficios del Plan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Descripción</th>
                <th>Descuento (%)</th>
                <th>Cantidad Gratuita</th>
                <th>Acción</th> <!-- Nueva columna para el botón de acción -->
            </tr>
        </thead>
        <tbody>
            <?php while ($beneficio = $beneficios->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($beneficio['nombre_servicio']); ?></td>
                    <td><?php echo htmlspecialchars($beneficio['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($beneficio['descuento']); ?>%</td>
                    <td>
                        <?php echo $beneficio['cantidad_gratuita'] !== null ? htmlspecialchars($beneficio['cantidad_gratuita']) : 'Ilimitado'; ?>
                    </td>
                    <td>
                        <!-- Formulario para registrar el uso del servicio -->
                        <form method="POST" action="3afiliado_dashboard.php">
                            <input type="hidden" name="id_servicio" value="<?php echo $beneficio['id_servicio']; ?>">
                            <button type="submit" class="btn btn-secondary">Usar Servicio</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Facturas -->
    <h2 class="mt-4">Mis Facturas</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha Emisión</th>
                <th>Fecha Vencimiento</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while($factura = $facturas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($factura['fecha_emision']); ?></td>
                    <td><?php echo htmlspecialchars($factura['fecha_vencimiento']); ?></td>
                    <td>$<?php echo htmlspecialchars($factura['monto']); ?></td>
                    <td><?php echo htmlspecialchars($factura['estado']); ?></td>
                    <td>
                        <?php if($factura['estado'] === 'pendiente'): ?>
                            <!-- Formulario de Pago -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_factura" value="<?php echo $factura['id_factura']; ?>">
                                <button type="submit" class="btn btn-success btn-sm">Pagar</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">Pagada</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="1logout.php" class="btn btn-danger">Cerrar Sesión</a>
</div>

</body>
</html>

