<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de Sesión - Casa Clodec</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
  <!-- AppBar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="inicio.php">Casa Clodec</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#anillos">Anillos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#collares">Collares</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#pulseras">Pulseras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#aretes">Aretes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#login"><i class="bi bi-person"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#cart"><i class="bi bi-cart"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Inicio de Sesión -->
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
      <h1 class="text-center mb-4">Iniciar Sesión</h1>
      <form>
        <!-- Campo de correo electrónico -->
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" placeholder="Ingresa tu correo" required>
        </div>
        <!-- Campo de contraseña -->
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password" placeholder="Ingresa tu contraseña" required>
        </div>
        <!-- Botón de inicio de sesión -->
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </div>
        <!-- Enlace de registro -->
        <div class="text-center mt-3">
          <p>¿No tienes cuenta? <a href="#registro">Regístrate aquí</a></p>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

