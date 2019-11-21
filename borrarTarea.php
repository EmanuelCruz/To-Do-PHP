<?php 
	include'validarSesion.php';

	if (isset($_GET)==false) 
	{
		echo "La variable get no fue llamada";
		//header("Location: listaTareas.php.php");
	}

	if(empty($_GET)==true)
	{	
		echo "La variable get esta vacia";
		header("Location: procesarListaTareas.php");
	}

	$id = $_GET['id'];
	//datos ingresados en las casillas
	//esto lo necesito para luego enviarlo a la pagina de listaTareas.php
	$nombreTarea = $_GET['tarea'];
	$estado = $_GET['estado'];

	$conexion = mysqli_connect("localhost:3306", "root", "", "todo");
        
    $consultaSql = "DELETE FROM tareas WHERE id = '$id'";
       
    $respuestaConsulta = mysqli_query($conexion, $consultaSql);
        
    if($respuestaConsulta == false)
    {	
    	echo "No se pudo hacer la consulta en la base de dato";
    }
    
	header("Location: listaTareas.php?tarea=$nombreTarea&estado=$estado");
    
?>