<?php
include_once("crearConexion.php");

$equipos=$_REQUEST['equipos'];
$pk_asignacion=$_REQUEST['pkAsignacion'];
$cantidadEquipos=count($equipos);
if(count($equipos)==0)
{
	echo"<script>
		alert('No se selecciono ningun equipo');
		self.location='asignaciones.php';
		</script>";
}
else
{
	$consultarAsignacion="SELECT * FROM asignacion WHERE pk_asigancion=".$pk_asignacion;
	$rsAsignacion=$mysql->consultas($consultarAsignacion);
	if($regAsignacion=mysqli_fetch_array($rsAsignacion))
	{
		$updateAsignacion="UPDATE asignacion SET cantidadEquipos=".($regAsignacion['cantidadEquipos']-$cantidadEquipos)." WHERE pk_asigancion=".$pk_asignacion;
		$mysql->insUpdDel($updateAsignacion);
		foreach($equipos as $valor)
		{
			//echo $valor."</br>";
			$deletAsignacion="DELETE FROM equiposasignados WHERE fk_invDetalle=".$valor;
			//echo $deletAsignacion;
			$mysql->insUpdDel($deletAsignacion);
			
			$sqlConsumible="SELECT  catConsumible.EstadoConsumible,catConsumible.pkConsumible,invgeneral.cantidad,pk_inventario FROM invdetalle
						INNER JOIN  invgeneral on fk_inventario=pk_inventario
						INNER JOIN  catConsumible on fkConsumible=pkConsumible 
						where pk_invDetalle=".$valor;
			$rsConsumible=$mysql->consultas($sqlConsumible);
			$regConsumible=mysqli_fetch_row($rsConsumible);
			if($regConsumible[1]!=2)
			{
				//modificando el estado del equipo a asignado
					$modificarEstado="UPDATE invdetalle SET fk_estado=1 WHERE pk_invDetalle=".$valor;
					$mysql->insUpdDel($modificarEstado);
			}
		
//			$updateEstadpEquipo="UPDATE invdetalle SET fk_estado=1 WHERE pk_invDetalle=".$valor;
//			$mysql->insUpdDel($updateEstadpEquipo);
		}
		echo "<script>
				alert('Operacion Exitosa');
				self.location='asignaciones.php';
			</script>";
	}
}

?>