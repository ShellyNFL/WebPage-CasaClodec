<?php
  session_start(); // Iniciar sesión
  include("conexion.php");
  $mensaje = '';
  $tipoMensaje = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = mysqli_real_escape_string($conexion, $_POST['email']);
      $password = mysqli_real_escape_string($conexion, $_POST['password']);

      // Verifico si el usuario existe
      $query = "SELECT * FROM usuarios WHERE email = '$email'";
      $result = mysqli_query($conexion, $query);

      if (mysqli_num_rows($result) > 0) { //si existe el email
          $usuario = mysqli_fetch_assoc($result); //trae toda el renglón
          if ($password == $usuario['password']) { //si la contraseña es correcta
              $_SESSION['usuario_id'] = $usuario['IDusuario'];
              $_SESSION['usuario_nombre'] = $usuario['nombre'];
              $_SESSION['usuario_email'] = $usuario['email'];
              $_SESSION['usuario_rol'] = $usuario['rol']; //puede ser usuario o admin
              $mensaje = "Bienvenido. Espera un momento, serás direccionado";
              $tipoMensaje = "success";
              //Espera 3 seg para redirigir
              echo "<script>
                    setTimeout(function() {
                        window.location.href = '../index.php';
                    }, 2000);
                </script>";
          } else {
              $mensaje = "La contraseña es incorrecta. Por favor, inténtalo de nuevo.";
              $tipoMensaje = "danger";
          }
      } else {
          $mensaje = "No existe un usuario registrado con ese correo. Lo invitamos a registrarse.";
          $tipoMensaje = "danger";
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Casa Clodec</title>
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
  <!-- Navbar -->
  <?php include 'navbar.php'; ?>
  <!-- Inicio de Sesión -->
  <div class="container pt-5 mt-5 d-flex justify-content-center align-items-center">
    <div class="card shadow p-5" style="width: 100%; max-width: 500px;">
      <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show" role="alert">
          <?php echo $mensaje; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <h1 class="text-center mb-4 titulos">Iniciar Sesión</h1>
      <form action="login.php" method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-dark btn-md">Iniciar Sesión</button>
        </div>
        <div class="text-center mt-3">
          <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


