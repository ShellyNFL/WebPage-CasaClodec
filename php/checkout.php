<?php
session_start();
include("conexion.php");

if (empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verificar si hay productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<div class='container mt-5 text-center'><div class='alert alert-warning'>El carrito está vacío. <a href='../index.php'>Volver al inicio</a></div></div>";
    exit();
}

$mensaje = '';
$tipoMensaje = '';
$totalCompra = 0;
$idUsuario = $_SESSION['usuario_id'];

try {
    $conexion->begin_transaction();

    // Calcular el total de la compra
    foreach ($_SESSION['carrito'] as $idProducto => $producto) {
        $totalCompra += $producto['precio'] * $producto['cantidad'];
    }

    // Insertar la compra en la tabla `compras`
    $stmtCompra = $conexion->prepare("INSERT INTO compras (IDusuario, totalCompra) VALUES (?, ?)");
    $stmtCompra->bind_param("id", $idUsuario, $totalCompra);
    $stmtCompra->execute();
    $idCompra = $stmtCompra->insert_id;
    $stmtCompra->close();

    // Registrar cada producto en `detalles_compra` y actualizar la cantidad en almacén
    $stmtDetalle = $conexion->prepare("INSERT INTO detalles_compra (IDcompra, IDproducto, cantidad, precio) VALUES (?, ?, ?, ?)");
    $stmtUpdateStock = $conexion->prepare("UPDATE productos SET cantidadAlmacen = cantidadAlmacen - ? WHERE IDproducto = ?");

    foreach ($_SESSION['carrito'] as $idProducto => $producto) {
        $cantidad = $producto['cantidad'];
        $precio = $producto['precio'];

        // Insertar en `detalles_compra`
        $stmtDetalle->bind_param("iiid", $idCompra, $idProducto, $cantidad, $precio);
        $stmtDetalle->execute();

        // Actualizar `cantidadAlmacen` en la tabla `productos`
        $stmtUpdateStock->bind_param("ii", $cantidad, $idProducto);
        $stmtUpdateStock->execute();
    }

    $stmtDetalle->close();
    $stmtUpdateStock->close();

    // Vaciar el carrito
    unset($_SESSION['carrito']);

    // Confirmar transacción
    $conexion->commit();

    $mensaje = "Se ha cobrado el pago a la tarjeta registrada. ¡CasaClodec agradece su preferencia!";
    $tipoMensaje = "success";
} catch (Exception $e) {
    // Revertir cambios si ocurre un error
    $conexion->rollback();

    $mensaje = "Ocurrió un error al procesar la compra. Intenta nuevamente.";
    $tipoMensaje = "danger";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 pt-5">
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="text-center mt-5">
            <a href="../index.php" class="btn btn-primary">Volver al Inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
