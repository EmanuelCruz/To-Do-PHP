<?php
	include'validarSesion.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<body>
	<form method="POST" class="px-4 py-3">
		<div class="form-group row">
        	<label for="inputTarea" class="col-sm-2 col-form-label">Contrasenia nueva:</label>
        	<div class="col-sm-3">
          		<input type="password" class="form-control" placeholder="Contrasenia" name="contrasenia" required>
        	</div>
        	<button class="btn btn-primary" type="submit">Confirmar</button>
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
	if(empty($_POST)==false)
	{	
		$error = "";
			
		if (empty($_POST['contrasenia'] == true))
		{
			$error = "Ingresaste una contrasenia vacia<br/>";
		}
		
		if (isset($_POST['contrasenia']) == false)
		{
			$error = "No ingresaste contrasenia<br/>";
		}

		if(empty($error) == false) 
		{
			echo $error;
			die();
		}

		//valido que la tara no este vacia
		//El trim hace que se borren los espacios del principio y del final
		$contraseniaSinEspacios = trim($_POST['contrasenia']);

		if(empty($contraseniaSinEspacios) == true)
		{
			echo "No puede ingresar espacios en blanco en la contrasenia<br/>";
			die();
		}

		$contraseniaEncriptada =password_hash("$contraseniaSinEspacios", PASSWORD_BCRYPT);

		$conexion = mysqli_connect("localhost:3306","root","","todo");

		$usuario = $_SESSION['usuario'];

		$consultaSql = "UPDATE usuarios
						SET usuario_contrasenia = '$contraseniaEncriptada' 
						WHERE usuario_nombre ='$usuario'";

		$respuesta = mysqli_query($conexion,$consultaSql);

		if ($respuesta == false)
		{
			die("No se pudo cambiar la contrasenia");
		}
		echo "<p>Contrasenia actualizada!!</p>";

	}

?>
vhgv ghvghkvjkvghjvghj