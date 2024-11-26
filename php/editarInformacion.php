<?php
session_start();
include("conexion.php");

// Verificar si el usuario está logueado
if (empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$mensaje = "";
$tipoMensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = trim($_POST['nombre']);
    $nuevo_email = trim($_POST['email']);
    $nueva_fecha = $_POST['fechaNacimiento'];
    $nuevo_numeroTarjeta = trim($_POST['numeroTarjeta']);
    $nueva_direccion = trim($_POST['direccion']);

    // Validar que todos los campos estén llenos
    if (empty($nuevo_nombre) || empty($nuevo_email) || empty($nueva_fecha) || empty($nuevo_numeroTarjeta) || empty($nueva_direccion)) {
        $mensaje = "Todos los campos son obligatorios.";
        $tipoMensaje = "danger";
    } elseif (!filter_var($nuevo_email, FILTER_VALIDATE_EMAIL)) {
        // Validar formato de correo
        $mensaje = "El correo electrónico no es válido.";
        $tipoMensaje = "danger";
    } elseif (!preg_match('/^\d{16}$/', $nuevo_numeroTarjeta)) {
        // Validar número de tarjeta
        $mensaje = "El número de tarjeta debe contener exactamente 16 dígitos.";
        $tipoMensaje = "danger";
    } else {
        // Verificar si el correo ya está registrado en otra cuenta
        $sql_verificar_email = "SELECT IDusuario FROM usuarios WHERE email = ? AND IDusuario != ?";
        $stmt_verificar = $conexion->prepare($sql_verificar_email);
        $stmt_verificar->bind_param("si", $nuevo_email, $id_usuario);
        $stmt_verificar->execute();
        $resultado_verificar = $stmt_verificar->get_result();

        if ($resultado_verificar->num_rows > 0) {
            // El correo ya está registrado
            $mensaje = "Ese correo ya está registrado a una cuenta. Intenta con otro correo.";
            $tipoMensaje = "danger";
        } else {
            // Actualizar la información del usuario
            $sql_actualizar = "UPDATE usuarios SET nombre = ?, email = ?, fechaNacimiento = ?, numeroTarjeta = ?, direccion = ? WHERE IDusuario = ?";
            $stmt_actualizar = $conexion->prepare($sql_actualizar);
            $stmt_actualizar->bind_param("sssssi", $nuevo_nombre, $nuevo_email, $nueva_fecha, $nuevo_numeroTarjeta, $nueva_direccion, $id_usuario);

            if ($stmt_actualizar->execute()) {
                $mensaje = "Información actualizada correctamente.";
                $tipoMensaje = "success";
                // Redirigir después de la actualización
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'informacion.php'; 
                        }, 2000);
                      </script>";
            } else {
                $mensaje = "Error al actualizar los datos. Inténtalo de nuevo.";
                $tipoMensaje = "danger";
            }
        }
    }
}

// Consultar la información del usuario
$sql = "SELECT nombre, email, fechaNacimiento, numeroTarjeta, direccion FROM usuarios WHERE IDusuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Información</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Editar Información</h1>
        <!-- Mostrar mensaje -->
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?php echo htmlspecialchars($tipoMensaje); ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo htmlspecialchars($usuario['fechaNacimiento']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="numeroTarjeta" class="form-label">Número de Tarjeta:</label>
                <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" value="<?php echo htmlspecialchars($usuario['numeroTarjeta']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección registrada:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" required>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="informacion.php" class="btn btn-danger btn-md">Cancelar</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



