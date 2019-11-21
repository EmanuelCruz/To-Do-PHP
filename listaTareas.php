<?php 
	include'validarSesion.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>
	</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<form method="GET" class="px-4 py-3">
		<div class="form-group row">
            <label for="inputTarea" class="col-sm-1 col-form-label">Tarea:</label>
            <div class="col-sm-3">
            	<input type="text" class="form-control" placeholder="Tarea" name="tarea" value="<?php if(empty($_GET)==false){echo $_GET['tarea'];}?>" required>
            </div>
    	</div>

    	<div class="form-group row">
            <label for="inputEstado" class="col-sm-1 col-form-label">Estado:</label>
            <div class="col-sm-3">
            	<select name="estado" class="form-control">
					<option value="todas" <?php if(empty($_GET)==false AND $_GET['estado']=="todas"){ echo "selected";}?> >Todas</option>
					<option value ="finalizada" <?php if(empty($_GET)==false AND $_GET['estado']=="finalizada"){ echo "selected";}?> >Finalizada</option>
					<option value="pendiente" <?php if(empty($_GET)==false AND $_GET['estado']=="pendiente"){ echo "selected";}?> >Pendiente</option>
			    </select>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
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
	
	<div class="px-4 py-3">
		<table class=	"table table-hover">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Tarea</th>
					<th scope="col">Estado</th>
					<th scope="col">Fecha de finalizacion</th>
					<th scope="col">Fecha de registro</th>
					<th scope="col">Editar</th>
					<th scope="col">Borrar</th>
				</tr>
			</thead>
	</body>
</html>
	
<?php 
	//si el get no esta vacio es porque es porque se lleno el formulario
	//si el get esta vacio es porque es la primera vez que entra a la pagina
	if (!empty($_GET)) 
	{
		if (!isset($_GET['tarea']))
		{
			echo "No ingresaste tarea";
			die();
		}
		if (!isset($_GET['estado']))
		{
			echo "No seleccionaste estado";
			die();
		}

		$nombreTarea = trim($_GET['tarea']);
		$estado = $_GET['estado'];	

		$lenTarea = strlen($nombreTarea);
		
		if($lenTarea==0)
	    {
	        header("Location: listaTareas.php");
	    }

		//hago la conexion
		$conexion = mysqli_connect("localhost:3306","root","","todo");
		//hago la consuta por tarea
		
		$consultaSql = "SELECT * FROM tareas WHERE tarea_descripcion LIKE '%$nombreTarea%'";

		//Modifico la consulta si tiene estado pendiente o finalizada
		//si es estado todos no modifico la consulta
		if ($estado=="finalizada")
		{
			$consultaSql .= " AND tarea_realizada = 1";
		}
		if ($estado=="pendiente")
		{
			$consultaSql .= " AND tarea_realizada = 0";
		}

		//capturo la respuesta
		$respuesta = mysqli_query($conexion,$consultaSql);

		$registro = mysqli_fetch_array($respuesta);

		if (!empty($registro))
		{
			$idTarea = $registro["id"];
			$tarea = $registro["tarea_descripcion"];
			$tareaEstado = $registro["tarea_realizada"];
			$fechaFinalizacion = $registro["tarea_fecha_realizada"];
			$fechaRegistrada = $registro["tarea_fecha_registrada"];

			if ($tareaEstado=='1') {
				$tareaEstado_txt = 'Finalizada';
			}
			if ($tareaEstado=='0'){
				$tareaEstado_txt = 'Pendiente';	
			}

			echo "<tr>
					<td>$tarea</td>
					<td>$tareaEstado_txt</td>
					<td>$fechaFinalizacion</td>
					<td>$fechaRegistrada</td>
					<td><a href='editar.php?id=$idTarea&tarea=$nombreTarea&estado=$estado'>Editar</a></td>
					<td><a href='borrarTarea.php?id=$idTarea&tarea=$nombreTarea&estado=$estado'>Borrar</a></td>
				  </tr>";
			
			while ($registro = mysqli_fetch_array($respuesta)) 
			{
				$idTarea = $registro["id"];
				$tarea = $registro["tarea_descripcion"];
				$tareaEstado = $registro["tarea_realizada"];
				$fechaFinalizacion = $registro["tarea_fecha_realizada"];
				$fechaRegistrada = $registro["tarea_fecha_registrada"];
				if ($tareaEstado) {
					$tareaEstado_txt = 'Finalizada';
				}
				if ($tareaEstado=='0'){
					$tareaEstado_txt = 'Pendiente';	
				}
				echo "<tr>
						<td>$tarea</td>
						<td>$tareaEstado_txt</td>
						<td>$fechaFinalizacion</td>
						<td>$fechaRegistrada</td>
						<td><a href='editar.php?id=$idTarea&tarea=$nombreTarea&estado=$estado'>Editar</a></td>
						<td><a href='borrarTarea.php?id=$idTarea&tarea=$nombreTarea&estado=$estado'>Borrar</a></td>
					  </tr>";
			}

			echo "</table>";
			echo "</div>";
		}
	}

?>