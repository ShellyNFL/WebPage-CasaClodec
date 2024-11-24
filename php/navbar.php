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

                <?php if (!empty($_SESSION['usuario_id'])): ?>
                    <?php if ($_SESSION['usuario_rol'] === 'admin'): ?>
                        <!--Menú para administradores-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-badge me-2"></i> Hola Administrador
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAdmin">
                                <li><a class="dropdown-item" href="inventario.php">Reporte de inventario</a></li>
                                <li><a class="dropdown-item" href="agregarProducto.php">Agregar productos nuevos</a></li>
                                <li><a class="dropdown-item" href="modificarProducto.php">Modificar productos</a></li>
                                <li><a class="dropdown-item" href="historialCompras.php">Historial de compras</a></li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!--Menú para usuarios registrados -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person me-2"></i> Hola <?php 
                                $primer_nombre = explode(" ", trim($_SESSION['usuario_nombre']))[0];
                                echo htmlspecialchars($primer_nombre); 
                                ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                                <li><a class="dropdown-item" href="php/compras.php">Historial de Compras</a></li>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="php/carrito.php">
                                        Carrito de Compras
                                        <?php if (!empty($_SESSION['carrito'])): ?>
                                            <span class="badge bg-danger ms-2">
                                                <?php echo array_sum($_SESSION['carrito']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="informacion.php">Información de la Cuenta</a></li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <!--Menú para visitantes-->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="login.php">
                            <i class="bi bi-person me-2"></i> Ingresa
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>