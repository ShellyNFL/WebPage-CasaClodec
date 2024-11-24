<?php
session_start();
include("conexion.php");

//Verifico si el usuario está logeado
if (empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

//Se obtiene el ID del usuario logeado
$id_usuario = $_SESSION['usuario_id'];

//Consultar los productos del carrito del usuario
$sql = "SELECT p.nombre, p.precio, c.cantidad, (p.precio * c.cantidad) AS total_producto
        FROM carrito c
        INNER JOIN productos p ON c.id_producto = p.id_producto
        WHERE c.IDusuario = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    //Verificar si hay productos en el carrito
    $productos = [];
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = $fila;
        }
    } else {
        $mensaje = "Tu carrito está vacío.";
    }

    $stmt->close();
} else {
    echo "Error en la consulta: " . $conexion->error;
    exit();
}

//Calcular el total del carrito
$total_carrito = array_reduce($productos, function ($total, $producto) {
    return $total + $producto['total_producto'];
}, 0);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Carrito de Compras</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-warning text-center">
                <?php echo $mensaje; ?>
            </div>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo number_format($producto['precio'], 2); ?> MXN</td>
                            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                            <td><?php echo number_format($producto['total_producto'], 2); ?> MXN</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="mt-4">
                <h4>Total: <?php echo number_format($total_carrito, 2); ?> MXN</h4>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="../index.php" class="btn btn-success">Seguir Comprando</a>
            <a href="checkout.php" class="btn btn-primary">Proceder al Pago</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
