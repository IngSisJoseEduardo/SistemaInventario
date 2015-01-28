<?php
class codigoAsignado
{
	public function codigoAsignado()
	{
		extract($_REQUEST);
		if(isset($opcion))
		{
			//echo $opcion;
			$this->obtenerDatos($opcion);
		}
	}
	
	public function obtenerDatos($codigo)
	{	
		include_once "crearConexion.php";
		$sql="SELECT  pk_invDetalle,invdetalle.codigoBarra, no_serie,fk_estado,invgeneral.modelo,cat_marca.marca,cat_categoria.categoria FROM invdetalle
			INNER JOIN invgeneral ON fk_inventario=pk_inventario
			INNER JOIN cat_marca ON fk_marca=pk_marca
			INNER JOIN cat_categoria ON fk_categoria=pk_categoria WHERE invdetalle.codigoBarra='".$codigo."' OR invdetalle.no_serie='".$codigo."'";
		
		$rsDatos=$mysql->consultas($sql);
		if($reg=mysqli_fetch_array($rsDatos))
		{
			//echo "si trae algo";
			if($reg['fk_estado']!= 1)
			{
				$datos[]="asignado";
			}
			else
			{
				$datos[]=$reg['pk_invDetalle'];
				$datos[]=$reg['codigoBarra'];
				$datos[]=$reg['no_serie'];
				$datos[]=$reg['modelo'];
				$datos[]=$reg['marca'];
				$datos[]=$reg['categoria'];
			}
			
		}
		else
		{
			$datos[]="inexistente";
		}
		//print_r($reg);
		echo json_encode($datos);
	}
	
}
new codigoAsignado();
?>