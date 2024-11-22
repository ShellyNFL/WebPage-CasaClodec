<!--En el documento conexion.php se crea la conexión a la base de datos ingresando los datos necesarios (host, usuario, contraseña, 
nobre de la base de datos que estaremos utilizando)-->
<?php
$host = 'localhost';
$usuario = 'root';
$password = '';
$base_de_datos = 'casaClodec';

$conexion = mysqli_connect($host, $usuario, $password, $base_de_datos);
    if (mysqli_connect_errno()) {
        echo "<p>No se pudo realizar la conexión." . mysqli_connect_errno() . "</p>";
    }
?>
