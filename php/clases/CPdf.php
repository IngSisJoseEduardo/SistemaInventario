<?php
	class CPdf
	{
		private $html,
				$estilo,
				$nombreArchivo;
				
		public function CPdf($sHtml,$rEstilo,$nArchivo)
		{
			$this->html=$sHtml;
			$this->estilo=$rEstilo;
			$this->nombreArchivo=$nArchivo;
			$this->crear();
		}
		public function crear()
		{
			if($this->estilo=="")
			{
				include_once("../../mPDF/mpdf.php");//importando mpdf
				$mpdf=new mPDF();//creando objeto
				$mpdf->WriteHTML($this->html);//escribiendo en pdf formato en html
				$mpdf->Output($this->nombreArchivo,'I');//metodo de salida del pdf parametrpo D, realiza descarga del archivo
			}
			else
			{
			include_once("../../mPDF/mpdf.php");//importando mpdf
			$mpdf=new mPDF();//creando objeto
			$stylesheet = file_get_contents($this->estilo);//obteniendo codigo css para imprimir en pdf
			$mpdf->WriteHTML($stylesheet,1);//escribiendo el estilo en pdf
			$mpdf->WriteHTML($this->html);//escribiendo en pdf formato en html
			$mpdf->Output($this->nombreArchivo,'I');//metodo de salida del pdf parametrpo D, realiza descarga del archivo
			}
		}
	}	
?>