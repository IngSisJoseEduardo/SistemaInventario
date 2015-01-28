<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="../js/jquery.dataTablesT.js"></script>
<?php
	include_once 'crearConexion.php';
	$id=$_REQUEST['id'];
	$tabla=$_REQUEST['tabla'];
	$campo=$_REQUEST['campo'];
	$archivo=$_REQUEST['archivo'];

	
	$mysql->insUpdDel("DELETE FROM $tabla WHERE $campo=$id");
	if($archivo=='usuario')
	{
		include('usuarios.php');
	}
	else if($archivo=='cargo')
	{
		include('cargos.php');
	}
	else if($archivo=='categoria')
	{
		include('categorias.php');
	}
	else if($archivo=='marca')
	{
		include('marcas.php');
	}
	else if($archivo=='departamento')
	{
		include('departamentos.php');
	}
	else if($archivo=='empleado')
	{
		include('empleados.php');
	}
	else if($archivo=='categoriaSoftware')
	{
		include('scategorias.php');
	}	
	else if($archivo=='software')
	{
		include('inventariosoftware.php');
	}
	else if($archivo=='asignacion')
	{
		include('asignaciones.php');
	}
	else if($archivo=='autoriza')
	{
		include('autoriza.php');
	}
	else if($archivo=='ubicacion')
	{
		include('ubicaciones.php');
	}
?>