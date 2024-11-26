<?php 
session_start();
include("itemsCarritoCompras.php");

// Calcular la cantidad del carrito
$cantidadCarrito = obtenerCantidadCarrito();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información sobre CasaClodec</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <?php include("navbar.php"); ?>
    <!-- Información -->
    <div class="container mt-5">
        <div class="row align-items-center">
            <!--Imagen -->
            <div class="col-md-5">
                <img src="../assets/minero.jpg" alt="Minero" class="img-fluid rounded shadow">
            </div>
            <!-- Información -->
            <div class="col-md-7 text-center">
                <h1 class="mb-3 pt-5 pl-3 text-center">Bienvenidos a Casa Clodec</h1>
                <h5 class="text-center hide">Proyecta tu imágen</h5>
                <p class="lead">
                    En Casa Clodec nos enorgullecemos de ofrecer joyería única y de alta calidad hecha por artesados 100% mexicanos. 
                    Nuestras piezas están diseñadas para resaltar la belleza y la elegancia de cada cliente. 
                    Con 15 años de experiencia en el sector, ofrecemos un distintivo de calidad en cada pieza y atención.
                </p>
                <h3 class="text-secondary text-center">Información de contacto</h3>
                <ul class="list-unstyled text-center">
                    <li><i class="bi bi-geo-alt-fill text-danger"></i> Dirección: Av. Principal 123, Ciudad de México</li>
                    <li><i class="bi bi-telephone-fill text-success"></i> Teléfono: +52 55 31206005</li>
                    <li><i class="bi bi-envelope-fill text-warning"></i> Email: serviciocliente@casaclodec.com</li>
                    <li><i class="bi bi-clock-fill text-info"></i> Horario: Lunes a Viernes, 7:00 AM - 10:00 PM</li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
