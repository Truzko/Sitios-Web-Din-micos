<?php
session_start();
require '0conexion.php';

// Verificar que el usuario sea administrador
// if ($_SESSION['rol'] !== 'administrador') {
//     header("Location: login.php");
//     exit();
// }

// Consulta para el gráfico de afiliados
$queryAfiliados = "SELECT estado_cuenta, COUNT(*) as total FROM afiliados GROUP BY estado_cuenta";
$resultAfiliados = $conn->query($queryAfiliados);

$estados = [];
$totalesEstados = [];
if ($resultAfiliados->num_rows > 0) {
    while ($row = $resultAfiliados->fetch_assoc()) {
        $estados[] = $row['estado_cuenta'];
        $totalesEstados[] = $row['total'];
    }
}

// Consulta para el gráfico del plan más popular
$queryPlanes = "SELECT p.nombre_plan, COUNT(a.id_afiliado) as total 
                FROM afiliados a
                JOIN planes p ON a.plan_cobertura_id = p.id_plan
                GROUP BY p.id_plan
                ORDER BY total DESC";
$resultPlanes = $conn->query($queryPlanes);

$planes = [];
$totalesPlanes = [];
if ($resultPlanes->num_rows > 0) {
    while ($row = $resultPlanes->fetch_assoc()) {
        $planes[] = $row['nombre_plan'];
        $totalesPlanes[] = $row['total'];
    }
}

// Consulta para el historial de facturación
$queryFacturas = "SELECT f.id_factura, f.fecha_emision, f.fecha_vencimiento, f.monto, f.estado, a.nombre AS afiliado
                  FROM facturas f
                  JOIN afiliados a ON f.id_afiliado = a.id_afiliado
                  ORDER BY f.fecha_emision DESC
                  LIMIT 10";
$resultFacturas = $conn->query($queryFacturas);

$facturas = [];
if ($resultFacturas->num_rows > 0) {
    while ($row = $resultFacturas->fetch_assoc()) {
        $facturas[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Reportes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .charts-row {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .chart-container {
            flex: 1 1 250px;
            max-width: 250px;
            background-color: #fafafa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Gráficos de Reportes</h2>
    
    <div class="charts-row">
        <!-- Gráfico de Estados de Afiliados -->
        <div class="chart-container">
            <h3>Estados de Afiliados</h3>
            <canvas id="estadosChart"></canvas>
        </div>
        
        <!-- Gráfico de Plan Más Popular -->
        <div class="chart-container">
            <h3>Plan Más Popular</h3>
            <canvas id="planesChart"></canvas>
        </div>
    </div>

    <!-- Historial de Facturación -->
    <h2>Historial de Facturación</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID Factura</th>
                <th>Fecha de Emisión</th>
                <th>Afiliado</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($facturas as $factura): ?>
                <tr>
                    <td><?php echo $factura['id_factura']; ?></td>
                    <td><?php echo $factura['fecha_emision']; ?></td>
                    <td><?php echo $factura['afiliado']; ?></td>
                    <td><?php echo $factura['monto']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        // Gráfico de Estados de Afiliados
        const estados = <?php echo json_encode($estados); ?>;
        const totalesEstados = <?php echo json_encode($totalesEstados); ?>;
        const estadosChartCtx = document.getElementById('estadosChart').getContext('2d');
        new Chart(estadosChartCtx, {
            type: 'pie',
            data: {
                labels: estados,
                datasets: [{
                    data: totalesEstados,
                    backgroundColor: ['#4CAF50', '#FF5722', '#FFC107'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Distribución de Afiliados por Estado de Cuenta' }
                }
            }
        });

        // Gráfico de Plan Más Popular
        const planes = <?php echo json_encode($planes); ?>;
        const totalesPlanes = <?php echo json_encode($totalesPlanes); ?>;
        const planesChartCtx = document.getElementById('planesChart').getContext('2d');
        new Chart(planesChartCtx, {
            type: 'bar',
            data: {
                labels: planes,
                datasets: [{
                    label: 'Afiliados',
                    data: totalesPlanes,
                    backgroundColor: '#2196F3',
                    borderColor: '#1976D2',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de Afiliados'
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Plan Más Popular' }
                }
            }
        });
    </script>
</div>
</body>
</html>
