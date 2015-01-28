<?php
//creando la conexion a labase de datos
include_once("crearConexion.php");
/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/

//obtenienodo los programas y sus respectivos codigos de activacion
foreach($_REQUEST as $indice => $contenido)
	{
		if($indice!="PHPSESSID")
		{
			if(substr($indice,0,2)=="so")
			{
				$programas[]=$contenido;
			}
			else if(substr($indice,0,8)=="programa" )
			{
				$programas[]=$contenido;
			}
			else if(substr($indice,0,6)=="serial" )
			{
				$seriales[]=$contenido;
			}
			else if($indice=="pc")
			{
				$pc=$contenido;
			}
		}
	}
//echo $pc;	
/*echo "<pre>";
print_r($programas);
echo "</pre>";
echo "<pre>";
print_r($seriales);
echo "</pre>";*/

//consultando la pk de equipos asignados con respecto a este equipo
$sqlAsignado="SELECT pk_equiposAsignados FROM equiposasignados WHERE fk_invDetalle=".$pc;
$rsAsignado=$mysql->consultas($sqlAsignado);
$reg=mysqli_fetch_array($rsAsignado);

$pkAsignado=$reg['pk_equiposAsignados'];

//Registrando los programs que tendra esta pc
for($x=0;$x<count($programas);$x++)
{
	$insertar="INSERT INTO softwareasignado (fk_equiposAsignados,fk_software,serialActivacion) VALUES (".$pkAsignado.",".$programas[$x].", '".$seriales[$x]."')";
	//echo $insertar."</br>";
	$mysql->insUpdDel($insertar);
}
echo "<script> alert('Se Registro El Software De Esta PC');
	location.href='asignarE';</script>";
?>
