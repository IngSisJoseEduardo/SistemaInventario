<?php 
	include_once('../crearConexion.php');

	$numeroPartida=$_REQUEST['partida'];
	$descripcion=$_REQUEST['descripcion'];
	$pkpartida=$_REQUEST['pk'];


	$sql="UPDATE catpartida SET descripcionpartida='$descripcion', numeropartida=$numeroPartida WHERE pkpartida=$pkpartida;";
	$mysql->insUpdDel($sql);
	echo 1;

?>