<?php
require '0conexion.php'; // Asegúrate de tener una conexión a la base de datos aquí

if (isset($_GET['id'])) {
    $id_afiliado = $_GET['id'];
    
    // Eliminar el afiliado
    $stmt = $conn->prepare("DELETE FROM afiliados WHERE id_afiliado = ?");
    $stmt->bind_param("i", $id_afiliado);
    
    if ($stmt->execute()) {
        header("Location: 2Administracion.php"); // Redirige al listado de afiliados
        exit();
    } else {
        echo "Error al eliminar el afiliado.";
    }
}
?>
