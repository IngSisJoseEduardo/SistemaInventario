<?php 
	extract($_REQUEST);
	include_once "../crearConexion.php";

	$sqlPartidas="SELECT * FROM catpartida WHERE numeroPartida=$param1";
	$rsPartidas=$mysql->consultas($sqlPartidas);

	if ($rowPartida= mysqli_fetch_row($rsPartidas)) {
		$arrayPartida[0]=$rowPartida[0];
		$arrayPartida[1]=$rowPartida[1];
		echo json_encode($arrayPartida);
	}
	else{
		echo 'error';
	}
?>