<?php 	
	include_once "../crearConexion.php";
	$folioSerie=$_REQUEST['serieFolio'];

	$sql="SELECT * FROM factura WHERE serie='$folioSerie' || folio='$folioSerie'";
	$factura=$mysql->consultas($sql);
	$datosFac=mysqli_fetch_assoc($factura);
	
	$arrayFac[1]=$datosFac['pkFactura'];
	$arrayFac[2]=$datosFac['serie'];
	$arrayFac[3]=$datosFac['folio'];
	$arrayFac[4]=$datosFac['fkProveedor'];
	$arrayFac[5]=$datosFac['proyecto'];
	// $arrayFac[6]=$datosFac['fkPartida'];
	
	$sqlPartida = "SELECT catPartida_pkPartida,numeroPartida FROM factura_partida
					INNER JOIN catpartida ON catPartida_pkPartida=pkPartida
					WHERE factura_pkFactura=".$datosFac['pkFactura'];
	$rsPartidas=$mysql->consultas($sqlPartida);

	$par=0;
	while ($rowPartidas= mysqli_fetch_row($rsPartidas)) {
		$arrayPartidas[$par]['partida']= $rowPartidas[0];
		$arrayPartidas[$par]['numero']= $rowPartidas[1];
		$par++;
	}
	// print_r($rsPartidas);
	// echo "<pre>";
	// print_r($arrayPartidas);
	// echo "</pre>";

	 json_encode($arrayPartidas);
	$arrayFac[6]=$arrayPartidas;
	$arrayFac[7]=$datosFac['fechaFac'];
	$arrayFac[8]=$datosFac['subtotal'];
	$arrayFac[9]=$datosFac['total'];
	$arrayFac[10]=$datosFac['tipo'];

	$sqlTD="SELECT COUNT(*) FROM detallefactura WHERE fkFactura=".$datosFac['pkFactura'];
			$totalDetalles=$mysql->consultas($sqlTD);
			$regTD=mysqli_fetch_row($totalDetalles);
	$arrayFac[11]=$regTD[0];

	$sqlDet="SELECT cantidad,unidad,descripcion,precioUnitario,iva,importe,masIva,pkDetalleFactura FROM detallefactura WHERE fkFactura=".$datosFac['pkFactura'];
	$rsDet=$mysql->consultas($sqlDet);
	
	$x=1;
	while ($regDet=mysqli_fetch_assoc($rsDet)) {
		$arrayDetalles[$x]=$regDet;
		$x++;
	}

	$arrayFac[12]=$arrayDetalles;
	// echo "<pre>";
	// print_r($arrayFac);
	// echo "</pre><br>";

	echo(json_encode($arrayFac));
?>