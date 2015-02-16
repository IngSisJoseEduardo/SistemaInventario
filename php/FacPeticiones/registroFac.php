<?php
//INCLUYENO OBJETO DE CONEXION
include_once "../crearConexion.php";
//obteniendo datos unicos
$tipo=$_REQUEST['tipo'];
$userID=$_REQUEST['usuarioFac'];
$folio=$_REQUEST['folioFac'];
$serie=$_REQUEST['serieFac'];
$proyecto=$_REQUEST['proyectoFac'];
$partida=$_REQUEST['partidaFac'];
$proveedor=$_REQUEST['proFac'];
$fecha=$_REQUEST['fechaFac'];
$subtotal=$_REQUEST['subT'];
$total=$_REQUEST['total'];

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
		}//fin if principal
	}//fin foreach
	// 
//REGISTRADNO FACTURA
//INSERT INTO `scipgi`.`factura` (`fk_usuariosFactura`, `serie`, `folio`, `fkProveedor`, `subtotal`, `total`, `fkEstadoSaliente`, `fechaFac`) VALUES ('11', 'oi', 'oi', '7', '98', '89', '1', '2014-12-12');
$sql="INSERT INTO `scipgi`.`factura` (`fk_usuariosFactura`, `serie`, `folio`, `fkProveedor`, `subtotal`, `total`, `fkEstadoSaliente`, `fechaFac`,proyecto,tipo) VALUES ($userID, '$serie', '$folio',$proveedor, '$subtotal','$total', 1, '$fecha','$proyecto','$tipo')";
$mysql->insUpdDel($sql);

//REGISTRADNO DETALLE
$sql2="SELECT pkFactura FROM factura WHERE folio='$folio' AND serie='$serie' ";
$rsFac=$mysql->consultas($sql2);
$regFac=mysqli_fetch_array($rsFac);
//INSERT INTO `scipgi`.`detallefactura` (`fkFactura`, `cantidad`, `descripcion`, `precioUnitario`, `iva`, `importe`, `masIva`, `fkEstadoInventario`) VALUES ('1', $cantidad[$x], '$descripcion[$x]', $pUnitario[$x],$iva[$x],$importe[$x],$masIVA[$x],1);
// REGISTRANDO LAS PARTIDAS PERTENENCIENTE A LA FACTURA
for ($i=0; $i < count($partida) ; $i++) { 
	$sqlpar = "INSERT INTO `scipgi`.`factura_partida` (`factura_pkFactura`, `catPartida_pkPartida`) VALUES ($regFac[0],$partida[$i])";

	$mysql->insUpdDel($sqlpar);
}

for($x=0;$x<count($cantidad);$x++)
{
$sql3="INSERT INTO `scipgi`.`detallefactura` (`fkFactura`, `cantidad`,`unidad`, `descripcion`, `precioUnitario`, `iva`, `importe`, `masIva`, `fkEstadoInventario`) VALUES ($regFac[0], $cantidad[$x],'$unidad[$x]', '$descripcion[$x]', '$pUnitario[$x]','$iva[$x]','$importe[$x]','$masIVA[$x]',1);";
$mysql->insUpdDel($sql3);	
}
echo "MENSAJE.";
?>