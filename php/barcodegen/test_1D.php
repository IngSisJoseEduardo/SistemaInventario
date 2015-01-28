<?php
// Including all required classes
require_once('class/BCGFontFile.php');
require_once('class/BCGColor.php');
require_once('class/BCGDrawing.php');
// Including the barcode technology
require_once('class/BCGcode39.barcode.php');

class codigoBarra
{
	public function codigoBarra()
	{
		$this->configurarCB();
	}
	private function configurarCB()
	{
		// Loading Font
		$this->font = new BCGFontFile('./font/Arial.ttf', 11);
		// Don't forget to sanitize user inputs
		//$text = isset($_GET['text']) ? $_GET['text'] : 'HELLO';
		// The arguments are R, G, B for color.
		$this->color_black=new BCGColor(0, 0, 0);
		//$color_black = new BCGColor(0, 0, 0);
		$this->color_white = new BCGColor(255,255,255);
		//$color_white = new BCGColor(255, 255, 255);
	}
	public function generarCB($text)
	{
		$this->drawException = null;
		try {
			$code = new BCGcode39();
			$code->setScale(1.5); // Resolution
			$code->setThickness(25); // Thickness
			$code->setForegroundColor($this->color_black); // Color of bars
			$code->setBackgroundColor($this->color_white); // Color of spaces
			$code->setFont($this->font); // Font (or 0)
			$code->parse($text); // Text
		} catch(Exception $exception) {
			$this->drawException = $exception;
		}
		return $code;
	}

	public function imagenCB($rutafilenmame,$valorCB)
	{
			/* Here is the list of the arguments
			1 - Filename (empty : display on screen)
			2 - Background color */
			$this->drawing = new BCGDrawing($rutafilenmame.'.png',$this->color_white);
			//$drawing = new BCGDrawing('', $color_white);
			if($this->drawException) {
				$this->drawing->drawException($this->drawException);
				//$drawing->drawException($drawException);
			} else {
				$this->drawing->setBarcode($this->generarCB($valorCB));
				//$drawing->setBarcode($code);
				//$this->drawing->setRotationAngle(270);
				//$drawing->setRotationAngle(270);
				$this->drawing->draw();
				//$drawing->draw();
			}
			
			// Header that says it is an image (remove it if you save the barcode to a file)
			/*header('Content-Type: image/png');
			header('Content-Disposition: inline; filename="barcode.png"');*/
			
			// Draw (or save) the image into PNG format.
			//$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
			$this->drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	}
		private $font,
			$color_black,
			$color_white,
			$drawException,
			$drawing;
}
$codigoBarra = new codigoBarra();
$codigoBarra->imagenCB('nombre','jose eduardo');
?>