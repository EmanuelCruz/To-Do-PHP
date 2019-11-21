<?php 
	include'validarSesion.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ingresar tarea</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<form method="POST" class="px-4 py-3">
		<div class="form-group row">
        	<label for="inputTarea" class="col-sm-1 col-form-label">Tarea:</label>
        	<div class="col-sm-3">
          		<input type="text" class="form-control" id="inputTarea" placeholder="Tarea" name="tarea" required>
        	</div>
        	<button class="btn btn-primary" type="submit">Guardar</button>
    	</div>
	</form>
	<div class="px-4 py-3">
		<div class="form-group row">
			<div class="col-sm-1">
				<input type="button" onclick=" location.href='menuUsuario.php' " value="Volver" name="volver" class="btn btn-secondary"/>
			</div>
			<form action="cerrarSesion.php">
				<button type="submit" class="btn btn-danger">Cerrar Sesion</button>
			</form>
			
		</div>
	</div>

</body>
</html>

<?php
	//Verifico que el post tenga datos
	if(empty($_POST)==false)
	{
		$error = "";
			
		if (empty($_POST['tarea'] == true)) {
			$error = "Ingresaste una tarea vacia<br/>";
		}
		
		if (isset($_POST['tarea']) == false)
		{
			$error = "No ingresaste tarea<br/>";
		}
		
		if (is_numeric($_POST['tarea']) == true) 
		{
			$error = "Ingresaste una tarea con numeros<br/>";	
		}

		if(empty($error) == false) 
		{
			echo $error;
			die();
		}

		//valido que la tara no este vacia
		//El trim hace que se borren los espacios del principio y del final
		$tareaSinEspacios = trim($_POST['tarea']);

		if(empty($tareaSinEspacios) == true)
		{
			echo "No puede ingresar espacios en blanco como tarea<br/>";
			die();
		}

		$tarea = $_POST['tarea'];
		$fecha_creacion = date("y-m-d");

		$conexion = mysqli_connect("localhost:3306","root","","todo");
		//como son tareas nuevas no tienen fecha de realizado
		$consultaSql = "INSERT INTO tareas (tarea_descripcion,tarea_realizada,tarea_fecha_registrada) VALUES ('$tareaSinEspacios',0,'$fecha_creacion')";

		$respuesta = mysqli_query($conexion,$consultaSql);

		if ($respuesta == false) {
			die("No se pudo ingresar el recurso en la base de datos");
		}
		die("Registro ingresado!!");
	}

?>