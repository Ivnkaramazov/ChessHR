<?php
if ($resultado)
	header("location: ../Soporte/listarConsultarUsuario.php?x=6");
else
	header("location: ../Soporte/listarConsultarUsuario.php?x=5"); 
	
require "../Soporte/Conexion.php";
require "../Soporte/Usuario.php";
extract ($_REQUEST);

    $objUsuario = new Usuario();

    $objUsuario->crearUsuario($_REQUEST['usuLogin'], $_REQUEST['usuEmail'] , $_REQUEST['usuPassword'], $_REQUEST['RolId_log']);

    $resultado = $objUsuario->agregarUsuario();

?>


