<?php
  include("conexion.php");
  include("navbar.php");
  $mensaje = '';
  $tipoMensaje = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
      $fechaNacimiento = mysqli_real_escape_string($conexion, $_POST['fechaNacimiento']);
      $numeroTarjeta = mysqli_real_escape_string($conexion, $_POST['numeroTarjeta']);
      $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
      $email = mysqli_real_escape_string($conexion, $_POST['email']);
      $password = mysqli_real_escape_string($conexion, $_POST['password']);
      $password2 = mysqli_real_escape_string($conexion, $_POST['password2']);

      // Verificar que las contraseñas coincidan
      if ($password != $password2) {
          $mensaje = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
          $tipoMensaje = "danger";
      } else {
          // Verificar si el correo ya está registrado
          $query = "SELECT * FROM usuarios WHERE email = '$email';";
          $result = mysqli_query($conexion, $query);

          if (mysqli_num_rows($result) > 0) {
              // El correo ya existe
              $mensaje = "Correo ya registrado. Intenta con uno nuevo.";
              $tipoMensaje = "danger";
          } else {
              // Insertar al nuevo usuario
              $query = "INSERT INTO usuarios(nombre, email, password, fechaNacimiento, numeroTarjeta, direccion)
                        VALUES ('$nombre', '$email', '$password', '$fechaNacimiento', '$numeroTarjeta', '$direccion')";
              
              if (mysqli_query($conexion, $query)) {
                $mensaje = "¡Usuario registrado con éxito! Espera para ser redirigido e iniciar sesión";
                $tipoMensaje = "success";
                //se espera 3 seg para redirigir
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 3000);
                </script>";
              }else {
                $mensaje = "Error al registrar usuario: " . mysqli_error($conexion);
                $tipoMensaje = "danger";
            }   
          }
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
</head>
<body class="bg-light">
  
  <!-- Formulario de Registro -->
  <div class="container pt-5 mt-5 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
      <!-- Mensaje -->
      <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show" role="alert">
          <?php echo $mensaje; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <h1 class="text-center mb-4">Regístrate</h1>
      <form action="registro.php" method="post">
        <!-- Campo de nombre -->
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre completo" required>
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="mb-3">
          <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
          <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
        </div>

        <!-- Número de Tarjeta -->
        <div class="mb-3">
          <label for="numeroTarjeta" class="form-label">Número de Tarjeta</label>
          <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" pattern="\d{16}" placeholder="Ingrese 16 dígitos" required>
        </div>

        <!-- Dirección -->
        <div class="mb-3">
          <label for="direccion" class="form-label">Dirección</label>
          <textarea class="form-control" id="direccion" name="direccion" rows="4" placeholder="Ingrese su dirección" required></textarea>
        </div>

        <!-- Campo de correo -->
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
        </div>

        <!-- Campo de contraseña -->
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña" required>
        </div>

        <!-- Campo de confirmación de contraseña -->
        <div class="mb-3">
          <label for="password2" class="form-label">Confirmar Contraseña</label>
          <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirma tu contraseña" required>
        </div>

        <!-- Botón de registro -->
        <div class="d-grid">
          <button type="submit" class="btn btn-dark btn-md">Registrarse</button>
        </div>
        <!-- Enlace a iniciar sesión -->
        <div class="text-center mt-3">
          <p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión</a></p>
        </div>
      </form>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
