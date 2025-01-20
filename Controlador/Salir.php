<?php
	session_start();
	session_unset();
	session_destroy();
	/* se envía al formualrio inicio sesión con una variable x=3, que le indica que ha cerrado la sesión */
	header('location:login.php?x=3');
?>