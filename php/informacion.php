<?php
session_start();
include("conexion.php");
$mensaje = '';
$tipoMensaje = '';
//ver si esta logeado algún usuario
if (empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

//obtener la info del usuario logeado
$id_usuario = $_SESSION['usuario_id'];
$sql = "SELECT nombre, email, fechaNacimiento, numeroTarjeta, direccion FROM usuarios WHERE IDusuario = ?";
$stmt = $conexion->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verifica si hay datos
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit();
    }

    $stmt->close();
} else {
    echo "Error en la consulta: " . $conexion->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Usuario</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>
    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Bienvenido <?php 
                            $primer_nombre = explode(" ", trim($_SESSION['usuario_nombre']))[0];
                            echo htmlspecialchars($primer_nombre); 
                            ?></h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detalles de tu cuenta</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></li>
                    <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($usuario['fechaNacimiento']); ?></li>
                    <li class="list-group-item"><strong>Número de Tarjeta:</strong> <?php echo htmlspecialchars($usuario['numeroTarjeta']); ?></li>
                    <li class="list-group-item"><strong>Dirección registrada:</strong> <?php echo htmlspecialchars($usuario['direccion']); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <!--Botón para ir a la página principal -->
        <a href="editarInformacion.php" class="btn btn-success btn-md">Editar información</a>
        <a href="../index.php" class="btn btn-success btn-md">Inicio</a>  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

