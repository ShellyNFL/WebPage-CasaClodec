<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Casa Clodec</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
  <!-- NavBar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
        <a class="navbar-brand active" href="index.html">Casa Clodec</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#aretes">Pendientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#anillos">Anillos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#dijes">Dijes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#juegos">Juegos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#pulseras">Pulseras</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#collares">Cadenas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php"><i class="bi bi-person"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#cart"><i class="bi bi-cart"></i></a>
            </li>
            </ul>
        </div>
        </div>
    </nav>

  <!-- Formulario de Registro -->
  <div class="container pt-5 mt-5 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
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

  <?php
    include("php/conexion.php");
    //sustituye los caracteres especiales en ASCII 
    $nombre= mysqli_real_escape_String($conexion, $_POST['nombre']);
    $fechaNacimiento = mysqli_real_escape_String($conexion, $_POST['fechaNacimiento']);
    $numeroTarjeta = mysqli_real_escape_String($conexion, $_POST['numeroTarjeta']);
    $direccion = mysqli_real_escape_String($conexion, $_POST['direccion']);
    $email = mysqli_real_escape_String($conexion, $_POST['email']);
    $password = mysqli_real_escape_String($conexion, $_POST['password']);
    $password2 = mysqli_real_escape_String($conexion, $_POST['password2']);
    $mensaje = '';
    $tipoMensaje = '';
    if ($password != $password2) 
        $errorMessage = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    if (!empty($errorMessage)) { //si hay msj de error
        echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
        exit();
    }
    $query = "INSERT INTO usuarios(nombre, email, password, fechaNacimiento,numeroTarjeta,direccion) 
    VALUES ('$nombre','$email','$password','$fechaNacimiento','$numeroTarjeta','$direccion');";
    if (mysqli_query($conexion, $query)) {
      $mensaje = "¡Usuario registrado con éxito!";
      $tipoMensaje = "success";
    } else {
      $mensaje = "Error al registrar usuario: " . mysqli_error($conexion);
      $tipoMensaje = "danger";
    }
    if (!empty($mensaje)) {
      echo '<div class="alert alert-' . $tipoMensaje . ' alert-dismissible fade show" role="alert">
              ' . $mensaje . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
