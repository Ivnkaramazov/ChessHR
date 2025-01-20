<?php
session_start();
$_SESSION['id_usuario']=1;
// Verifica si la variable $_SESSION['id_usuario'] está definida
require_once '../Soporte/Conexion.php';

function agregarProductoAlCarrito($id_usuario, $id_video) {
    $objConexion = Conectarse();
    $sql = "INSERT INTO carrito_productos (id_carrito, ID, cantidad) VALUES (?, ?, 1)";
    $stmt = $objConexion->prepare($sql);
    $stmt->bind_param("ii", $id_usuario, $id_video);
    $stmt->execute();
}

function eliminarProductoDelCarrito($id_carrito_producto) {
    $objConexion = Conectarse();
    $sql = "DELETE FROM carrito_productos WHERE id_carrito_producto = ?";
    $stmt = $objConexion->prepare($sql);
    $stmt->bind_param("i", $id_carrito_producto);
    $stmt->execute();
}

function actualizarCantidadDeProductoEnCarrito($id_carrito_producto, $cantidad) {
    $objConexion = Conectarse();
    $sql = "UPDATE carrito_productos SET cantidad = ? WHERE id_carrito_producto = ?";
    $stmt = $objConexion->prepare($sql);
    $stmt->bind_param("ii", $cantidad, $id_carrito_producto);
    $stmt->execute();
}
?>

<?php
require_once '../Soporte/Conexion.php';

// Obtenemos el ID del usuario que está viendo el carrito
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

// Mostramos el contenido del carrito
?>
<h1>Carrito de compras</h1>
<table>
  <tr>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Precio</th>
    <th>Total</th>
    <th>Acciones</th>
  </tr>
  <?php while ($fila = $resultado->fetch_assoc()) { ?>
  <tr>
    <td><?php echo $fila['Nombre']; ?></td>
    <td><?php echo $fila['cantidad']; ?></td>
    <td><?php echo $fila['precio']; ?></td>
    <td><?php echo $fila['cantidad'] * $fila['precio']; ?></td>
    <td>
      <a href="eliminar_producto.php?id_carrito_producto=<?php echo $fila['id_carrito_producto']; ?>">Eliminar</a>
    </td>
  </tr>
  <?php } ?>
</table>