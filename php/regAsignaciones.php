<?php
//iniciando sesiones
session_start();

//creando la conexion a la base de datos
include_once("crearConexion.php");

//obteniendo datos de formulario, guardadon id de equipos en arreglo, id de empleado,id de departamento
	foreach($_REQUEST as $indice => $contenido)
	{
		if($indice!="PHPSESSID")
		{
			
			if(substr($indice,0,6)=="equipo")
			{
				$equipos[]=$contenido;
			}
			else if(substr($indice,0,9)=="ubicacion")
			{
				$ubicaciones[]=$contenido;
			}
			else if($indice=="empleado")
			{
				$emple=$contenido;
				$codigoAsignacion=$contenido;
			}
			else if($indice=="depto")
			{
				$depto=$contenido;
				$codigoAsignacion.=$contenido;
			}
		}
	}

//serializando arreglo equipos para mandarlo a asignarSoftware.php
$evaluarEquipos=serialize($equipos);
//consultando usuario del sistema
$sqlUsuario="SELECT * FROM usuario WHERE nickname='".$_SESSION['user']."'";
$rsUser=$mysql->consultas($sqlUsuario);
$regUser=mysqli_fetch_array($rsUser);

$fkUsuario=$regUser['pk_usuarios'];
//echo $fkUsuario;

//obteninedo cantidad de euipos asignados
$cantidadEquipos=count($equipos);

//verificando codigo de asignacion
//**********Si ya exite uan asignacion con este codigo entrara en el adesicion ára actualizar la cantidad de equipos que tiene el empleado
$sqlasignacion="SELECT * FROM asignacion WHERE codigoAsignacion=".$codigoAsignacion;
$rsAsignacion=$mysql->consultas($sqlasignacion);
if($reg=mysqli_fetch_array($rsAsignacion))
{
	$cantidadActual=$reg['cantidadEquipos'];
	$updateAsignacion="UPDATE asignacion SET cantidadEquipos=".($cantidadEquipos+$cantidadActual)." WHERE codigoAsignacion=".$codigoAsignacion;	
	$mysql->insUpdDel($updateAsignacion);
	
	//registrando los nuevos equipos de este empleado
	for($x=0;$x<$cantidadEquipos;$x++)
	{
		$agregarEquipos="INSERT INTO equiposasignados (fk_invDetalle,fk_asigancion,fk_ubicacion,fk_usuarioAsigno) VALUES (".$equipos[$x].",".$reg['pk_asigancion'].",".$ubicaciones[$x].",".$fkUsuario.")";
		$mysql->insUpdDel($agregarEquipos);
		
		$sqlConsumible="SELECT  catConsumible.EstadoConsumible,catConsumible.pkConsumible,invgeneral.cantidad,pk_inventario FROM invdetalle
						INNER JOIN  invgeneral on fk_inventario=pk_inventario
						INNER JOIN  catConsumible on fkConsumible=pkConsumible 
						where pk_invDetalle=".$equipos[$x];
		$rsConsumible=$mysql->consultas($sqlConsumible);
		$regConsumible=mysqli_fetch_row($rsConsumible);
		if($regConsumible[1]==2)
		{
			$slqUpdetaGenerarl="UPDATE invgeneral SET cantidad=".($regConsumible[2]-1)."  WHERE pk_inventario=".$regConsumible[3];
			$mysql->insUpdDel($slqUpdetaGenerarl);
			//modificando el estado del equipo a asignado
				$modificarEstado="UPDATE invdetalle SET fk_estado=4 WHERE pk_invDetalle=".$equipos[$x];
				$mysql->insUpdDel($modificarEstado);
		}
		else
		{
			//modificando el estado del equipo a asignado
				$modificarEstado="UPDATE invdetalle SET fk_estado=2 WHERE pk_invDetalle=".$equipos[$x];
				$mysql->insUpdDel($modificarEstado);				
		}	
		
	}
	//redireccionando a la pagina de asignaciones
	echo "<script> alert('Se agregaron mas articulos a este empleado');
	location.href='asignarE';</script>";
}
//si el codigo de asignacion no existe en la base de datos, el sigueinte procedimiento corresponde al registro de los datos de una asignacion
else
{
	//registrando las datos de la asignacion
	$sqlAsig="INSERT INTO asignacion (fk_departamento,codigoAsignacion,cantidadEquipos,fk_empleadoAsignado)VALUES (".$depto.",".$codigoAsignacion.",".$cantidadEquipos.",".$emple.")";
	$mysql->insUpdDel($sqlAsig);
	
	//consultando los datos de la asignacion recientemente ehca
	$sqlasignacionNueva="SELECT * FROM asignacion WHERE codigoAsignacion=".$codigoAsignacion;
	$rsAsignacionNueva=$mysql->consultas($sqlasignacionNueva);
	$regNuevo=mysqli_fetch_array($rsAsignacionNueva);
	
	//registrando los equipos asignados a este empleado
	for($x=0;$x<$cantidadEquipos;$x++)
	{
		$agregarEquipos="INSERT INTO equiposasignados (fk_invDetalle,fk_asigancion,fk_ubicacion,fk_usuarioAsigno) VALUES (".$equipos[$x].",".$regNuevo['pk_asigancion'].",".$ubicaciones[$x].",".$fkUsuario.")";
		$mysql->insUpdDel($agregarEquipos);
		//modificando el estado de los equipos a asignado
		
		$sqlConsumible="SELECT  catConsumible.EstadoConsumible,catConsumible.pkConsumible,invgeneral.cantidad,pk_inventario FROM invdetalle
						INNER JOIN  invgeneral on fk_inventario=pk_inventario
						INNER JOIN  catConsumible on fkConsumible=pkConsumible 
						where pk_invDetalle=".$equipos[$x];
		$rsConsumible=$mysql->consultas($sqlConsumible);
		$regConsumible=mysqli_fetch_row($rsConsumible);
		if($regConsumible[1]==2)
		{
			$slqUpdetaGenerarl="UPDATE invgeneral SET cantidad=".($regConsumible[2]-1)."  WHERE pk_inventario=".$regConsumible[3];
			$mysql->insUpdDel($slqUpdetaGenerarl);
			//modificando el estado del equipo a asignado
				$modificarEstado="UPDATE invdetalle SET fk_estado=4 WHERE pk_invDetalle=".$equipos[$x];
				$mysql->insUpdDel($modificarEstado);
		}
		else
		{
			//modificando el estado del equipo a asignado
				$modificarEstado="UPDATE invdetalle SET fk_estado=2 WHERE pk_invDetalle=".$equipos[$x];
				$mysql->insUpdDel($modificarEstado);				
		}	

	}
	//redireccinando a la pagina de asignaciones
	
	echo "<script> alert('Guardado Con Exito');
	location.href='asignarE';</script>";
}

?>