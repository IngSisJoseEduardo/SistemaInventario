<?php
	class pcProgramas
	{
		public function pcProgramas()
		{
			extract($_REQUEST);
			if(isset($opcion))
			{
				//echo $opcion;
				$this->obtenerDatos($opcion);
			}
			
		}
		public function obtenerDatos($pc)
		{
			include_once "crearConexion.php";
			$sql="SELECT software.nombreSoftware, softwareasignado.serialActivacion,softwareasignado.pk_softwareAsignado FROM equiposasignados
					INNER JOIN softwareasignado ON fk_equiposAsignados=pk_equiposAsignados
					INNER JOIN software ON fk_software=pk_software
					WHERE fk_invDetalle=".$pc;
			
			$rsDatos=$mysql->consultas($sql);
			$x=0;
			while($reg=mysqli_fetch_array($rsDatos))
			{
				$datos[$x][0]=$reg['nombreSoftware'];
				$datos[$x][1]=$reg['serialActivacion'];
				$datos[$x][2]=$reg['pk_softwareAsignado'];
				
				
				$x++;
			}
			$sql2="SELECT invdetalle.pk_invDetalle,invdetalle.codigoBarra,invdetalle.no_serie,invgeneral.modelo,cat_marca.marca,cat_categoria.categoria FROM invdetalle 
					INNER JOIN invgeneral ON fk_inventario=pk_inventario
					INNER JOIN cat_marca ON fk_marca=pk_marca
					INNER JOIN cat_categoria ON fk_categoria=pk_categoria
					WHERE pk_invDetalle=".$pc;
			$rsEquipo=$mysql->consultas($sql2);
			if($regEquipo=mysqli_fetch_array($rsEquipo));
			{
				$datos[$x][0]=$regEquipo['codigoBarra'];
				$datos[$x][1]=$regEquipo['no_serie'];
				$datos[$x][2]=$regEquipo['modelo'];
				$datos[$x][3]=$regEquipo['marca'];
				$datos[$x][4]=$regEquipo['categoria'];
				$datos[$x][5]=$regEquipo['pk_invDetalle'];
			}
			echo json_encode($datos);
		}
	}
	new pcProgramas();
?>