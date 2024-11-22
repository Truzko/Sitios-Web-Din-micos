<?php
session_start();
require '0conexion.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'afiliado') {
    header("Location: 1login.php");
    exit();
}

// Verificar que se haya enviado el ID de la factura
if (isset($_POST['id_factura'])) {
    $id_factura = $_POST['id_factura'];

    // Actualizar el estado de la factura a "pagada"
    $stmt = $conn->prepare("UPDATE facturas SET estado = 'pagada' WHERE id_factura = ? AND estado = 'pendiente'");
    $stmt->bind_param("i", $id_factura);
    if ($stmt->execute()) {
        echo "<p>Pago realizado con éxito.</p>";
    } else {
        echo "<p>Error al realizar el pago.</p>";
    }

    header("Location: 3afiliado_dashboard.php");
    exit();
} else {
    echo "ID de factura no proporcionado.";
}
?>
