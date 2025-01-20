<?php
if ($resultado)
	header('location:login.php?x=8');  
else
	header('location:login.php?x=6');

require "../Soporte/Conexion.php";
require "../Soporte/Usuario.php";

extract ($_REQUEST);

$objUsuario = new Usuario();

$objUsuario->crearUsuario($_REQUEST['usuLogin'], $_REQUEST['usuEmail'], $_REQUEST['usuPassword'], $_REQUEST['RolId_log']);

$resultado = $objUsuario->registrarUsuario();


	?>


