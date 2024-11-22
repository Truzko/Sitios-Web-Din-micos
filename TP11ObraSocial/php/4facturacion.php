<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '0conexion.php'; // Asegúrate de tener la conexión a la base de datos aquí
require '../fpdf/fpdf.php'; // Incluye la librería FPDF

if (isset($_GET['id_afiliado'])) {
    $id_afiliado = $_GET['id_afiliado'];
    
    // Obtener los datos del afiliado y su plan
    $stmt = $conn->prepare("SELECT a.nombre, a.apellido, p.nombre_plan, p.costo 
                            FROM afiliados a 
                            JOIN planes p ON a.plan_cobertura_id = p.id_plan 
                            WHERE a.id_afiliado = ?");
    $stmt->bind_param("i", $id_afiliado);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        die("No se encontró el afiliado con el ID especificado.");
    }

    $afiliado = $result->fetch_assoc();
    
    // Generar una factura
    $fecha_emision = date('Y-m-d');
    $fecha_vencimiento = date('Y-m-d', strtotime('+1 month'));
    $monto = $afiliado['costo']; // Aquí puedes añadir cálculos adicionales si hay más servicios

    // Insertar la factura en la base de datos
    $stmt = $conn->prepare("INSERT INTO facturas (id_afiliado, fecha_emision, fecha_vencimiento, monto, estado) 
                            VALUES (?, ?, ?, ?, 'Pendiente')");
    $stmt->bind_param("issd", $id_afiliado, $fecha_emision, $fecha_vencimiento, $monto);
    $stmt->execute();

    // Generar el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Factura - Obra Social');
    
    // Agregar los detalles del afiliado y del plan
    $pdf->Ln(20);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Nombre: " . $afiliado['nombre'] . " " . $afiliado['apellido'], 0, 1);
    $pdf->Cell(0, 10, "Plan: " . $afiliado['nombre_plan'], 0, 1);
    $pdf->Cell(0, 10, "Monto: $" . number_format($monto, 2), 0, 1);
    $pdf->Cell(0, 10, "Fecha de Emision: " . $fecha_emision, 0, 1);
    $pdf->Cell(0, 10, "Fecha de Vencimiento: " . $fecha_vencimiento, 0, 1);
    
    // Guardar el PDF en el servidor
    $pdf_name = "factura_" . $id_afiliado . "_" . date('Ymd') . ".pdf";
    $pdf->Output('F', $pdf_name);

    echo "Factura generada con éxito. Puedes descargarla <a href='$pdf_name'>aquí</a>.";
}
?>
