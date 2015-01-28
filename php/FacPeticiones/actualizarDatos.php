<?php
include_once('../crearConexion.php');
extract($_REQUEST);
$sql="";
switch($tabla){
	case 'catProveedor': $sql="UPDATE catproveedor SET nombreProveedor='$nombrePro', rfc='$rfcPro', direccion='$dirPro', telefono=$telPro WHERE pkProveedor='$idPro'";
	break;
}

$mysql->insUpdDel($sql);
echo("MENSAJE:");

//$sql="UPDATE catproveedor SET nombreProveedor='$nombrePro', rfc='$rfcPro', direccion='$dirPro', telefono='$telPro' WHERE pkProveedor='1'";

?>