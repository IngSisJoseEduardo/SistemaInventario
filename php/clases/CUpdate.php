<?php 
	class CUpdate
	{
		/*Este es el contructor de l aclse, que recibe com parametro un array, y array
		y el nombre de la tabla, en el eque se guardaran los datos*/
		public function CUpdate($pDatos,$pTabla)
		{
			
			$this->datos=$pDatos;
			$this->tabla=$pTabla;
			$this->actualizarRegistro($this->crearSQL());
			
		}
		/*Este metodo  llamdao crearSql, se encarga de crear la sentencia sql, para
		insertar los datos en la base de datos, de cualquier formulario que envie sus datos*/
		private function crearSQL()
		{
			$this->Sql='UPDATE '.$this->tabla.' SET ';
			$totalIndices=count($this->datos);
			$y=0;
			foreach($this->datos as $indice => $contenido)
			{
				if(is_numeric($contenido))
				{
					$this->Sql.=$indice."=".$contenido;
				}
				else
				{
					$this->Sql.=$indice."='$contenido'";
				}				
				$y++;
				if($y==$totalIndices)
				{
					$this->Sql.=';';
				}
				else if($y==$totalIndices-1)
				{
					$this->Sql.=' WHERE ';
				}
				else
				{
					$this->Sql.=',';
				}
			}
			return $this->Sql;			
		}
		/*Este metodo llamado crear Registro, se encarga de ejecutar la sentencia sql 
		creada en el metodo crearSql
		*/
		private function actualizarRegistro($sql)
		{
			include_once "../php/crearConexion.php";
			$mysql->insUpdDel($sql);
			//header("Location:../php/usuarios.php");
			//echo $sql;
		}
		private $datos;
		private $tabla;
		private $Sql;
	}
?>