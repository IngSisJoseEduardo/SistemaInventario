<?php
	/**
	* 
	*/
	class Operaciones
	{
		
		public function Operaciones()
		{
			extract($_REQUEST);

			switch ($operacion) {
				case 1:
						$this->resta($sus1,$sus2,$sbtotal,$total);
					break;
				case 2:
						$this->suma($detallesb,$subtotal);
					break;

			}
		}
		private function resta($opsub,$optotal,$pSub,$ptotal)
		{
			$arrayresultado[0] =$pSub-$opsub;
			$arrayresultado[1] =$ptotal-$optotal;

			echo json_encode($arrayresultado);
		}
		private function suma($mas,$totales){

			$arrayresultado[0] =$mas+$totales;

			echo json_encode($arrayresultado);
		}
	}
	new Operaciones();
 ?>