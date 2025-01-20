<?php
if ($resultado)
	header('location: ../Soporte/editarUsuario.php?x=2');  //x=1 quiere decir que se modifico bien
else
	header('location: ../Soporte/editarUsuario.php?x=1');  //x=2 quiere decir que no se pudo modificar
require "../Soporte/Conexion.php";

extract ($_REQUEST);
$objConexion=Conectarse();

$sql="update usuarios set usuLogin ='$_REQUEST[usuLogin]', usuEmail ='$_REQUEST[usuEmail]' ,usuPassword = '$_REQUEST[usuPassword]', RolId_log = '$_REQUEST[RolId_log]'where usuLogin = '$_REQUEST[usuLogin]' ";

$resultado=$objConexion->query($sql);


?>
