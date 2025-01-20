<?php
// Incluir archivo de conexión a la base de datos
require_once '../Soporte/Conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registro y Compra de Curso</title>
</head>
<body>
  <h1>Registro y Compra de Curso</h1>
  <form action="procesar_registro.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    <label for="contraseña">Contraseña:</label>
    <input type="password" id="contraseña" name="contraseña"><br><br>
    <label for="curso">Curso:</label>
    <select id="curso" name="curso">
      <option value="curso1">Curso 1</option>
      <option value="curso2">Curso 2</option>
      <option value="curso3">Curso 3</option>
    </select><br><br>
    <label for="metodo_pago">Método de pago:</label>
    <select id="metodo_pago" name="metodo_pago">
      <option value="tarjeta_credito">Tarjeta de crédito</option>
      <option value="paypal">PayPal</option>
      <option value="transferencia_bancaria">Transferencia bancaria</option>
    </select><br><br>
    <input type="submit" value="Registrar y comprar curso">
  </form>
</body>
</html>