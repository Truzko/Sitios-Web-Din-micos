<?php
session_start();
require '0conexion.php';


// Implementar lógica para listar, editar y eliminar afiliados

// Ejemplo de listado de afiliados
$stmt = $conn->prepare("SELECT a.id_afiliado, a.nombre, a.apellido, u.usuario FROM afiliados a JOIN usuarios u ON a.id_usuario = u.id_usuario");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Administración de Afiliados</title>
</head>
<body>
<div class="container">
    <h2>Administración de Afiliados</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_afiliado']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td>
                        <a href="2editarAfiliado.php?id=<?php echo $row['id_afiliado']; ?>" class="btn btn-warning">Editar</a>
                        <a href="2eliminarAfiliado.php?id=<?php echo $row['id_afiliado']; ?>" class="btn btn-danger">Eliminar</a>
                        <a href="verFacturas.php?id_afiliado=<?php echo $row['id_afiliado']; ?>" class="btn btn-info">Ver Facturas</a>
                        <a href="verHistorial.php?id_afiliado=<?php echo $row['id_afiliado']; ?>" class="btn btn-secondary">Ver Historial</a> <!-- Nuevo botón -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="1registro.php" class="btn btn-primary">Agregar Nuevo Afiliado</a>
    <a href="4reportes.php" class="btn btn-primary">Ver Reportes</a>
    <a href="2agregarAdmin.php" class="btn btn-primary">Añadir nuevo admin</a>
</div>
</body>
</html>
