<?php 
	session_start();
	//verifico que tengo el dato del usuario
	if (isset($_SESSION['usuario'])==false) 
	{
		//lo mando a la pagina de logeo
		header("Location: login.php");
	}
?>