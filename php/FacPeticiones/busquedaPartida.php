<?php 
include_once('../crearConexion.php');
$busqueda=$_REQUEST['busqueda'];

$sql="SELECT * FROM catpartida where numeroPartida=".$busqueda;

$partida=$mysql->consultas($sql);
$datosPartida=mysqli_fetch_row($partida);
echo json_encode($datosPartida);

// echo "<pre>";
// print_r($datosPartida);
// echo "</pre>"

?>