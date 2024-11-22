<?php
session_start();
require '0conexion.php';

/* Verificar que el usuario esté logueado y tenga permisos de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: 1login.php");
    exit();
}*/

// Obtener el ID del afiliado desde la URL
$id_afiliado = $_GET['id_afiliado'] ?? null;
if (!$id_afiliado) {
    echo "Afiliado no especificado.";
    exit();
}

// Consultar el historial de servicios utilizados por el afiliado
$stmt = $conn->prepare("
    SELECT h.fecha_uso, s.nombre_servicio, s.descripcion 
    FROM historial_servicios h
    JOIN servicios s ON h.id_servicio = s.id_servicio
    WHERE h.id_afiliado = ?
    ORDER BY h.fecha_uso DESC
");
$stmt->bind_param("i", $id_afiliado);
$stmt->execute();
$historial = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Historial de Servicios</title>
</head>
<body>
<div class="container">
    <h2>Historial de Servicios Usados</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Fecha de Uso</th>
                <th>Servicio</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $historial->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['fecha_uso']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_servicio']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="2Administracion.php" class="btn btn-primary">Volver</a>
</div>
</body>
</html>
