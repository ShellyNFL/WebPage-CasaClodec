<?php
session_start();
include("conexion.php");

//Verificar si el usuario es administrador
if (empty($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

//Código para modificar productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_producto'])) {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $fotoURL = $_POST['fotoURL'];
    $id_categoria = $_POST['id_categoria'];

    $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, cantidadAlmacen = ?, fotoURL = ?, IDcategoria = ? WHERE IDproducto = ?;";
    $stmt = $conexion->prepare($sql);
    //Vincula valores a los placeholders
    $stmt->bind_param("ssdisii", $nombre, $descripcion, $precio, $cantidad, $fotoURL, $id_categoria, $id_producto);
    $stmt->execute();
    $stmt->close();
}

//Configurar filtros y ordenamiento
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'sin_categoria';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'IDproducto ASC';

//Construir la consulta base
$sql = "SELECT p.IDproducto, p.nombre, p.descripcion, p.fotoURL, p.precio, p.cantidadAlmacen, c.nombre AS categoria
        FROM productos p
        LEFT JOIN categorias c ON p.IDcategoria = c.IDcategoria";

//Agregar filtro y ordenamiento dinámico
if ($filtro === 'por_categoria') {
    $sql .= " ORDER BY c.nombre ASC, $orden;";
} else {
    $sql .= " ORDER BY $orden;";
}

$resultado = $conexion->query($sql);

//Consultar categorías para el formulario de edición
$sql_categorias = "SELECT * FROM categorias;";
$categorias_resultado = $conexion->query($sql_categorias);
$categorias = [];
while ($fila = $categorias_resultado->fetch_assoc()) {
    $categorias[$fila['IDcategoria']] = $fila['nombre'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 pt-5">
        <h1>Reporte de Inventario</h1>
        <br>
        <!--Filtros-->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="?filtro=sin_categoria&orden=IDproducto ASC" class="btn btn-outline-primary">Sin Categoría</a>
                <a href="?filtro=por_categoria&orden=IDproducto ASC" class="btn btn-outline-primary">Por Categoría</a>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="ordenarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Opciones de ordenamiento
                </button>
                <ul class="dropdown-menu" aria-labelledby="ordenarDropdown">
                    <li><a class="dropdown-item" href="?filtro=<?php echo $filtro; ?>&orden=cantidadAlmacen ASC">Menor Cantidad</a></li>
                    <li><a class="dropdown-item" href="?filtro=<?php echo $filtro; ?>&orden=cantidadAlmacen DESC">Mayor Cantidad</a></li>
                    <li><a class="dropdown-item" href="?filtro=<?php echo $filtro; ?>&orden=precio ASC">Precio Ascendente</a></li>
                    <li><a class="dropdown-item" href="?filtro=<?php echo $filtro; ?>&orden=precio DESC">Precio Descendente</a></li>
                </ul>
            </div>
        </div>

        <!--Tabla de productos-->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Foto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $producto['IDproducto']; ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($producto['fotoURL']); ?>" alt="Foto del Producto" style="width: 50px; height: 50px;"></td>
                        <td><?php echo number_format($producto['precio'], 2); ?> MXN</td>
                        <td><?php echo $producto['cantidadAlmacen']; ?></td>
                        <td><?php echo htmlspecialchars($producto['categoria'] ?? 'Sin Categoría'); ?></td>
                        <td>
                            <!--Formulario para editar producto-->
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id_producto" value="<?php echo $producto['IDproducto']; ?>">
                                <div class="input-group">
                                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                                    <input type="text" name="descripcion" class="form-control" value="<?php echo htmlspecialchars($producto['descripcion']); ?>" required>
                                    <input type="number" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" step="0.01" required>
                                    <input type="number" name="cantidad" class="form-control" value="<?php echo $producto['cantidadAlmacen']; ?>" required>
                                    <input type="text" name="fotoURL" class="form-control" value="<?php echo htmlspecialchars($producto['fotoURL']); ?>" required>
                                    <select name="id_categoria" class="form-select" required>
                                        <?php foreach ($categorias as $id_categoria => $nombre_categoria): ?>
                                            <option value="<?php echo $id_categoria; ?>" <?php echo $producto['IDcategoria'] == $id_categoria ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($nombre_categoria); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="editar_producto" class="btn btn-warning">Editar</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

