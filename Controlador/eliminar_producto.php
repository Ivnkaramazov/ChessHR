<?php
require_once '../Soporte/Conexion.php';
require_once 'carrito.php';

// Obtenemos el ID del producto que se quiere eliminar
$id_carrito_producto = $_GET['id_carrito_producto'];

// Eliminamos el producto del carrito
eliminarProductoDelCarrito($id_carrito_producto);

// Redireccionamos al usuario a la página del carrito
header('Location: carrito.php');
exit;
?>