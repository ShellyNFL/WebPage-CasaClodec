<?php
session_start();
include("conexion.php");
include("itemsCarritoCompras.php");

//Calcular la cantidad del carrito
$cantidadCarrito = obtenerCantidadCarrito();

// Verifica si el usuario está logueado
if (empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtén el ID del usuario logueado
$id_usuario = $_SESSION['usuario_id'];

// Consulta para obtener las compras y sus detalles
$sql = "
    SELECT 
        c.IDcompras, 
        c.fecha, 
        c.totalCompra,
        dc.IDdetalle,
        dc.IDproducto,
        p.nombre AS producto,
        dc.cantidad,
        dc.precio
    FROM compras c
    JOIN detalles_compra dc ON c.IDcompras = dc.IDcompra
    JOIN productos p ON dc.IDproducto = p.IDproducto
    WHERE c.IDusuario = ?
    ORDER BY c.fecha DESC, c.IDcompras, dc.IDdetalle
";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Organiza las compras y detalles en un arreglo
$compras = [];
while ($fila = $resultado->fetch_assoc()) {
    $compras[$fila['IDcompras']]['fecha'] = $fila['fecha'];
    $compras[$fila['IDcompras']]['totalCompra'] = $fila['totalCompra'];
    $compras[$fila['IDcompras']]['detalles'][] = [
        'producto' => $fila['producto'],
        'cantidad' => $fila['cantidad'],
        'precio' => $fila['precio']
    ];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-5 pt-5">Historial de Compras</h1>
        <?php if (empty($compras)): ?>
            <p class="text-muted">No tienes compras registradas.</p>
        <?php else: ?>
            <?php foreach ($compras as $id_compra => $compra): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <!--<strong>Compra #<?php //echo $id_compra; ?></strong>-->
                        <span class="text-muted float-end"><?php echo date("d/m/Y H:i", strtotime($compra['fecha'])); ?></span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total: $<?php echo number_format($compra['totalCompra'], 2); ?></h5>
                        <p class="card-text">Detalles:</p>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($compra['detalles'] as $detalle): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($detalle['producto']); ?>
                                    <span>
                                        <?php echo $detalle['cantidad']; ?> x $<?php echo number_format($detalle['precio'], 2); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="text-center mt-4">
        <a href="../index.php#pendientes" class="btn btn-success btn-md">
            <i class="bi bi-cart"></i> Ir a Comprar
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
