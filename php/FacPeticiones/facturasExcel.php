<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../phpExcel/PHPExcel.php';

//OBTENIENDO OBJETO DE CONEXION
include_once("../crearConexion.php");
//OBTENIENDO ESTADO Y ID DE FACTURA
extract($_REQUEST);

$objPHPExcel = new PHPExcel();

		// DATOS FACTURA GENERAL
		if($estado==0)
		{
			//AUTOAUJSTANDO CELDA AL TAMAÑO DEL TEXTO
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Folio')
					->setCellValue('B1', 'Serie')
					->setCellValue('C1', 'Proveedor')
					->setCellValue('D1', 'Subtotal')
					->setCellValue('E1', 'Total')
					->setCellValue('F1', 'Fecha');
			$sqlGeneral="select pkFactura,factura.serie,factura.folio,catproveedor.nombreProveedor,factura.subtotal,factura.total,catestadosaliente.EstadoSaliente,fechaFac FROM factura 
					INNER JOIN catproveedor on factura.fkProveedor=pkProveedor
					INNER JOIN catestadosaliente on fkEstadoSaliente=pkEstadoSaliente
					WHERE pkFactura=".$factura;
			$rsFac=$mysql->consultas($sqlGeneral);
			$regFac=mysqli_fetch_row($rsFac);
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A2',$regFac[1])
						->setCellValue('B2',$regFac[2])
						->setCellValue('C2',$regFac[3])
						->setCellValue('D2',$regFac[4])
						->setCellValue('E2',$regFac[5])
						->setCellValue('F2',$regFac[7]);
			cellColor('A1:F1', 'F28A8C');
		}
		else if($estado==1)
		{
			//AUTOAUJSTANDO CELDA AL TAMAÑO DEL TEXTO
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Fólio')
					->setCellValue('B1', 'Serie')
					->setCellValue('C1', 'Proveedór')
					->setCellValue('D1', 'Subtotál')
					->setCellValue('E1', 'Total')
					->setCellValue('F1', 'Fecha')
					->setCellValue('G1', 'Partída')
					->setCellValue('H1', 'Proyécto')
					->setCellValue('I1', 'Clave')
					->setCellValue('J1', 'Descripción')
					->setCellValue('K1', 'Importe');
			$sqlGeneral="SELECT pkFactura,serie,folio,nombreProveedor,subtotal,total,catestadosaliente.EstadoSaliente,fechaFac,numeroPartida,proyecto,clave,descripcionPartida,importe FROM factura
						inner join catproveedor on fkProveedor=pkProveedor 
						inner join saliente on pkFactura=factura_pkFactura
						INNER JOIN catestadosaliente on fkEstadoSaliente=pkEstadoSaliente
						inner join catpartida on fkPartida=pkPartida
						where pkFactura=".$factura;
			$rsFac=$mysql->consultas($sqlGeneral);
			$regFac=mysqli_fetch_row($rsFac);
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A2',$regFac[1])
						->setCellValue('B2',$regFac[2])
						->setCellValue('C2',$regFac[3])
						->setCellValue('D2',$regFac[4])
						->setCellValue('E2',$regFac[5])
						->setCellValue('F2',$regFac[7])
						->setCellValue('G2',$regFac[8])
						->setCellValue('H2',$regFac[9])
						->setCellValue('I2',$regFac[10])
						->setCellValue('J2',$regFac[11])
						->setCellValue('K2',$regFac[12]);
			cellColor('A1:K1', 'F28A8C');
		}		
		// FIN DATOS FACTURA GENERAL
		//DETALLES DE FACTURA
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A4', 'Cantidad')
					->setCellValue('B4', 'Descripción')
					->setCellValue('C4', 'Precio Unitario')
					->setCellValue('D4', 'IVA')
					->setCellValue('E4', 'Importe')
					->setCellValue('F4', 'Importe +IVA');
		$sqlDetalles="SELECT cantidad,descripcion,precioUnitario,iva,importe,masIva FROM detallefactura WHERE fkFactura=".$factura;
		$rsDetalles=$mysql->consultas($sqlDetalles);
		$contador=5;
		while($regDetalles=mysqli_fetch_row($rsDetalles))
		{
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$contador, $regDetalles[0])
					->setCellValue('B'.$contador, $regDetalles[1])
					->setCellValue('C'.$contador, $regDetalles[2])
					->setCellValue('D'.$contador, $regDetalles[3])
					->setCellValue('E'.$contador, $regDetalles[4])
					->setCellValue('F'.$contador, $regDetalles[5]);
			$contador++;
		}
		//COLOCANDO BORDES A CELDAS 
		/** Borders for all data **/
		   /*$objPHPExcel->getActiveSheet()->getStyle('A1:'.'F1'.$objPHPExcel->getActiveSheet()->getHighestRow()
		)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);*/
		
		//PINTANDO ENCABEZADO DE DETALLES	
		cellColor('A4:F4', 'F28A8C');
		//FIN DETALLES DE FACTURA
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Factura-'.$regFac[1]);
		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="01simple.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		/*header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past*/
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		function cellColor($cells,$color){
			global $objPHPExcel;
			$objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()
			->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array('rgb' => $color)
			));
		}
		exit;	
?>