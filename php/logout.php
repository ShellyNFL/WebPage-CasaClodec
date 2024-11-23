<?php
session_start();//se inicia sesión
session_unset();//limpia todas las variables de la sesión
session_destroy();//destruye la sesión
header("Location: ../index.php");//redirigimos al index
exit();
