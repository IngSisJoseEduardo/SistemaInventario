<?php
include_once("../crearConexion.php");
$sqlPartida="SELECT * FROM catPartida";
$rsPartida=$mysql->consultas($sqlPartida);
$x=0;
while ($regPartida=mysqli_fetch_array($rsPartida))
{
	$arrayPartida[$x]['pkPartida']=$regPartida[0];
	$arrayPartida[$x]['numeroPartida']=$regPartida[1];
	$arrayPartida[$x]['Partida']=$regPartida[2];
	$x++;
}
// echo "<pre>";
// print_r($arrayPartida);
// echo "</pre>";
echo json_encode($arrayPartida);
?>