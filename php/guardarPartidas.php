<?php 
	include_once "crearConexion.php";
	$numeroPartida=$_REQUEST['partida'];
	$descripcionPartida=$_REQUEST['descripcion'];

	$sql="INSERT INTO catpartida(numeroPartida,descripcionPartida) VALUES ($numeroPartida,'$descripcionPartida');";
	
	$mysql->insUpdDel($sql);
	
	echo "1";	
?>