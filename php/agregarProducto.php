<?php
session_start();
include("conexion.php");

//Verificar si el usuario es administrador
if (empty($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

//Consultar categorías para llenar el select
$sql_categorias = "SELECT * FROM categorias";
$categorias_resultado = $conexion->query($sql_categorias);

//Manejar agregar productos a la db
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_categoria = $_POST['id_categoria'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fotoURL = $_POST['fotoURL'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO productos (IDcategoria, nombre, descripcion, fotoURL, precio, cantidadAlmacen)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isssii", $id_categoria, $nombre, $descripcion, $fotoURL, $precio, $cantidad);

    if ($stmt->execute()) {
        $mensaje = "<div class='alert alert-success'>Producto agregado exitosamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al agregar el producto. Por favor, inténtelo nuevamente.</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Agregar Nuevo Producto</h1>

        <!--Mostrar mensajes de éxito o error-->
        <?php if (!empty($mensaje)): ?>
            <?php echo $mensaje; ?>
        <?php endif; ?>

        <!--Formulario de agregar producto-->
        <form method="POST" class="card shadow p-4">
            <div class="mb-3">
                <label for="id_categoria" class="form-label">Categoría</label>
                <select name="id_categoria" id="id_categoria" class="form-select" required>
                    <option value="" disabled selected>Selecciona una categoría</option>
                    <?php while ($categoria = $categorias_resultado->fetch_assoc()): ?>
                        <option value="<?php echo $categoria['IDcategoria']; ?>">
                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Anillo de Plata" maxlength="50" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Ej: Anillo hecho a mano con los mejores materiales." required></textarea>
            </div>

            <div class="mb-3">
                <label for="fotoURL" class="form-label">URL de su foto</label>
                <input type="url" name="fotoURL" id="fotoURL" class="form-control" placeholder="Ej: ../assets/nombreimg.extension" maxlength="255" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio(MXN)</label>
                <input type="number" name="precio" id="precio" class="form-control" placeholder="Ej: 1500.00" min="1" required>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad en almacén</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Ej: 5" min="1" required>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Agregar producto</button>
                <a href="../index.php" class="btn btn-danger btn-md">Cancelar</a>  
            </div>
            
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
