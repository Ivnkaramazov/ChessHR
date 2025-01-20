<?php
require_once '../Soporte/Conexion.php';
require_once 'carrito.php';

// Obtenemos el ID del usuario que está realizando el pago
$id_usuario = $_SESSION['id_usuario'];

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

// Mostramos el resumen del pedido
?>
<h1>Resumen del pedido</h1>
<table>
  <tr>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Precio</th>
    <th>Total</th>
  </tr>
  <?php while ($fila = $resultado->fetch_assoc()) { ?>
  <tr>
    <td><?php echo $fila['Nombre']; ?></td>
    <td><?php echo $fila['cantidad']; ?></td>
    <td><?php echo $fila['precio']; ?></td>
    <td><?php echo $fila['cantidad'] * $fila['precio']; ?></td>
  </tr>
  <?php } ?>
</table>

<!-- Formulario de pago -->
<form action="procesar_pago.php" method="post">
  <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
  <button type="submit">Realizar pago</button>
</form>

