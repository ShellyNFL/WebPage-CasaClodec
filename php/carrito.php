<?php
session_start();
include("itemsCarritoCompras.php");

// Calcular la cantidad del carrito
$cantidadCarrito = obtenerCantidadCarrito();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<div class='container mt-5 text-center'><div class='alert alert-warning'>El carrito está vacío.</div></div>";
    exit;
}

// Eliminar producto del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto'])) {
    $id_producto = $_POST['id_producto'];
    unset($_SESSION['carrito'][$id_producto]);
    header("Location: carrito.php");
    exit;
}

// Aumentar o disminuir cantidad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['aumentar_cantidad']) || isset($_POST['disminuir_cantidad']))) {
    $id_producto = $_POST['id_producto'];

    // Simular el inventario desde la base de datos
    $inventario = obtenerInventarioProducto($id_producto); // Crear esta función para consultar inventario real.

    if (isset($_POST['aumentar_cantidad'])) {
        if ($_SESSION['carrito'][$id_producto]['cantidad'] < $inventario) {
            $_SESSION['carrito'][$id_producto]['cantidad']++;
        } else {
            echo "<script>alert('No hay suficiente inventario para agregar más unidades de este producto.');</script>";
        }
    }

    if (isset($_POST['disminuir_cantidad'])) {
        if ($_SESSION['carrito'][$id_producto]['cantidad'] > 1) {
            $_SESSION['carrito'][$id_producto]['cantidad']--;
        }
    }

    header("Location: carrito.php");
    exit;
}

// Variable para el total a pagar
$total_compra = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!--Carrito de compras -->
    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Carrito de Compras</h1>
        <?php if (empty($_SESSION['carrito']) || count($_SESSION['carrito']) === 0): ?>
            <div class="alert alert-warning text-center" role="alert">
                <h4 class="alert-heading">¡Tu carrito está vacío!</h4>
                <p>Parece que aún no has agregado productos a tu carrito. Navega por nuestro catálogo y encuentra lo que necesitas.</p>
                <hr>
                <a href="../index.php" class="btn btn-primary btn-md">
                    <i class="bi bi-arrow-left-circle"></i> Ir al Catálogo
                </a>
            </div>
        <?php else: ?>
            <!-- Tabla de productos en el carrito -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Precio Unitario</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_compra = 0;
                        foreach ($_SESSION['carrito'] as $id_producto => $producto): 
                            $subtotal = $producto['precio'] * $producto['cantidad'];
                            $total_compra += $subtotal;
                        ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td>$<?php echo number_format($producto['precio'], 2); ?> MXN</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <form method="POST" class="me-2">
                                            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                            <button type="submit" name="disminuir_cantidad" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-dash-circle"></i>
                                            </button>
                                        </form>
                                        <?php echo $producto['cantidad']; ?>
                                        <form method="POST" class="ms-2">
                                            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                            <button type="submit" name="aumentar_cantidad" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-plus-circle"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-primary fw-bold">$<?php echo number_format($subtotal, 2); ?> MXN</td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                        <button type="submit" name="eliminar_producto" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Total de la compra y acciones -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <h4>Total de la Compra:</h4>
                    <h3 class="text-success">$<?php echo number_format($total_compra, 2); ?> MXN</h3>
                </div>
                <div class="col-md-6 text-end">
                    <a href="../index.php" class="btn btn-outline-primary btn-md me-2">
                        <i class="bi bi-arrow-left-circle"></i> Seguir Comprando
                    </a>
                    <a href="checkout.php" class="btn btn-success btn-md">
                        <i class="bi bi-cart-check"></i> Finalizar Compra
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


