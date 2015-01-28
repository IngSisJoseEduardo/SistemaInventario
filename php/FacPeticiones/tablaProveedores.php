<?php
	class tablaProveedores
	{
		public function tablaProveedores()
		{
			extract($_REQUEST);
			if(empty($opcion))
				{$this->obtenerProveedores(0);}
			else{$this->obtenerProveedores($opcion);}
			//metodo que crea la talba de datos
			
		}
		public function obtenerProveedores($opcion)
		{
			include_once("../crearConexion.php");//INCLUYENDO LEL ONJETO DE CONEXION

			$SQL="SELECT * FROM catproveedor";//CONSULTANDO TODOS LOS PROVEDORES
			$rsProveedores=$mysql->consultas($SQL);//EJECUTANDO LA CONSULTA
			
			$x=0;
			while ($reg=mysqli_fetch_row($rsProveedores)) 
			{
				if($opcion!=0)
				{
					$datos[$x][0]=$reg[1];//EN ESTAS
					$datos[$x][1]=$reg[2];//LINEAS 
					$datos[$x][2]=$reg[3];//SE CREA
					$datos[$x][3]=$reg[4];//EL ARREGLO
					$datos[$x][4]=$reg[0];
				//$datos[$x][4]=$reg[0];//EL ARREGLO
				}
				else
				{
					$datos[$x][0]=$reg[1];//EN ESTAS
					$datos[$x][1]=$reg[2];//LINEAS 
					$datos[$x][2]=$reg[3];//SE CREA
					$datos[$x][3]=$reg[4];//EL ARREGLO
					$datos[$x][4]="<a  href='#' class='btn btn-link' onclick='modificarRow(".$reg[0].",\"catproveedor\",\"pkProveedor\",\"datosProveedor.php\");'><span class='glyphicon glyphicon-pencil'></span></a><a  href='#' class='btn btn-link'  onclick='borrarRow(".$reg[0].",\"catproveedor\",\"pkProveedor\",\"eliminarRow.php\");'><span class='glyphicon glyphicon-trash'></span></a>";
					//$datos[$x][4]=$reg[0];//EL ARREGLO
				}
				
				$x++;
			}
			if($opcion!=0){
				$proFac=json_encode($datos);
				echo $proFac;
			}
			else{
				$datosJson=json_encode($datos);
				$respuesta='{"data":'.$datosJson.'}';
				echo  $respuesta;
			}
		}
	}
	new tablaProveedores();
?>