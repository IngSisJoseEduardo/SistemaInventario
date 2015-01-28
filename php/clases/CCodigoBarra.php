<?php
// Including all required classes
include_once('../php/barcodegen/class/BCGFontFile.php');
require_once('../php/barcodegen/class/BCGColor.php');
require_once('../php/barcodegen/class/BCGDrawing.php');
// Including the barcode technology
require_once('../php/barcodegen/class/BCGcode39.barcode.php');

class CCodigoBarra
{
	public function CCodigoBarra()
	{
		//metodo que configura el codigo de barras
		$this->configurarCB();
	}
	private function configurarCB()
	{
		//configura la letra del codigo de barra y el tamaño 
		$this->font = new BCGFontFile('../php/barcodegen/font/Arial.ttf', 12);
		//creadno colo balnco para el fondo del codigo de barra
		$this->color_black=new BCGColor(0, 0, 0);
		//crenado color negro para las barras del codigo
		$this->color_white = new BCGColor(255,255,255);
	}
	private function generarCB($text)
	{
		//variable para cachar error
		$this->drawException = null;
		try {
			//creadno variable del codigo de barra
			$code = new BCGcode39();
			//grosor de las barras
			$code->setScale(1); // Resolution
			//anchura de las barras
			$code->setThickness(30); // Thickness
			//colocando el color de las barras
			$code->setForegroundColor($this->color_black); // Color of bars
			//colocando el color del fondo
			$code->setBackgroundColor($this->color_white); // Color of spaces
			//colocando la fuente al codigo
			$code->setFont($this->font); // Font (or 0)
			//colocando el texto al del valor del codigo de barra
			$code->parse($text); // Text
		} catch(Exception $exception) {
			//mostrando el mensaje de error
			$this->drawException = $exception;
		}
		//regresando el codigo generado
		return $code;
	}

	public function imagenCB($rutafilenmame,$valorCB)
	{
			//metodo genera imagn¿en del codigo de barra
			/*se crea el objeto del metodo BCGDrawing, que recibe por por parametros ubicacion y nombre del archivo , y color de fondo de la imagen*/
			$this->drawing = new BCGDrawing($rutafilenmame.'.png',$this->color_white);
			if($this->drawException) {
				//mensaje de error
				$this->drawing->drawException($this->drawException);
			} else {
				//añadiendo el codigo de barra generado a la imagen
				$this->drawing->setBarcode($this->generarCB($valorCB));
				//genera l aimgen con el angulo de rotacion indicado
				//$this->drawing->setRotationAngle(270);
				//genera la imagen
				$this->drawing->draw();
			}
			
			// Header that says it is an image (remove it if you save the barcode to a file)
			/*header('Content-Type: image/png');
			header('Content-Disposition: inline; filename="barcode.png"');*/
			
			// Draw (or save) the image into PNG format.
			//$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
			//da salida  al imgagen ya sea a la ubicacion o a pantalla
			$this->drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	}
		private $font,
			$color_black,
			$color_white,
			$drawException,
			$drawing;
}

/*$cb=new CCodigoBarra();
$cb->imagenCB("../images/CB/43211",43211);*/
?>