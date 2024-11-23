<?php
include("php/conexion.php");
session_start();
/*echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";*/
// Manejo del carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_carrito'])) {
    $id_producto = $_POST['id_producto'];

    //inicia el carrito si no existe
    if (!isset($_SESSION['carrito']))
        $_SESSION['carrito'] = [];

    //Agrega productos al carrito
    if (isset($_SESSION['carrito'][$id_producto]))
        $_SESSION['carrito'][$id_producto]++;
    else
        $_SESSION['carrito'][$id_producto] = 1;
  }
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Casa Clodec</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
  
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-offset="50" class="scrollspy-example"> <!--agrego el scrollspy-->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand active" href="index.php">Casa Clodec</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#aretes">Pendientes</a></li>
                <li class="nav-item"><a class="nav-link" href="#anillos">Anillos</a></li>
                <li class="nav-item"><a class="nav-link" href="#dijes">Dijes</a></li>
                <li class="nav-item"><a class="nav-link" href="#juegos">Juegos</a></li>
                <li class="nav-item"><a class="nav-link" href="#pulseras">Pulseras</a></li>
                <li class="nav-item"><a class="nav-link" href="#collares">Cadenas</a></li>

                <?php if (!empty($_SESSION['usuario_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person me-2"></i> Hola <?php 
                            $primer_nombre = explode(" ", trim($_SESSION['usuario_nombre']))[0];
                            echo htmlspecialchars($primer_nombre); 
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                            <li><a class="dropdown-item" href="compras.php">Historial de Compras</a></li>
                            <li>
                                <!--Agrego badge a la opción del carrito de compras -->
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="carrito.php">
                                    Carrito de Compras
                                    <?php if (!empty($_SESSION['carrito'])): ?>
                                        <span class="badge bg-danger ms-2">
                                            <?php echo array_sum($_SESSION['carrito']); ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="informacion.php">Información de la Cuenta</a></li>
                            <li><a class="dropdown-item" href="php/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Enlace de inicio de sesión -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="php/login.php">
                            <i class="bi bi-person me-2"></i> Ingresa
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Carousel Container -->
<div class="carousel-container mt-5 pt-3 mx-auto">
  <div id="homecarousel" class="carousel slide" data-bs-ride="carousel">

    <!--Indicadores de hasta abajo-->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#homecarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#homecarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#homecarousel" data-bs-slide-to="2"></button>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/carousel1.jpeg" alt="esclava hombre" class="d-block w-100 carousel-image">
      </div>
      <div class="carousel-item">
        <img src="assets/carousel2.jpeg" alt="Aretes flor" class="d-block w-100 carousel-image">
      </div>
      <div class="carousel-item">
        <img src="assets/carousel3.jpeg" alt="dije flor" class="d-block w-100 carousel-image">
      </div>
    </div>
    <!-- Iconos de flechas de izq y der-->
    <button class="carousel-control-prev" type="button" data-bs-target="#homecarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homecarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<!-- Contenedor del catálogo de productos-->
<div class="container my-5">
    <h1 class="text-center mb-5">Nuestros Productos</h1>
    <?php
    //Obtengo productos junto con el nombre de su categoría
    $query = " SELECT 
            productos.IDproducto, 
            productos.nombre AS producto, 
            productos.descripcion, 
            productos.fotoURL, 
            productos.precio, 
            categorias.nombre AS categoria
        FROM productos
        JOIN categorias ON productos.IDcategoria = categorias.IDcategoria
        ORDER BY categorias.IDcategoria, productos.IDproducto;";
    $result = mysqli_query($conexion, $query);
    $categoria_actual = null;
    while ($producto = mysqli_fetch_assoc($result)): //obtengo el arreglo con los resultados de toda la fila
        //Cuando se cambia la categoría, se inicia una nueva sección
        if ($categoria_actual !== $producto['categoria']):
            if ($categoria_actual !== null) {
                echo '</div>'; //cierro la fila de la categoría anterior
            }
            $categoria_actual = $producto['categoria'];
    ?>
        <!-- Nueva categoría -->
        <section id="<?php echo strtolower($categoria_actual); ?>">
            <h2 class="text-center my-4"><?php echo $categoria_actual; ?></h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php endif; ?>
    <!-- Producto -->
    <div class="col">
        <div class="card h-100 shadow-sm">
            <img src="<?php echo $producto['fotoURL']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['producto']); ?>">
            <div class="card-body text-center">
                <h5 class="card-title"><?php echo htmlspecialchars($producto['producto']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <p class="text-primary fw-bold">$<?php echo number_format($producto['precio'], 2); ?> MXN</p>
                <input type="hidden" name="id_producto" value="<?php echo $producto['IDproducto']; ?>">
                <form method="POST">
                  <input type="hidden" name="id_producto" value="<?php echo $producto['IDproducto']; ?>">
                  <button type="submit" name="agregar_carrito" class="btn btn-primary d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart me-2"></i> Agregar al carrito
                  </button>
                </form>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
            </div> <!-- Cierra la última fila -->
        </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>