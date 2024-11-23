<?php
  include("conexion.php");
  session_start(); //Iniciar sesión
  $mensaje = '';
  $tipoMensaje = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = mysqli_real_escape_string($conexion, $_POST['email']);
      $password = mysqli_real_escape_string($conexion, $_POST['password']);

      //verifico si el usuario existe
      $query = "SELECT * FROM usuarios WHERE email = '$email'";
      $result = mysqli_query($conexion, $query);

      if (mysqli_num_rows($result) > 0) { //si existe el email
          $usuario = mysqli_fetch_assoc($result); //trae toda el renglón
          if ($password == $usuario['password']) {//si tiene la contraseña correcta
              $_SESSION['usuario_id'] = $usuario['IDusuario'];
              $_SESSION['usuario_nombre'] = $usuario['nombre'];
              $_SESSION['usuario_email'] = $usuario['email'];
              $mensaje = "Bienvenido";
              $tipoMensaje = "success";
                //se espera 3 seg para redirigir
                /*echo "<script>
                    setTimeout(function() {
                        window.location.href = '../index.php';
                    }, 1000);
                </script>";*/
                <div class="spinner-border"></div>
                header("Location: ../index.php");
                exit;

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->

</head>
<body class="bg-light">
  <!-- AppBar -->
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand active" href="../index.php">Casa Clodec</a>
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

                <?php if (isset($_SESSION['usuario_id'])): ?>
                  <!-- Mostrar el nombre del usuario con un dropdown -->
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person me-2"></i> Hola <?php 
                        //Mostrar sólo el primer nombre
                        $primer_nombre = explode(" ", trim($_SESSION['usuario_nombre']))[0];
                        echo htmlspecialchars($primer_nombre); ?>

                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item" href="compras.php">Historial de Compras</a></li>
                          <li><a class="dropdown-item" href="carrito.php">Carrito de Compras</a></li>
                          <li><a class="dropdown-item" href="informacion.php">Información de la Cuenta</a></li>
                      </ul>
                  </li>
                <?php else: ?>
                    <!-- Mostrar el botón de inicio de sesión -->
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

  <!-- Inicio de Sesión -->
  <div class="container pt-5 d-flex justify-content-center align-items-center">
    <div class="card shadow p-5" style="width: 100%; max-width: 500px;">
      <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?php echo $tipoMensaje; ?> alert-dismissible fade show" role="alert">
          <?php echo $mensaje; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <h1 class="text-center mb-4 titulos">Iniciar Sesión</h1>
      <form action="login.php" method="post">
        <!-- Campo de correo electrónico -->
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
        </div>
        <!-- Campo de contraseña -->
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
        </div>
        <!-- Botón de inicio de sesión -->
        <div class="d-grid">
          <button type="submit" class="btn btn-dark btn-md">Iniciar Sesión</button>
        </div>
        <!-- Enlace de registro -->
        <div class="text-center mt-3">
          <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

