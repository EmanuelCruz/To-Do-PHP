<?php include'validarSesion.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Menu de Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<div>
		<h4 class="px-4 py-3">Funciones</h4>	
		<div class="dropdown-divider"></div>	
		<div class="px-4 py-1">
			<form action="ingresarTarea.php"><button type="submit" class="btn btn-outline-dark">Ingresar Tarea</button></form>
		</div>
		<div class="px-4 py-1">
			<form action="listaTareas.php"><button type="submit" class="btn btn-outline-dark">Buscar Tarea</button></form>
		</div>
		<div class="px-4 py-1">
			<form action="cambiarC.php"><button type="submit" class="btn btn-outline-dark">Cambiar Contrasenia</button></form>	
		</div>
		<div class="px-4 py-1">
			<form action="cerrarSesion.php"><button type="submit" class="btn btn-danger">Cerrar Sesion</button></form>	
		</div>
	</div>
	
	
</body>
</html>