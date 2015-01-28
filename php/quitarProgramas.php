<?php

include_once("crearConexion.php");
$software=$_REQUEST['software'];

/*echo "<pre>";
	print_r($software);
	echo "</pre>";*/
if(count($software)!=0)
{
	for($x=0;$x<count($software);$x++)
	{
		$sql="DELETE FROM softwareasignado WHERE pk_softwareAsignado=".$software[$x];
		$mysql->insUpdDel($sql);
		//echo $sql."</br>";
	}
	echo "<script> alert('Operacion Exitosa');
	location.href='asignaciones.php';</script>";
}
else
{
	echo "<script> alert('No selecciono ningun programa');</script>";
}
?>