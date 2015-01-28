<?php

class ubicacionesBD
{
	public function ubicacionesBD()
	{
		extract($_REQUEST);
		if(isset($opcion))
		{
			switch($opcion)
			{
				case "llenar_form": $this->llenarForm(); break;
				default : break;
			}
		}
	}
	
	public function llenarForm()
	{	
		include_once "crearConexion.php";
		$sql="SELECT * FROM cat_ubicaciones";
		$rsUbicaciones=$mysql->consultas($sql);
		while($reg=mysqli_fetch_array($rsUbicaciones))
		{
			$datos[]=array('pk_ubicacion'=>$reg['pk_ubicacion'],'nomubicacion'=>$reg['ubicacion']);
		}
		echo json_encode($datos);
	}	
		
		
		
		/*public function ubicacionesBD()
		{
			$this->obtenerDatos();	
		}
		public function obtenerDatos()
		{
			include_once "crearConexion.php";
			$sql="SELECT * FROM cat_ubicaciones";
			
			$rsDatos=$mysql->consultas($sql);
			while($reg=mysqli_fetch_array($rsDatos))
			{
				$datos[]=array('pk_ubicacion'=>$reg['pk_ubicacion'],'nomubicacion'=>$reg['ubicacion']);
			}			
			echo json_encode($datos);
		}*/
}
new ubicacionesBD();


?>