<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Conecta a la base de datos
require "../Soporte/Conexion.php";
require_once 'carrito.php'; // Incluimos el archivo carrito.php
$objConexion = Conectarse();

if (isset($_POST['agregar_al_carrito'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $id_curso = $_POST['ID'];
    agregarCursoAlCarrito($id_usuario, $id_curso);
    header('Location: carrito.php');
    exit;
}

$id_video = $_POST['id_video'];
$id_carrito = $_POST['id_carrito'];

if (isset($id_video) && isset($id_carrito)) {
    agregarCursoAlCarrito($id_video, $id_carrito);
} else {
    echo "Error: Las variables $id_video y $id_carrito no están definidas.";
}

function agregarCursoAlCarrito($id_usuario, $id_curso) {
  $objConexion = Conectarse();
    $sql = "SELECT id_carrito FROM carrito WHERE id_usuario = ?";
  $stmt = $objConexion->prepare($sql);
  $stmt->bind_param("i", $id_usuario);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $id_carrito = $resultado->fetch_assoc()['id_carrito'];
  // Verificar si el curso ya está en el carrito
  $id_curso_int = intval($id_curso);
  $sql = "SELECT * FROM carrito_productos WHERE id_carrito = ? AND ID = ?";
  $stmt = $objConexion->prepare($sql);
  $stmt->bind_param("ii", $id_carrito, $id_curso_int);
  $stmt->execute();
  $resultado = $stmt->get_result();
  if ($resultado->num_rows == 0) {
    // Insertar el curso en el carrito
    $sql = "INSERT INTO carrito_productos (id_carrito, ID, cantidad) VALUES (?, ?, 1)";
    $stmt = $objConexion->prepare($sql);
    $stmt->bind_param("ii", $id_carrito, $id_curso_int);
    $stmt->execute();
  }
}

?>

<form action="comprarcurso.php" method="post">
    <input type="hidden" name="ID" value="<?php echo $id_curso; ?>">
    <button type="submit" name="agregar_al_carrito">Agregar al carrito</button>
</form>