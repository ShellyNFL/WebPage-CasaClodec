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
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



