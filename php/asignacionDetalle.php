<?php
	class asignacionDetalle
	{
		public function asignacionDetalle()
		{
			extract($_REQUEST);
			if(isset($opcion))
			{
				//echo $opcion;
				$this->obtenerDatos($opcion);
			}
			
		}
		public function obtenerDatos($asignacion)
		{
			include_once "crearConexion.php";
			$mysql->insUpdDel("SET lc_time_names = 'es_MX';");
			$sql="SELECT invdetalle.pk_invDetalle,invdetalle.codigoBarra,cat_categoria.categoria,cat_marca.marca,invgeneral.modelo,date_format(fecha_asignacion, '%d/%M/%Y </br>%r') AS Fecha,cat_ubicaciones.ubicacion,usuario.nom_usuario,usuario.ap_patusuario,usuario.ap_matusuario FROM equiposasignados 
					INNER JOIN invdetalle ON fk_invDetalle=pk_invDetalle
					INNER JOIN invgeneral ON fk_inventario=pk_inventario
					INNER JOIN cat_categoria ON fk_categoria=pk_categoria
					INNER JOIN cat_marca ON fk_marca=pk_marca
					INNER JOIN cat_ubicaciones ON fk_ubicacion=pk_ubicacion
					INNER JOIN usuario ON fk_usuarioAsigno=pk_usuarios
					WHERE fk_asigancion=".$asignacion;
			
			$rsDatos=$mysql->consultas($sql);
			$x=0;
			while($reg=mysqli_fetch_array($rsDatos))
			{
				$usuarioAsigno="";
				$usuarioAsigno.=$reg['nom_usuario']." ";
				$usuarioAsigno.=$reg['ap_patusuario']." ";
				$usuarioAsigno.=$reg['ap_matusuario'];
				$datos[$x][0]=$reg['codigoBarra'];
				$datos[$x][1]=$reg['categoria'];
				$datos[$x][2]=$reg['marca'];
				$datos[$x][3]=$reg['modelo'];
				$datos[$x][4]=$reg['Fecha'];
				$datos[$x][5]=$reg['pk_invDetalle'];
				$datos[$x][6]=$reg['ubicacion'];
				$datos[$x][7]=$usuarioAsigno;
				$x++;
			}
			//echo $x;
			$sql2="SELECT departamento,nombre_empleado FROM asignacion 
					INNER JOIN cat_departamento ON fk_departamento=pk_departamento
					INNER JOIN cat_empleado ON fk_empleadoAsignado=pk_empleado
					WHERE pk_asigancion=".$asignacion;
			$rsEmpleado=$mysql->consultas($sql2);
			if($regEmpleado=mysqli_fetch_array($rsEmpleado));
			{
				$datos[$x][0]=$regEmpleado['departamento'];
				$datos[$x][1]=$regEmpleado['nombre_empleado'];
				$datos[$x][2]=$asignacion;	
			}
			/*echo "<pre>";
			print_r($datos);
			echo "</pre>";*/			
			echo json_encode($datos);
		}
	}
	new asignacionDetalle();
?>