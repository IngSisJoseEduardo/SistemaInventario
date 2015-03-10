<?php
class CFactura
{
	public function CFactura()
	{
		extract($_REQUEST);
		switch($opcion)
		{
			case 1:{$this->facPendienteMateriales();}
					break;
			case 2:{$this->facPendienteFinancieros();}
					break;
			case 3:{$this->facturasPagadas();}
					break;
			case 4:{$this->darSalidaFinancieros();}
					break;
			
		}
	}
	private function facPendienteMateriales()
	{
		include_once("../crearConexion.php");
		$sqlFac="select pkFactura,factura.serie,factura.folio,catproveedor.nombreProveedor,factura.subtotal,factura.total,catestadosaliente.EstadoSaliente,fechaFac,tipo FROM factura 
		INNER JOIN catproveedor on factura.fkProveedor=pkProveedor
		INNER JOIN catestadosaliente on fkEstadoSaliente=pkEstadoSaliente
		WHERE fkEstadoSaliente=1
		ORDER BY fechaYhora DESC;";
		$rsFac=$mysql->consultas($sqlFac);
		$x=0;
		while($regFac=mysqli_fetch_row($rsFac))
		{
			//obteneiendo datos de la factura
			$facturas[$x]['pkFac']=$regFac[0];
			$facturas[$x]['serie']=$regFac[1];
			$facturas[$x]['folio']=$regFac[2];
			$facturas[$x]['proveedor']=$regFac[3];
			$facturas[$x]['subtotal']="$".$regFac[4];
			$facturas[$x]['total']="$".$regFac[5];
			$facturas[$x]['fecha']=$regFac[7];
			$facturas[$x]['tipo']=$regFac[8];
			
		// 	//obteniendo detalles de la factura
		 	$sqlTD="SELECT COUNT(*) FROM detallefactura WHERE fkFactura=".$regFac[0];
		 	$totalDetalles=$mysql->consultas($sqlTD);
		 	$regTD=mysqli_fetch_row($totalDetalles);
		 	//mandando el total de detalles
		 	//$facturas[$x]['detalles']=$regTD[0];
		 	$y=$regTD[0];
		// 	//obteniendo los detalles de las facturas
		$sqlDet="SELECT cantidad,descripcion,precioUnitario,iva,importe,masIva FROM detallefactura WHERE fkFactura=".$regFac[0];
		 	$rsDet=$mysql->consultas($sqlDet);
		 	$cen=0;//valor centinela
		 	while($regDet=mysqli_fetch_row($rsDet))
		 	{
		 		$arrayDetalle[$cen][0]=$regDet[0];
		 		$arrayDetalle[$cen][1]=$regDet[1];
		 		$arrayDetalle[$cen][2]="$".$regDet[2];
		 		$arrayDetalle[$cen][3]="$".$regDet[3];
		 		$arrayDetalle[$cen][4]="$".$regDet[4];
		 		$arrayDetalle[$cen][5]="$".$regDet[5];
		 		$cen++;
		 	}
			
		// 	//agregando detalles	
		// 	$facturas[$x]['row']=$arrayDetalle;
		 	$sqlpartidas="SELECT  catpartida.numeroPartida FROM factura
							INNER JOIN factura_catpartida on factura_pkFactura= pkFactura
							INNER JOIN catpartida on catPartida_pkPartida = pkPartida
							where pkFactura=$regFac[0];";
			$rspartidas=$mysql->consultas($sqlpartidas);
			

			while ($regPartidas = mysqli_fetch_row($rspartidas)) {
				$arrayPertidas[] = $regPartidas[0];
			}

			$facGeneral    = json_encode($regFac);
			$data          = json_encode($arrayDetalle);
			$datosPartidas = json_encode($arrayPertidas);

			$facturas[$x]['detalle']="<a href='#materialesPenDet'   data-toggle='modal' width='20' height='26' onclick='modalDetalles(".$facGeneral.",".$datosPartidas.",".$data.",".$y.");'><span class='glyphicon glyphicon-list-alt' ></span></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../img/Excel.png' width='20' height='26' alt='excel' style='cursor:pointer;' onClick='exportarExcel(".$regFac[0].",0);'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../img/PDF.png' width='20' height='26' alt='pdf' style='cursor:pointer;' onClick='exportarPDF(".$regFac[0].",0);'/> ";
			$arrayDetalle=null;
			$arrayPertidas=null;
			$x++;
		}
		
		$jsFactura=json_encode($facturas);
		echo '{"data":'.$jsFactura."}";
	}
	private function facPendienteFinancieros()
	{
		include_once("../crearConexion.php");
		$sqlFac="select pkFactura,factura.serie,factura.folio,catproveedor.nombreProveedor,factura.subtotal,factura.total,catestadosaliente.EstadoSaliente,fechaFac FROM factura 
		INNER JOIN catproveedor on factura.fkProveedor=pkProveedor
		INNER JOIN catestadosaliente on fkEstadoSaliente=pkEstadoSaliente
		WHERE fkEstadoSaliente=1
		ORDER BY fechaYhora DESC;";
		$rsFac=$mysql->consultas($sqlFac);
		$x=0;
		while($regFac=mysqli_fetch_row($rsFac))
		{
			//obteneiendo datos de la factura
			//$facturas[$x]['pkFac']="<a href='#'  onclick='darSalida(".$regFac[0].");'><span class='glyphicon glyphicon-share-alt'></a></span>";
			$facturas[$x]['serie']     =$regFac[1];
			$facturas[$x]['folio']     =$regFac[2];
			$facturas[$x]['proveedor'] =$regFac[3];
			$facturas[$x]['subtotal']  ="$".$regFac[4];
			$facturas[$x]['total']     ="$".$regFac[5];
			//$facturas[$x]['estado']=$regFac[6];//MOSTRANDO EL ESTADO DE LA FACTURA
			$facturas[$x]['fecha']=$regFac[7];
			//obteniendo detalles de la factura
			$sqlTD="SELECT COUNT(*) FROM detallefactura WHERE fkFactura=".$regFac[0];
			$totalDetalles=$mysql->consultas($sqlTD);
			$regTD=mysqli_fetch_row($totalDetalles);
			//mandando el total de detalles
			//$facturas[$x]['detalles']=$regTD[0];//ENVIANDO CANTIDAD DE DETALLES
			$y=$regTD[0];
			//obteniendo los detalles de las facturas
			$sqlDet="SELECT cantidad,descripcion,precioUnitario,iva,importe,masIva FROM detallefactura WHERE fkFactura=".$regFac[0];
			$rsDet=$mysql->consultas($sqlDet);
			$cen=0;//valor centinela
			while($regDet=mysqli_fetch_row($rsDet))
			{
				$arrayDetalle[$cen][0]=$regDet[0];
				$arrayDetalle[$cen][1]=$regDet[1];
				$arrayDetalle[$cen][2]="$".$regDet[2];
				$arrayDetalle[$cen][3]="$".$regDet[3];
				$arrayDetalle[$cen][4]="$".$regDet[4];
				$arrayDetalle[$cen][5]="$".$regDet[5];
				$cen++;
			}
			
			//agregando detalles	
			//$facturas[$x]['row']=$arrayDetalle;//enviando los detalles de cada factura
			$sqlpartidas="SELECT  catpartida.numeroPartida FROM factura
							INNER JOIN factura_catpartida on factura_pkFactura= pkFactura
							INNER JOIN catpartida on catPartida_pkPartida = pkPartida
							where pkFactura=$regFac[0];";
			$rspartidas=$mysql->consultas($sqlpartidas);
			

			while ($regPartidas = mysqli_fetch_row($rspartidas)) {
				$arrayPertidas[] = $regPartidas[0];
			}
			$facGeneral  =json_encode($regFac);
			$data        =json_encode($arrayDetalle);
			$arrPartidas =json_encode($arrayPertidas);
			$facturas[$x]['pkFac']="<a href='#financierosPenDet'  data-toggle='modal' onclick='modalDetalles(".$facGeneral.",".$arrPartidas.",".$data.",".$y.");'><span class='glyphicon glyphicon-list-alt'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../img/Excel.png' width='20' height='26' alt='excel' style='cursor:pointer;' onClick='exportarExcel(".$regFac[0].",0);'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../img/PDF.png' width='20' height='26' alt='pdf' style='cursor:pointer;' onClick='exportarPDF(".$regFac[0].",0);'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#'  onclick='darSalida(".$regFac[0].");'><span class='glyphicon glyphicon-share-alt'></a>";
			$arrayDetalle=null;
			$arrayPertidas=null;
			$x++;
		}
		
		$jsFactura=json_encode($facturas);
		echo '{"data":'.$jsFactura."}";
	}
	private function facturasPagadas()
	{
		include_once("../crearConexion.php");
		$sqlFac="SELECT pkFactura,serie,folio,nombreProveedor,subtotal,total,catestadosaliente.EstadoSaliente,fechaFac,numeroPartida,proyecto,clave,descripcionPartida,importe FROM factura
						inner join catproveedor on fkProveedor=pkProveedor 
						inner join saliente on pkFactura=factura_pkFactura
						INNER JOIN catestadosaliente on fkEstadoSaliente=pkEstadoSaliente
						inner join catpartida on fkPartida=pkPartida
						where fkEstadoSaliente=2
					ORDER BY fechaYhora DESC;";
		$rsFac=$mysql->consultas($sqlFac);
		$x=0;
		while($regFac=mysqli_fetch_row($rsFac))
		{
			//obteneiendo datos de la factura
			$facturas[$x]['serie']=$regFac[1];
			$facturas[$x]['folio']=$regFac[2];
			$facturas[$x]['proveedor']=$regFac[3];
			$facturas[$x]['subtotal']="$".$regFac[4];
			$facturas[$x]['total']="$".$regFac[5];
			$facturas[$x]['t']=$regFac[6];
			$facturas[$x]['fecha']=$regFac[7];
			$facturas[$x]['partida']=$regFac[8];
			$facturas[$x]['proyecto']=$regFac[9];
			$facturas[$x]['clave']=$regFac[10];
			$facturas[$x]['descripcion']=$regFac[11];
			$facturas[$x]['importe']=$regFac[12];
			//obteniendo detalles de la factura
			$sqlTD="SELECT COUNT(*) FROM detallefactura WHERE fkFactura=".$regFac[0];
			$totalDetalles=$mysql->consultas($sqlTD);
			$regTD=mysqli_fetch_row($totalDetalles);
			//mandando el total de detalles
			//$facturas[$x]['detalles']=$regTD[0];
			$y=$regTD[0];
			//obteniendo los detalles de las facturas
			$sqlDet="SELECT cantidad,descripcion,precioUnitario,iva,importe,masIva FROM detallefactura WHERE fkFactura=".$regFac[0];
			$rsDet=$mysql->consultas($sqlDet);
			$cen=0;//valor centinela
			while($regDet=mysqli_fetch_row($rsDet))
			{
				$arrayDetalle[$cen][0]=$regDet[0];
				$arrayDetalle[$cen][1]=$regDet[1];
				$arrayDetalle[$cen][2]="$".$regDet[2];
				$arrayDetalle[$cen][3]="$".$regDet[3];
				$arrayDetalle[$cen][4]="$".$regDet[4];
				$arrayDetalle[$cen][5]="$".$regDet[5];
				$cen++;
			}
			
			//agregando detalles	
			//$facturas[$x]['row']=$arrayDetalle;$facGeneral=json_encode($regFac);
			$facGeneral=json_encode($regFac);
			$data2=json_encode($arrayDetalle);
			$facturas[$x]['detalles']="<a href='#financierosPenDet'  data-toggle='modal' onclick='modalDetalles(".$facGeneral.",".$data2.",".$y.");'><span class='glyphicon glyphicon-list-alt'></span></a>&nbsp;&nbsp;&nbsp;<img src='../img/Excel.png' width='20' height='26' alt='excel' style='cursor:pointer;' onClick='exportarExcel(".$regFac[0].",1);'/> &nbsp;&nbsp;&nbsp;<img src='../img/PDF.png' width='20' height='26' alt='pdf' style='cursor:pointer;' onClick='exportarPDF(".$regFac[0].",1);'/>";
			$arrayDetalle=null;
			
			$x++;
		}
		
		$jsFactura=json_encode($facturas);
		echo '{"data":'.$jsFactura."}";
	}
	private function darSalidaFinancieros()
	{
		extract($_REQUEST);
		include_once("../crearConexion.php");
		$sqlFac="select pkFactura,factura.serie,factura.folio,catproveedor.nombreProveedor,factura.subtotal,factura.total,catestadosaliente.EstadoSaliente,fechaFac,proyecto,fkPartida,catPartida.descripcionPartida FROM factura 
		INNER JOIN catproveedor on factura.fkProveedor=pkProveedor
		INNER JOIN catestadosaliente on fkEstadoSaliente=pkEstadoSaliente
		INNER JOIN catPartida on fkPartida=pkPartida
		WHERE pkFactura=$id;";
		$rsFac=$mysql->consultas($sqlFac);
		while($regFac=mysqli_fetch_row($rsFac))
		{
			//obteneiendo datos de la factura
			$facturas['pkFac']=$regFac[0];
			$facturas['serie']=$regFac[1];
			$facturas['folio']=$regFac[2];
			$facturas['proveedor']=$regFac[3];
			$facturas['subtotal']="$".$regFac[4];
			$facturas['total']="$".$regFac[5];
			$facturas['fecha']=$regFac[7];
			$facturas['proyecto']=$regFac[8];
			$facturas['partida']=$regFac[9];
			$facturas['descripcion']=$regFac[10];
		}

		
		$jsFactura=json_encode($facturas);
		echo $jsFactura;
	}
}//fin de la clase
new CFactura();

?>