<?php
	/**
	 * 
	 */
	class CSlogan 
	{
		private $archivo;
		private $abre;
		private $tSlogan;
		
		public function CSlogan($pTSlogan="",$pUrlArchivo="slogan.txt")
		{
			$this->tSlogan=$pTSlogan;
			$this->archivo=$pUrlArchivo;
		}
		public function contenidoSlogan()
		{
			// Abrimos el archivo para solamente leerlo (r de read)
			$this->abre = fopen($this->archivo, "r");
			// Leemos el contenido del archivo
			$total = fread($this->abre, filesize($this->archivo));
			// Cerramos la conexión al archivo
			fclose($this->abre);
			return $total;
		}
		public function modificarSlogan()
		{
			$total=$this->contenidoSlogan();
			// Abrimos nuevamente el archivo
			$this->abre = fopen($this->archivo, "w");
			// Sumamos 1 nueva visita
			/*if($total==0)
			{
				$total=1;
			}
			else
			{
				$total=0;
			}*/
			//por si quieren dejar en blanco el slogan
			if($this->tSlogan=="")
			{
				$total=" ";	
			}
			//para colocar el mensaje del slogan
			else
			{
				$total=$this->tSlogan;
			}
			// Y reemplazamos por la nueva cantidad de visitas 
			$grabar = fwrite($this->abre,$total);

			// Cerramos la conexión al archivo
			fclose($this->abre);
		}
		public function sloganFinal()
		{
			$this->modificarSlogan();
			$this->contenidoSlogan();
			return $this->contenidoSlogan();
		}
		public function imprimir()
		{
			print $this->sloganFinal();
		}
	}
	
?>