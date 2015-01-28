<?php 
//INCLUYENO OBJETO DE CONEXION
include_once "../crearConexion.php";
//obteniendo datos unicos
$pkFac=$_REQUEST['modPkFac'];
$tipo=$_REQUEST['tipo'];
$userID=$_REQUEST['UsuarioFac'];
$folio=$_REQUEST['folioFac'];
$serie=$_REQUEST['serieFac'];
$proyecto=$_REQUEST['proyectoFac'];
$partida=$_REQUEST['partidaFac'];
$proveedor=$_REQUEST['proFac'];
$fecha=$_REQUEST['fechaFac'];
$subtotal=$_REQUEST['modSubT'];
$total=$_REQUEST['modTotal'];

//obteniendo datos repetidos

	foreach($_REQUEST as $indice => $contenido)//inico foreach
	{
		if($indice!="PHPSESSID")
		{
			if(substr($indice,0,8)=="cantidad")
			{
				$cantidad[]=$contenido;
			}
			else if(substr($indice,0,6)=="unidad")
			{
				$unidad[]=$contenido;
			}
			else if(substr($indice,0,11)=="descripcion")
			{
				$descripcion[]=$contenido;
			}
			else if(substr($indice,0,9)=="pUnitario")
			{
				$pUnitario[]=$contenido;
			}
			else if(substr($indice,0,4)=="ivaB")
			{
				$iva[]=$contenido;
			}
			else if(substr($indice,0,7)=="importe")
			{
				$importe[]=$contenido;
			}
			else if(substr($indice,0,4)=="ivaD")
			{
				$masIVA[]=$contenido;
			}
			else if(substr($indice,0,12)=="pkModDetalle")
			{
				$idsDetalles[]=$contenido;
			}
		}//fin if principal
	}//fin foreach

	//Actualizando  FACTURA
	//INSERT INTO `scipgi`.`factura` (`fk_usuariosFactura`, `serie`, `folio`, `fkProveedor`, `subtotal`, `total`, `fkEstadoSaliente`, `fechaFac`) VALUES ('11', 'oi', 'oi', '7', '98', '89', '1', '2014-12-12');
	$sql="UPDATE  `scipgi`.`factura` SET `fk_usuariosFactura`=$userID, `serie`='$serie', `folio`='$folio', `fkProveedor`=$proveedor, `subtotal`='$subtotal', `total`='$total', `fechaFac`='$fecha',proyecto='$proyecto',fkPartida=$partida,tipo='$tipo'  WHERE pkFactura=".$pkFac;
	$mysql->insUpdDel($sql);

	// ACTUALIZANDO LOS DETALLES DE LA FACTURA
	// $sql2="SELECT pkFactura FROM factura WHERE folio='$folio' AND serie='$serie' ";
	// $rsFac=$mysql->consultas($sql2);
	// $regFac=mysqli_fetch_array($rsFac);
	//INSERT INTO `scipgi`.`detallefactura` (`fkFactura`, `cantidad`, `descripcion`, `precioUnitario`, `iva`, `importe`, `masIva`, `fkEstadoInventario`) VALUES ('1', $cantidad[$x], '$descripcion[$x]', $pUnitario[$x],$iva[$x],$importe[$x],$masIVA[$x],1);
	for($x=0;$x<count($cantidad);$x++)
	{
		$sql3="UPDATE `scipgi`.`detallefactura` SET `fkFactura`=$pkFac, `cantidad`=$cantidad[$x],`unidad`='$unidad[$x]', `descripcion`='$descripcion[$x]',`precioUnitario`='$pUnitario[$x]', `iva`='$iva[$x]', `importe`='$importe[$x]', `masIva`='$masIVA[$x]', `fkEstadoInventario`=1 WHERE pkDetalleFactura=$idsDetalles[$x];";
		$mysql->insUpdDel($sql3);	
	}
	echo "MENSAJE."
 ?>