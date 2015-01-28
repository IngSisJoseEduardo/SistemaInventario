<?php
//incluyendo la conexion a la base de datos
include_once('crearConexion.php');
function limpia_espacios($cadena){
     $cadena = str_replace(' ', '', $cadena);
     return $cadena;
}

/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
//obteniendo arreglo con datos
$equipos=unserialize(stripcslashes($_REQUEST['mensaje']));

/*echo "<pre>";
print_r($equipos);
echo "</pre>";*/
//recorriendo el arreglo para ver cual de ellos es una computadora
for($x=0;$x<count($equipos);$x++)
{
	//creando la consultas para este articulo del ciclo
	$sql="SELECT equiposasignados.pk_equiposAsignados ,cat_categoria.categoria FROM invdetalle
		INNER JOIN equiposasignados ON fk_invDetalle=pk_invDetalle
		INNER JOIN invgeneral ON fk_inventario=pk_inventario
		INNER JOIN cat_categoria ON fk_categoria=pk_categoria
		WHERE pk_invDetalle=".$equipos[$x];
	$rs=$mysql->consultas($sql);
	$reg=mysqli_fetch_array($rs);
	$categoria=strtolower(limpia_espacios($reg['categoria']));
	//si en algun ciclo hay una categoria que sea pc o similiar a computadora se realizara el proceso de asignar software
	if($categoria=="pc" | $categoria=="c.p.u." | $categoria=="c.p.u"| $categoria=="cpu" | $categoria=="equipodecomputo" | $categoria=="computadora" | $categoria=="laptop" | $categoria=="notebook" | $categoria=="netbook" )
	{
		echo "<script> alert('En La Lista hay Una Computadora Se Le asignaran el software');
		location.href='asignarSoftware.php?pc=".$equipos[$x]."';</script>";
	}
}
echo "<script> alert('No se encontro ninguna computadora en la lista');
		location.href='asignaciones.php';</script>";


?>