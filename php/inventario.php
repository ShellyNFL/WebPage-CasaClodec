<?php
session_start();
include("conexion.php");

//Verifico si el usuario es administrador
if (empty($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$mensaje = '';
$tipoMensaje = '';

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
    $stmt->bind_param("ssdisii", $nombre, $descripcion, $precio, $cantidad, $fotoURL, $id_categoria, $id_producto);

    if ($stmt->execute()) {
        $mensaje = "Cambios realizados correctamente.";
        $tipoMensaje = "success";
    } else {
        $mensaje = "Error al realizar los cambios. Intenta nuevamente.";
        $tipoMensaje = "danger";
    }
    $stmt->close();
}

//Configurar filtros y ordenamiento
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'sin_categoria';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'IDproducto ASC';

// Construir la consulta base
$sql = "SELECT p.IDproducto, p.nombre, p.descripcion, p.fotoURL, p.precio, p.cantidadAlmacen, p.IDcategoria, c.nombre AS categoria
        FROM productos p
        LEFT JOIN categorias c ON p.IDcategoria = c.IDcategoria";

if ($filtro === 'por_categoria') {
    $sql .= " ORDER BY c.nombre ASC, $orden;";
} else {
    $sql .= " ORDER BY $orden;";
}

$resultado = $conexion->query($sql);

// Consultar categorías para el formulario de edición
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 pt-5">
        <h1>Reporte de Inventario</h1>
        <br>

        <!--Mostrar mensaje -->
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!--Filtros-->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="?filtro=sin_categoria&orden=IDproducto ASC" class="btn btn-outline-primary <?php echo $filtro === 'sin_categoria' ? 'active' : ''; ?>">Por ID del producto</a>
                <a href="?filtro=por_categoria&orden=IDproducto ASC" class="btn btn-outline-primary <?php echo $filtro === 'por_categoria' ? 'active' : ''; ?>">Por Categoría</a>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="ordenarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Opciones de ordenamiento
                </button>
                <ul class="dropdown-menu" aria-labelledby="ordenarDropdown">
                    <li><a class="dropdown-item" href="?filtro=<?php echo $filtro; ?>&orden=cantidadAlmacen ASC">Menor cantidad en almacén</a></li>
                    <li><a class="dropdown-item" href="?filtro=<?php echo $filtro; ?>&orden=cantidadAlmacen DESC">Mayor cantidad en almacén</a></li>
                    <li><a class="dropdown-item" href="?filtro=<?php echo $filtro; ?>&orden=precio ASC">Precio ascendente</a></li>
                    <li><a class="dropdown-item" href="?filtro=<?php echo $filtro; ?>&orden=precio DESC">Precio descendente</a></li>
                </ul>
            </div>
        </div>

        <!--Tabla de productos-->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Ubicación Foto</th>
                        <th class="text-center w-auto">Precio MXN</th>
                        <th class="text-center w-auto">Cantidad</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = $resultado->fetch_assoc()): ?>
                        <tr id="row-<?php echo $producto['IDproducto']; ?>">
                            <td><?php echo $producto['IDproducto']; ?></td>
                            <td><input type="text" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" id="nombre-<?php echo $producto['IDproducto']; ?>" disabled></td>
                            <td><input type="text" class="form-control" value="<?php echo htmlspecialchars($producto['descripcion']); ?>" id="descripcion-<?php echo $producto['IDproducto']; ?>" disabled></td>
                            <td><input type="text" class="form-control" value="<?php echo htmlspecialchars($producto['fotoURL']); ?>" id="fotoURL-<?php echo $producto['IDproducto']; ?>" disabled></td>
                            <td><input type="number" class="form-control" value="<?php echo $producto['precio']; ?>" id="precio-<?php echo $producto['IDproducto']; ?>" disabled></td>
                            <td><input type="number" class="form-control" value="<?php echo $producto['cantidadAlmacen']; ?>" id="cantidad-<?php echo $producto['IDproducto']; ?>" disabled></td>
                            <td>
                                <select class="form-select" id="categoria-<?php echo $producto['IDproducto']; ?>" disabled>
                                    <?php foreach ($categorias as $id_categoria => $nombre_categoria): ?>
                                        <option value="<?php echo $id_categoria; ?>" <?php echo $producto['IDcategoria'] == $id_categoria ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($nombre_categoria); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <div class="text-center">
                                    <button class="btn btn-warning btn-sm" onclick="habilitarEdicion(<?php echo $producto['IDproducto']; ?>)">Editar</button>
                                    <button class="btn btn-success btn-sm d-none" onclick="guardarEdicion(<?php echo $producto['IDproducto']; ?>)">Aceptar</button>
                                    <br>
                                    <button class="btn btn-danger btn-sm d-none" onclick="cancelarEdicion(<?php echo $producto['IDproducto']; ?>)">Cancelar</button>  
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function habilitarEdicion(id) {
            const row = document.getElementById(`row-${id}`);
            row.querySelectorAll('input, select').forEach(el => el.disabled = false);
            row.querySelector('.btn-warning').classList.add('d-none');
            row.querySelector('.btn-success').classList.remove('d-none');
            row.querySelector('.btn-danger').classList.remove('d-none');
        }

        function cancelarEdicion(id) {
            const row = document.getElementById(`row-${id}`);
            row.querySelectorAll('input, select').forEach(el => el.disabled = true);
            row.querySelector('.btn-warning').classList.remove('d-none');
            row.querySelector('.btn-success').classList.add('d-none');
            row.querySelector('.btn-danger').classList.add('d-none');
        }


        function guardarEdicion(id) {
            //Recolectar datos
            const nombre = document.getElementById(`nombre-${id}`).value;
            const descripcion = document.getElementById(`descripcion-${id}`).value;
            const fotoURL = document.getElementById(`fotoURL-${id}`).value;
            const precio = document.getElementById(`precio-${id}`).value;
            const cantidad = document.getElementById(`cantidad-${id}`).value;
            const categoria = document.getElementById(`categoria-${id}`).value;

            //Enviar datos a través de un formulario oculto
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'inventario.php';

            const inputs = [
                {name: 'id_producto', value: id },
                {name: 'nombre', value: nombre },
                {name: 'descripcion', value: descripcion },
                {name: 'fotoURL', value: fotoURL },
                {name: 'precio', value: precio },
                {name: 'cantidad', value: cantidad },
                {name: 'id_categoria', value: categoria },
                {name: 'editar_producto', value: true }
            ];

            inputs.forEach(input => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = input.name;
                hiddenInput.value = input.value;
                form.appendChild(hiddenInput);
            });
            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>











