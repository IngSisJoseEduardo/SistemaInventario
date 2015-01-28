<?php
class CNotificaciones
{	
	public function CNotificaciones()
	{
		extract($_REQUEST);
		switch($opcion)
		{
			case 'notFac':{$this->notFacutras();}break;
		}
	}
	private function notFacutras()
	{
		include_once('../crearConexion.php');
		$numFac="SELECT COUNT(*) FROM factura where fkEstadoSaliente=1;";
		$rs=$mysql->consultas($numFac);
		$reg=mysqli_fetch_row($rs);
		echo $reg[0];
	}
}
new CNotificaciones();
?>