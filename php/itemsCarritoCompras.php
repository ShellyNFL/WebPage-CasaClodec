<?php
// Función para obtener la cantidad total de productos en el carrito
function obtenerCantidadCarrito() {
    if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
        return array_sum(array_column($_SESSION['carrito'], 'cantidad'));
    }
    return 0;
}
//función para obtener la cantidad en inventario de un producto
function obtenerInventarioProducto($id_producto) {
    include("conexion.php");
    $query = "SELECT cantidadAlmacen FROM productos WHERE IDproducto = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();//regresa renglón de resultado
    $stmt->close();

    //Retorna la cantidad en inventario, o 0 si no se encuentra el producto
    return $producto ? $producto['cantidadAlmacen'] : 0;
}
?>
