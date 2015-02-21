<?php 	
	include_once "../crearConexion.php";
	$folioSerie=$_REQUEST['id'];

	$sql="SELECT * FROM factura WHERE serie='$folioSerie' || folio='$folioSerie'";
	$factura=$mysql->consultas($sql);
	$datosFac=mysqli_fetch_assoc($factura);
	
	$arrayFac[1]=$datosFac['pkFactura'];
	$arrayFac[2]=$datosFac['serie'];
	$arrayFac[3]=$datosFac['folio'];
	$arrayFac[4]=$datosFac['fkProveedor'];
	$arrayFac[5]=$datosFac['proyecto'];

	$sqlPartida ="SELECT numeroPartida, catPartida_pkPartida FROM factura_catpartida
				INNER JOIN catpartida ON catPartida_pkPartida = pkPartida
				WHERE factura_pkFactura=$arrayFac[1]";
	$rsPArtidas =$mysql->consultas($sqlPartida);

	$z=0;
	while ($rowPartida=mysqli_fetch_row($rsPArtidas)) {
		$arrayPartida[$z]['partida']=$rowPartida[1];
		$arrayPartida[$z]['numero']=$rowPartida[0];//por la consulta anteriror pongo en este orden el indice dle arreglo
		$z++;
	}
	$arrayFac[6]=$arrayPartida;


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