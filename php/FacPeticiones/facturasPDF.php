<?php
require_once("../../dompdf/dompdf_config.inc.php");

//extrayendo datos para la consulta
$factura=$_REQUEST['factura'];
$estado=$_REQUEST['estado'];

//extract($_REQUEST);
switch($estado)
{
	case 0:{
			facturasPendientes($factura);
		};
		break;
	case 1:{
			facturasPagadas($factura);		
		};
		break; 
}
function facturasPendientes($pFactura)
{
	include_once("../crearConexion.php");	

	$sqlFactura='select factura.serie,factura.folio,catproveedor.nombreProveedor,factura.subtotal,factura.total,factura.fechaFac FROM factura
				INNER JOIN catproveedor on fkProveedor=fkProveedor
				WHERE pkFactura='.$pFactura;
	
	$rsFactura=$mysql->consultas($sqlFactura);
	$regFactura=mysqli_fetch_row($rsFactura);
	
	$sqlDetallesFac="SELECT cantidad,descripcion,precioUnitario,iva,importe,masIva FROM detallefactura WHERE fkFactura=".$pFactura;
	$rsDetalleFac=$mysql->consultas($sqlDetallesFac);
	$x=0;
	while($regDetallesFac=mysqli_fetch_row($rsDetalleFac))
	{
		$arrayDetalles[$x][0]=$regDetallesFac[0];
		$arrayDetalles[$x][1]=$regDetallesFac[1];
		$arrayDetalles[$x][2]=$regDetallesFac[2];
		$arrayDetalles[$x][3]=$regDetallesFac[3];
		$arrayDetalles[$x][4]=$regDetallesFac[4];
		$arrayDetalles[$x][5]=$regDetallesFac[5];
		$x++;
	}
	$codigo='<html>
	<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../dompdf/www/test/css/print_static.css">
	</head>
	
	<body>
			<table class="change_order_items">
				<tr><th>Folio</th><th>Serie</th><th>Proveedor</th><th>Subtotal</th><th>Total</th><th>Fecha</th></tr>
				<tr style="text-align:right"><td>'.$regFactura[0].'</td><td>'.$regFactura[1].'</td><td>'.$regFactura[2].'</td><td>$'.$regFactura[3].'</td><td>$'.$regFactura[4].'</td><td>'.$regFactura[5].'</td></tr>
			</table>
			<table class="change_order_items">
			<tr><th>Cantidad</th><th>Descripcion</th><th>Precio Unitario</th><th>IVA</th><th>Importe</th><th>Importe +IVA</th></tr>
	';
	for($i=0;$i<count($arrayDetalles);$i++)
	{
		$codigo.='<tr style="text-align:right"><td>'.$arrayDetalles[$i][0].'</td><td>'.$arrayDetalles[$i][1].'</td><td>$'.$arrayDetalles[$i][2].'</td><td>$'.$arrayDetalles[$i][3].'</td><td>$'.$arrayDetalles[$i][4].'</td><td>$'.$arrayDetalles[$i][5].'</td></tr>';
	}
	$codigo.='
		</table>
		</body>
		</html>';
		
		$codigo=utf8_decode($codigo);
		$dompdf=new DOMPDF();
		$dompdf->load_html($codigo);
		ini_set("memory_limit","50M");
		$dompdf->render();
		$dompdf->stream("factura.pdf");
}
function facturasPagadas($idFac)
{
	include_once("../crearConexion.php");	

	$sqlFactura='SELECT pkFactura,serie,folio,nombreProveedor,subtotal,total,catestadosaliente.EstadoSaliente,fechaFac,numeroPartida,proyecto,clave,descripcionPartida,importe FROM factura
						inner join catproveedor on fkProveedor=pkProveedor 
						inner join saliente on pkFactura=factura_pkFactura
						INNER JOIN catestadosaliente on fkEstadoSaliente=pkEstadoSaliente
						inner join catpartida on fkPartida=pkPartida
						where pkFactura='.$idFac;
	
	$rsFactura=$mysql->consultas($sqlFactura);
	$regFactura=mysqli_fetch_row($rsFactura);
	
	$sqlDetallesFac="SELECT cantidad,descripcion,precioUnitario,iva,importe,masIva FROM detallefactura WHERE fkFactura=".$idFac;
	$rsDetalleFac=$mysql->consultas($sqlDetallesFac);
	$x=0;
	while($regDetallesFac=mysqli_fetch_row($rsDetalleFac))
	{
		$arrayDetalles[$x][0]=$regDetallesFac[0];
		$arrayDetalles[$x][1]=$regDetallesFac[1];
		$arrayDetalles[$x][2]=$regDetallesFac[2];
		$arrayDetalles[$x][3]=$regDetallesFac[3];
		$arrayDetalles[$x][4]=$regDetallesFac[4];
		$arrayDetalles[$x][5]=$regDetallesFac[5];
		$x++;
	}
	$codigo='<html>
	<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../dompdf/www/test/css/print_static.css">
	</head>
	
	<body>
			<table class="change_order_items">
				<tr><th>Folio</th><th>Serie</th><th>Proveedor</th><th>Subtotal</th><th>Total</th><th>Fecha</th><th>Partida</th><th>Proyecto</th><th>Clave</th><th>Descrip.</th><th>Importe</th></tr>
				<tr style="text-align:right"><td>'.$regFactura[1].'</td><td>'.$regFactura[2].'</td><td>'.$regFactura[3].'</td><td>$'.$regFactura[4].'</td><td>$'.$regFactura[5].'</td><td>'.$regFactura[7].'</td><td>'.$regFactura[8].'</td><td>'.$regFactura[9].'</td><td>'.$regFactura[10].'</td><td>'.$regFactura[11].'</td><td>'.$regFactura[12].'</td></tr>
			</table>
			<table class="change_order_items">
			<tr><th>Cantidad</th><th>Descripcion</th><th>Precio Unitario</th><th>IVA</th><th>Importe</th><th>Importe +IVA</th></tr>
	';
	for($i=0;$i<count($arrayDetalles);$i++)
	{
		$codigo.='<tr style="text-align:right"><td>'.$arrayDetalles[$i][0].'</td><td>'.$arrayDetalles[$i][1].'</td><td>$'.$arrayDetalles[$i][2].'</td><td>$'.$arrayDetalles[$i][3].'</td><td>$'.$arrayDetalles[$i][4].'</td><td>$'.$arrayDetalles[$i][5].'</td></tr>';
	}
	$codigo.='
		</table>
		</body>
		</html>';
	//echo $codigo;
		$codigo=utf8_decode($codigo);
		$dompdf=new DOMPDF();
		$dompdf->load_html($codigo);
		ini_set("memory_limit","50M");
		$dompdf->render();
		$dompdf->stream("factura.pdf");
	
}
?>