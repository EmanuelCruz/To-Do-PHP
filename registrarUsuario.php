<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <form class="px-4 py-3" method="POST">
        <div class="form-group row">
            <label for="inputUsuario" class="col-sm-2 col-form-label">Usuario:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="inputUsuario" placeholder="Usuario" name="usuario" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputNombreCompleto" class="col-sm-2 col-form-label">Nombre Completo:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="inputNombreCompleto" placeholder="Nombre Completo" name="nombreCompleto" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputContrasenia" class="col-sm-2 col-form-label">Contrasenia:</label>
            <div class="col-sm-3">
              <input type="password" class="form-control" id="inputContrasenia" placeholder="Contrasenia" name="contrasenia" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="inputEmail" placeholder="mail@gmail.com" name="email" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>

</body>
</html>

<?php

	if(empty($_POST)==false)
	{

    	$error = "";

        if(isset($_POST['usuario']) == false) 
        {
            $error =" variables nombre no coinciden<br/>";
        }

        if(empty($_POST['usuario']) == true) 
        {
            $error =" me mandaste un nombre vacio<br/>";
        }

        if(isset($_POST['nombreCompleto']) == false) 
        {
            $error = " variables nombre completo no coinciden<br/>";
        }

        if(empty($_POST['nombreCompleto']) == true) 
        {
            $error = " me mandaste un nombre completo vacio<br/>";
        }

        if(isset($_POST['contrasenia']) == false) 
        {
            $error = " variables contrasenia no coinciden<br/>";
        }

        if(empty($_POST['contrasenia']) == true) 
        {
            $error = " me mandaste una contrasenia vacia<br/>";
        }

        if(isset($_POST['email']) == false) 
        {
            $error = " variables email no coinciden<br/>";
        }

        if(empty($_POST['email']) == true) 
        {
            $error = " me mandaste un email vacio<br/>";
        }

        if(empty($error) == false) 
        {
            echo $error;
            die();
        }

    	//cargo variables y verifico que no sean espacios vacios

        $usuario = trim($_POST['usuario']);
        $nombreCompleto = trim($_POST['nombreCompleto']);
        $contrasenia = trim($_POST['contrasenia']);
        $email = trim($_POST['email']);

        $lenUsuario = strlen($usuario);
        $lenNombreCompleto = strlen($nombreCompleto);
        $lenContrasenia = strlen($contrasenia);
        $lenEmail = strlen($email);

        if($lenUsuario == 0 || $lenNombreCompleto == 0 || $lenContrasenia == 0 || $lenEmail	 ==0)
        {
            echo "Los datos no pueden ser espacios en blanco.";
            die();
        }

        $passEncriptado = password_hash("$contrasenia",PASSWORD_BCRYPT);
        $fechaActual = date("Y-m-d");

        $conexion = mysqli_connect("localhost:3306", "root", "", "todo");
        
        $consultaSql1 = "SELECT * FROM usuarios WHERE usuario_nombre = '$usuario'";
        
        $respuestaConsulta1 = mysqli_query($conexion, $consultaSql1);
        
        if($respuestaConsulta1 == false)
        {	
        	echo "No se pudo hacer la consulta en la base de dato";
        }
    	
    	$filas = mysqli_num_rows($respuestaConsulta1);

    	if ($filas==0) 
    	{
	    	//Agrego el nuevo usuario
	    	$consultaSql2 = "INSERT INTO usuarios (usuario_nombre, usuario_contrasenia, usuario_mail, usuario_nombre_completo, usuario_fecha_registro) VALUES ('$usuario','$passEncriptado','$email','$nombreCompleto','$fechaActual')";

	    	$respuestaConsulta2 = mysqli_query($conexion, $consultaSql2);

	    	if($respuestaConsulta2 == false)
	    	{
	        	die("No se pudo ingresar el registro en la base de datos");
	    	}

	    	header("Location: login.php");

    	}
    	else
    	{
    		echo "Ya existe el usuario, ingrese otro distinto";
    	}
	}
?>
