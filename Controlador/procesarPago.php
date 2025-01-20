<?php
require_once '../Soporte/Conexion.php';
require_once 'carrito.php';

// Obtenemos el ID del usuario que está realizando el pago
$id_usuario = $_POST['id_usuario'];

// Obtenemos los productos que están en el carrito del usuario
$objConexion = Conectarse();
$sql = "SELECT cp.id_carrito_producto, v.Nombre, cp.cantidad, v.precio 
        FROM carrito_productos cp 
        INNER JOIN videos v ON cp.ID = v.ID 
        WHERE cp.id_carrito = ?";
$stmt = $objConexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Procesamos el pago
$total = 0;
while ($fila = $resultado->fetch_assoc()) {
  $total += $fila['cantidad'] * $fila['precio'];
}

// Actualizamos el estado del carrito a "pagado"
$sql = "UPDATE carrito SET estado = 'pagado' WHERE id_carrito = ?";
$stmt = $objConexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

// Eliminamos los productos del carrito
$sql = "DELETE FROM carrito_productos WHERE id_carrito = ?";
$stmt = $objConexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

// Redireccionamos al usuario a la página de confirmación de pago
header('Location: confirmacion_pago.php');
exit;
?>
