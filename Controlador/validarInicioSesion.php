<?php
$Conexion=new mysqli("localhost","chesshrc_1996","FnI@nH6{gVi{","chesshrc_chesshr");
session_start();
		
if (!empty($_POST["btnLogin"])){
	if (!empty($_POST["login"])and !empty($_POST["password"])and !empty($_POST["TipoRol"])){
		$usuario=$_POST["login"];
		$password=$_POST["password"];
		$rol=$_POST["TipoRol"];
		$sql=$Conexion->query("select * from usuarios where usuLogin='$usuario' and usuPassword='$password' and RolId_log='$rol' ");		
		
		//se condiciona el acceso segun rol
		if ($rol==02){
			if ($datos=$sql->fetch_object() ){
				$_SESSION["RolId_log"]=$datos->RolId_log;
				$_SESSION["usuLogin"]=$datos->usuLogin;
				$_SESSION["usuPassword"]=$datos->usuPassword;
				header("location:../Soporte/primercurso.php");

			}else{
				header("location: login.php?x=1");  //x=5 quiere decir que se agrego bien
			}
		}
		if ($rol==01) {
			if ($datos=$sql->fetch_object() ){
				$_SESSION["RolId_log"]=$datos->RolId_log;
				$_SESSION["usuLogin"]=$datos->usuLogin;
				$_SESSION["usuPassword"]=$datos->usuPassword;
				header("location:../Soporte/IndexAdmin.php");

			}else{
			header("location: login.php?x=1");  //x=5 quiere decir que se agrego bien
			}	
		}
			
	}
	else {
	}
}
?>




