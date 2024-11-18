<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Casa Clodec</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!--íconos Bootstrap-->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">Casa Clodec</a>
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
            <a class="nav-link" href="#aretes">Pendientes</a>
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

<!-- Carousel Container -->
<div class="carousel-container mx-auto">
  <div id="demo" class="carousel slide" data-bs-ride="carousel">

    <!-- Indicators -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/minero.jpg" alt="Minero" class="d-block w-100 carousel-image">
      </div>
      <div class="carousel-item">
        <img src="assets/carousel1.jpeg" alt="Los Angeles" class="d-block w-100 carousel-image">
      </div>
      <div class="carousel-item">
        <img src="assets/carousel2.jpeg" alt="Chicago" class="d-block w-100 carousel-image">
      </div>
      <div class="carousel-item">
        <img src="assets/carousel3.jpeg" alt="New York" class="d-block w-100 carousel-image">
      </div>
    </div>

    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<!-- Contenedor principal -->
<div class="container my-5">
    <h1 class="text-center mb-5">Nuestros Productos</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      
      <!-- Producto 1 -->
      <div class="col">
        <div class="card h-70 shadow-lg">
          <img src="assets/anillo1.jpg" class="card-img-top" alt="Anillo Elegante">
          <div class="card-body text-center">
            <h5 class="card-title">Anillo Elegante</h5>
            <p class="card-text">Un anillo hecho a mano con los mejores materiales.</p>
            <p class="text-primary fw-bold">$1,500 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>

      <!-- Producto 2 -->
      <div class="col">
        <div class="card h-70 shadow-sm">
          <img src="assets/arete1.jpg" class="card-img-top" alt="Collar de Plata">
          <div class="card-body text-center">
            <h5 class="card-title">Collar de Plata</h5>
            <p class="card-text">Diseño moderno y versátil para cualquier ocasión.</p>
            <p class="text-primary fw-bold">$2,800 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>

      <!-- Producto 3 -->
      <div class="col">
        <div class="card h-70 shadow-sm">
          <img src="assets/cadena1.jpg" class="card-img-top" alt="Pulsera Clásica">
          <div class="card-body text-center">
            <h5 class="card-title">Pulsera Clásica</h5>
            <p class="card-text">El regalo perfecto para momentos inolvidables.</p>
            <p class="text-primary fw-bold">$1,200 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>

      <!-- Producto 4 -->
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="assets/dije1.jpg" class="card-img-top" alt="Pulsera Clásica">
          <div class="card-body text-center">
            <h5 class="card-title">Pulsera Clásica</h5>
            <p class="card-text">El regalo perfecto para momentos inolvidables.</p>
            <p class="text-primary fw-bold">$1,200 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>
      <!-- Producto 5 -->
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="assets/cadena1.jpg" class="card-img-top" alt="Pulsera Clásica">
          <div class="card-body text-center">
            <h5 class="card-title">Pulsera Clásica</h5>
            <p class="card-text">El regalo perfecto para momentos inolvidables.</p>
            <p class="text-primary fw-bold">$1,200 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>
      <!-- Producto 6 -->
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="assets/cadena1.jpg" class="card-img-top" alt="Pulsera Clásica">
          <div class="card-body text-center">
            <h5 class="card-title">Pulsera Clásica</h5>
            <p class="card-text">El regalo perfecto para momentos inolvidables.</p>
            <p class="text-primary fw-bold">$1,200 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>
      <!-- Producto 7 -->
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="assets/anillo2.jpg" class="card-img-top" alt="Pulsera Clásica">
          <div class="card-body text-center">
            <h5 class="card-title">Pulsera Clásica</h5>
            <p class="card-text">El regalo perfecto para momentos inolvidables.</p>
            <p class="text-primary fw-bold">$1,200 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>
      <!-- Producto 6 -->
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="assets/dije2.jpg" class="card-img-top" alt="Pulsera Clásica">
          <div class="card-body text-center">
            <h5 class="card-title">Pulsera Clásica</h5>
            <p class="card-text">El regalo perfecto para momentos inolvidables.</p>
            <p class="text-primary fw-bold">$1,200 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>
      <!-- Producto 6 -->
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="assets/arete2.jpg" class="card-img-top" alt="Pulsera Clásica">
          <div class="card-body text-center">
            <h5 class="card-title">Pulsera Clásica</h5>
            <p class="card-text">El regalo perfecto para momentos inolvidables.</p>
            <p class="text-primary fw-bold">$1,200 MXN</p>
            <a href="#" class="btn btn-primary">Agregar al carrito</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



