<?php
require '0conexion.php';
require '../fpdf/fpdf.php'; // Asegúrate de que la ruta a FPDF es correcta

if (isset($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];

    // Consultar la información de la factura y del afiliado
    $stmt = $conn->prepare("
        SELECT f.fecha_emision, f.fecha_vencimiento, f.monto, f.estado, 
               a.nombre, a.apellido, p.nombre_plan 
        FROM facturas f 
        JOIN afiliados a ON f.id_afiliado = a.id_afiliado 
        JOIN planes p ON a.plan_cobertura_id = p.id_plan 
        WHERE f.id_factura = ?
    ");
    $stmt->bind_param("i", $id_factura);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $factura = $result->fetch_assoc();

        // Asegúrate de crear el objeto PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16); // Usa Arial para evitar problemas de fuente
        $pdf->Cell(0, 10, 'Factura - Obra Social', 0, 1, 'C');

        // Agregar detalles del afiliado y factura
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(10);
        $pdf->Cell(0, 10, "Nombre: " . $factura['nombre'] . " " . $factura['apellido'], 0, 1);
        $pdf->Cell(0, 10, "Plan: " . $factura['nombre_plan'], 0, 1);
        $pdf->Cell(0, 10, "Fecha de Emision: " . $factura['fecha_emision'], 0, 1);
        $pdf->Cell(0, 10, "Fecha de Vencimiento: " . $factura['fecha_vencimiento'], 0, 1);
        $pdf->Cell(0, 10, "Monto: $" . number_format($factura['monto'], 2), 0, 1);
        $pdf->Cell(0, 10, "Estado: " . ucfirst($factura['estado']), 0, 1);

        // Salida del PDF para descarga
        $pdf->Output('D', 'Factura_' . $id_factura . '.pdf');
    } else {
        echo "Factura no encontrada.";
    }
} else {
    echo "ID de factura no especificado.";
}
?>
