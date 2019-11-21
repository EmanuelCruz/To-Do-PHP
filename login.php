<?php 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<form method="POST" class="px-4 py-3">
		<div class="form-group row">
            <label for="inputUsuario" class="col-sm-2 col-form-label">Usuario:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="inputUsuario" placeholder="Usuario" name="usuario" required>
            </div>
        </div>

		<div class="form-group row">
            <label for="inputContrasenia" class="col-sm-2 col-form-label">Contrasenia:</label>
            <div class="col-sm-3">
              <input type="password" class="form-control" id="inputContrasenia" placeholder="Contrasenia" name="contrasenia" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ingresar</button>
        
        <div class="dropdown-divider"></div>

		<a href="registrarUsuario.php">Crear una cuenta</a>
	</form>

</body>
</html>


<?php 
	if (!empty($_POST))
	{
		
		$error = "";
	
		if (empty($_POST['usuario'] == true)) {
			$error = "Ingresaste un nombre de usuario vacio<br/>";
		}
		
		if (isset($_POST['usuario']) == false)
		{
			$error = "No ingresaste nombre de usuario<br/>";
		}

		if (empty($_POST['contrasenia'] == true)) {
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
		//cargo variables y verifico que no sean espacios vacios

	    $usuario = trim($_POST['usuario']);
	    $contrasenia = trim($_POST['contrasenia']);

	    $lenUsuario = strlen($usuario);
	    $lenContrasenia = strlen($contrasenia);

	    if($lenUsuario == 0 || $lenContrasenia == 0)
	    {
	        header("Location: login.php");	
	    }
		
		$usuario = $_POST['usuario'];
		$contrasenia = $_POST['contrasenia'];

		$conexion = mysqli_connect("localhost:3306","root","","todo");

		$consultaSql = "SELECT *
						FROM usuarios 
						WHERE usuario_nombre = '$usuario'";	

		
		$respuesta = mysqli_query($conexion,$consultaSql);

		$registro = mysqli_fetch_array($respuesta);

		if ($registro == null) 
		{
			header("Location: login.php");
			die();
		}

		$coincide = password_verify($contrasenia, $registro['usuario_contrasenia']);

		if ($coincide == false)
			header("Location: login.php");

		else
		{
			$_SESSION['usuario'] = $usuario;
			header("Location: menuUsuario.php");
			
		}
	}
?>


