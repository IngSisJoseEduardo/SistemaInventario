<?php 


/**
* 
*/
class agregarPartida
{
	
	public function agregarPartida()
	{
		extract($_REQUEST);
		$this->busqueda($partida);
	}
	private function busqueda($pPartida)
	{
		include_once('../crearConexion.php');
		$sql  = "SELECT * FROM catpartida WHERE numeroPartida=$pPartida";
		$datos = $mysql->consultas($sql);
		if($parB = mysqli_fetch_row($datos))
		{
			$partidaInfo[] = $parB[0];
			$partidaInfo[] = $parB[1];
			$partidaInfo[] = $parB[2];
		}
		echo json_encode($partidaInfo);
	}
}
new agregarPartida();
?>