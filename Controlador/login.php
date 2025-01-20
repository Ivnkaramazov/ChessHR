<?php  //abrimos php
require "../Soporte/Conexion.php";
$objConexion = Conectarse();
$sql3= "select  * from usuarios";
$resultado3 = $objConexion->query($sql3);
?> 

<?php
extract($_REQUEST);
if (!isset($_REQUEST['x']))
	$x=0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../Css/EstiloLogin.css">
<title>ChessHr</title>
</head>

<body>
<div id="divEncabezado"> <?php include '../Soporte/cabecera.php'?></div>
<div class="FormLogin">
<p class="Text">Iniciar Sesión</p>
<form id="form1" class="ClaseLogin" method="post" action="validarInicioSesion.php">
<input name="login" type="text" placeholder="Usuario" required/></p>
<input name="password" type="password" placeholder="Contraseña" required/>
<tr>
    <p class="Text">Usuario</p>
    <td><label for="TipoRol"></label>
    <select name="TipoRol" id="TipoRol">          
        <?php 
		    if ($Producto->ProEstado=="Disponible"){		  
		     ?>
                <option value="01" selected="selected">Administrador</option>
                <option value="02">Estudiante</option>
             <?php
                 }
		    else
		         {
             ?>
          		<option value="01">Administrador</option>
                <option value="02" selected="selected">Estudiante</option>
            <?php
		         }
            ?>       
      </select></td>
</tr>
<input name="btnLogin" Type="submit" value="Iniciar sesion">
<button><a href="../index.php">Regresar</a></button>
<div class="recuperar"><a href='../Soporte/frmRecuperar.php'>¿Has olvidado tu contraseña?</a></div>
<div class="registrarse"> <a href='../Soporte/frmRegistrarse.php'>Registrarse<a></div>
</form>
<div class="carrito">
<button><a href="registro_compra_curso.php">Acceder al curso</a></button>

<?php
if ($x==1)
	echo "<p align='center'> Usuario no registrado con los datos ingresados.<p align='center'> Por favor vuelva a intentarlo<br><br>";
if ($x==2)
	echo "<p align='center'> Por favor inicie sesión.<p align='center'><br>";
if ($x==3)
	echo "<p align='center'>¡Genial! Hoy avanzaste mucho.<p align='center'><br>";
if ($x==4)
	echo "<p align='center'>¡Buena!<p align='center'<br><br>";
if ($x==5)
    echo "<p align='center'>Error. Vuelva a intentarlo<p align='center'<br>";
if ($x==6)
	echo "<p align='center'> Bienvenido/a.<p align='center'><br>";
if ($x==7)
    echo "<p align='center'>La contraseña ha sido enviada<p align='center'<br>";
if ($x==8)
    echo "<p align='center'> Este Email y/o nombre de usuario<br><p align='center'> ya se encuentran registrados.<br><br>";
?>
</div>

</body>
</html>