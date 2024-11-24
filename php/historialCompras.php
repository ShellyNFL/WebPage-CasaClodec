<?php
session_start();
include("conexion.php");

// Verificar si el usuario es administrador
if (empty($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Variables de ordenamiento y búsqueda
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'c.fecha DESC'; // Por defecto: recientes
$busqueda_usuario = isset($_GET['busqueda_usuario']) ? trim($_GET['busqueda_usuario']) : null;

// Consulta para obtener todos los usuarios
$sql_usuarios = "SELECT IDusuario, nombre FROM usuarios";
$usuarios_resultado = $conexion->query($sql_usuarios);

// Consulta principal para las compras
$sql_compras = "SELECT 
    c.IDcompras,
    c.fecha,
    c.totalCompra,
    u.nombre AS usuario,
    dc.IDproducto,
    p.nombre AS producto,
    dc.cantidad,
    dc.precio AS precio_unitario
FROM compras c
JOIN usuarios u ON c.IDusuario = u.IDusuario
JOIN detalles_compra dc ON c.IDcompras = dc.IDcompra
JOIN productos p ON dc.IDproducto = p.IDproducto";

// Filtro por usuario
if (!empty($busqueda_usuario)) {
    $sql_compras .= " WHERE u.nombre LIKE ?";
}

// Ordenamiento dinámico
$sql_compras .= " ORDER BY $orden";

$stmt = $conexion->prepare($sql_compras);

if (!empty($busqueda_usuario)) {
    $busqueda_usuario_param = "%$busqueda_usuario%";
    $stmt->bind_param("s", $busqueda_usuario_param);
}

$stmt->execute();
$resultado_compras = $stmt->get_result();

// Agrupar compras por usuario
$compras = [];
while ($compra = $resultado_compras->fetch_assoc()) {
    $compras[$compra['usuario']][] = $compra;
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
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4 pt-5">Historial de Compras</h1>

        <!-- Filtros -->
        <form method="GET" class="mb-4">
            <div class="row g-3 align-items-center">
                <!--Búsqueda por nombre de usuario-->
                <div class="col-md-6">
                    <label for="busqueda_usuario" class="form-label">Buscar por nombre de usuario</label>
                    <input type="text" id="busqueda_usuario" name="busqueda_usuario" class="form-control" placeholder="Escribe un nombre" value="<?php echo htmlspecialchars($busqueda_usuario); ?>">
                </div>
                <!--Lista de usuarios-->
                <div class="col-md-4">
                    <label for="usuario_lista" class="form-label">O seleccionar de la lista</label>
                    <select id="usuario_lista" class="form-select" onchange="document.getElementById('busqueda_usuario').value = this.value;">
                        <option value="">Seleccionar usuario</option>
                        <?php while ($usuario = $usuarios_resultado->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($usuario['nombre']); ?>" <?php echo ($usuario['nombre'] === $busqueda_usuario) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($usuario['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <!--Ordenamientos-->
        <div class="mb-4">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="ordenarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Opciones de Ordenamiento
                </button>
                <ul class="dropdown-menu" aria-labelledby="ordenarDropdown">
                    <li><a class="dropdown-item" href="?orden=c.totalCompra ASC">Menor Cantidad</a></li>
                    <li><a class="dropdown-item" href="?orden=c.totalCompra DESC">Mayor Cantidad</a></li>
                    <li><a class="dropdown-item" href="?orden=c.fecha DESC">Compras Recientes</a></li>
                    <li><a class="dropdown-item" href="?orden=c.fecha ASC">Compras Antiguas</a></li>
                </ul>
            </div>
        </div>

        <!--Tabla de compras-->
        <?php if (!empty($compras)): ?>
            <?php foreach ($compras as $usuario => $lista_compras): ?>
                <h2 class="mt-4">Usuario: <?php echo htmlspecialchars($usuario); ?></h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Compra</th>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>ID Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total Compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_compras as $compra): ?>
                            <tr>
                                <td><?php echo $compra['IDcompras']; ?></td>
                                <td><?php echo $compra['fecha']; ?></td>
                                <td><?php echo htmlspecialchars($compra['producto']); ?></td>
                                <td><?php echo $compra['IDproducto']; ?></td>
                                <td><?php echo $compra['cantidad']; ?></td>
                                <td><?php echo number_format($compra['precio_unitario'], 2); ?> MXN</td>
                                <td><?php echo number_format($compra['totalCompra'], 2); ?> MXN</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">No se encontraron compras.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
