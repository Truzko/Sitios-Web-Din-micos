<?php
require '0conexion.php';

if (isset($_GET['id_afiliado'])) {
    $id_afiliado = $_GET['id_afiliado'];
    
    // Obtener las facturas del afiliado
    $stmt = $conn->prepare("SELECT * FROM facturas WHERE id_afiliado = ?");
    $stmt->bind_param("i", $id_afiliado);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el afiliado tiene facturas
    if ($result->num_rows > 0) {
        // Obtener información del afiliado
        $stmt_afiliado = $conn->prepare("SELECT nombre, apellido FROM afiliados WHERE id_afiliado = ?");
        $stmt_afiliado->bind_param("i", $id_afiliado);
        $stmt_afiliado->execute();
        $afiliado_info = $stmt_afiliado->get_result()->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <title>Facturas de <?php echo $afiliado_info['nombre'] . ' ' . $afiliado_info['apellido']; ?></title>
        </head>
        <body>
        <div class="container">
            <h2>Facturas de <?php echo $afiliado_info['nombre'] . ' ' . $afiliado_info['apellido']; ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Factura</th>
                        <th>Fecha Emisión</th>
                        <th>Fecha Vencimiento</th>
                        <th>Monto</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id_factura']; ?></td>
                            <td><?php echo $row['fecha_emision']; ?></td>
                            <td><?php echo $row['fecha_vencimiento']; ?></td>
                            <td>$<?php echo number_format($row['monto'], 2); ?></td>
                            <td><?php echo ucfirst($row['estado']); ?></td>
                            <td>
                                <a href="descargarFactura.php?id_factura=<?php echo $row['id_factura']; ?>" class="btn btn-info">Descargar PDF</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "No hay facturas registradas para este afiliado.";
    }
} else {
    echo "ID de afiliado no especificado.";
}
?>
