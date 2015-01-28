<?PHP
extract($_REQUEST);
include_once('../crearConexion.php');


$sql="DELETE FROM ".$tabla." WHERE ".$columna."=".$id;
//echo $sql;
$mysql->insUpdDel($sql);

?>