<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../Soporte/Conexion.php';

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$contraseña = $_POST['contraseña'];
$curso = $_POST['curso'];
$metodo_pago = $_POST['metodo_pago'];

// Conectar a la base de datos
$conn = Conectarse();

// Preparar consulta para insertar datos
$stmt = $conn->prepare("INSERT INTO usuarios (usuLogin, usuEmail, usuPassword, RolId_log, curso, metodo_pago) VALUES (?, ?, ?, 2, ?, ?)");
$stmt->bind_param("sssss", $nombre, $email, $contraseña, $curso, $metodo_pago);

// Ejecutar consulta
$stmt->execute();

// Cerrar conexión
$stmt->close();
$conn->close();

// Inicializar sesión y enviar datos del formulario
session_start();
$_SESSION['email'] = $email;
$_SESSION['nombre'] = $nombre;

// Redirigir a página de confirmación
header("Location: confirmacion_registro.php");
exit;
?>