<?php
	include'validarSesion.php';

	$idtarea = $_GET["id"];
	//datos de las casillas de filtro
	//las necesito para enviarlas luego con el listaTareas.php
	$tareaFiltro= $_GET['tarea'];
	$estadoFiltro = $_GET['estado'];

	//Hago la consulta a la base de datos para obtener la informacion del registro
	$conexion = mysqli_connect("localhost:3306","root","","todo");
	$consultaSql = "SELECT * FROM tareas WHERE id =$idtarea";
	$respuesta = mysqli_query($conexion,$consultaSql);

	$registro = mysqli_fetch_array($respuesta);

	if($registro == NULL)
	{
		echo "Contacto no encontrado";
		die();
	}
	$tarea = trim($registro['tarea_descripcion']);
	$estado = trim($registro['tarea_realizada']);
	$fechaRealizada = trim($registro['tarea_fecha_realizada']);
	$fechaRegistrada = trim($registro['tarea_fecha_registrada']);

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<form method="POST" class="px-4 py-3">
		<div class="form-group row">
            <label class="col-sm-2 col-form-label">Tarea:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" placeholder="Usuario" name="tarea" value="<?php echo $tarea;?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Estado:</label>
            <div class="col-sm-3">
            	<select name="estado" class="form-control">
					<option value ="finalizada" <?php if($estado=="1"){ echo "selected";}?> >Finalizada</option>
					<option value="pendiente" <?php if($estado=="0"){ echo "selected";}?> >Pendiente</option>
			    </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Fecha Realizacion:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" placeholder="AAAA-MM-DD" name="fechaRealizada" value="<?php echo $fechaRealizada;?> ">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Fecha de registro:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" placeholder="AAAA-MM-DD" name="fechaRegistrada" value="<?php echo $fechaRegistrada;?> ">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        <input class="btn btn-secondary" type="button" onclick="history.back()" name="volverAtras" value="Volver atras">
	</form>

</body>
</html>

<?php 
	if(empty($_POST) == false)
	{
		//tomo los datos nuevos
		$tareaNueva = $_POST["tarea"];
		$estadoNuevo_txt = $_POST["estado"];
		if ($estadoNuevo_txt=='finalizada') {
			$estadoNuevo = 1;
		}
		if ($estadoNuevo_txt=='pendiente') {
			$estadoNuevo = 0;
		}
		$fechaRealizacionNueva = trim($_POST["fechaRealizada"]);
		$fechaRegistradaNueva = trim($_POST["fechaRegistrada"]);

		//hago una nueva conexion
		$conexion = mysqli_connect("localhost","root","","todo");
		
		if ($fechaRealizacionNueva==" " or empty($fechaRealizacionNueva)) {
			$consultaSql = "UPDATE tareas
						SET tarea_descripcion = '$tareaNueva',
		 					tarea_realizada ='$estadoNuevo', 
		 					tarea_fecha_realizada = NULL,
							tarea_fecha_registrada = '$fechaRegistradaNueva'
	 					WHERE id='$idtarea'";
		}
		else
		{
			$consultaSql = "UPDATE tareas
						SET tarea_descripcion = '$tareaNueva',
		 					tarea_realizada ='$estadoNuevo', 
		 					tarea_fecha_realizada = '$fechaRealizacionNueva',
							tarea_fecha_registrada = '$fechaRegistradaNueva'
	 					WHERE id='$idtarea'"; 
		}

		
		

		
	 	$respuesta_consulta = mysqli_query($conexion, $consultaSql);

		if($respuesta_consulta == false)
		{
			die("No se pudo hacer la consulta.");
		}
		echo "<br> Registro actualizado";
    	//vuelvo a mostrar el listado
    	header("location: listaTareas.php?tarea=$tareaFiltro&estado=$estadoFiltro");
	}
	

?>