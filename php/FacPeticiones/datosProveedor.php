<?php
include_once("../crearConexion.php");

extract($_REQUEST);
//CREANDO LA CONSULTA
$sql="SELECT * FROM $tabla WHERE $columna=$id";

//EJECUTANDO LA CONSULTA
$rsProveedor=$mysql->consultas($sql);

//EXTRAYENDO LOS DATOS
$reg=mysqli_fetch_row($rsProveedor);

//DEVOLVIENDO LOS VALORES EN FORMATO JSON
echo json_encode($reg);
/*echo "<pre>";
print_r($reg);
echo "</pre>";*/


?>