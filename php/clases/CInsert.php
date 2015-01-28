<?php 
	class CInsert
	{
		/*Este es el contructor de l aclse, que recibe com parametro un array, y array
		y el nombre de la tabla, en el eque se guardaran los datos*/
		public function CInsert($pDatos,$pTabla)
		{
			
			$this->datos=$pDatos;
			$this->tabla=$pTabla;
			$this->crearRegistro($this->crearSQL());
			
		}
		/*Este metodo  llamdao crearSql, se encarga de crear la sentencia sql, para
		insertar los datos en la base de datos, de cualquier formulario que envie sus datos*/
		private function crearSQL()
		{
			$this->Sql='INSERT INTO '.$this->tabla.' (';
			$totalIndices=count($this->datos);
			$y=0;
			foreach($this->datos as $indice => $contenido)
			{
				$this->Sql.=$indice;
				$y++;
				if($y==$totalIndices)
				{
					$this->Sql.=') ';
				}
				else
				{
					$this->Sql.=',';
				}
			}
			$this->Sql.='VALUES (';
			$totalIndices=count($this->datos);
			$y=0;
			foreach($this->datos as $indice => $contenido)
			{
				if(is_numeric($contenido))
				{
					$this->Sql.=$contenido;
				}
				else
				{
					$this->Sql.="'$contenido'";
				}				
				$y++;
				if($y==$totalIndices)
				{
					$this->Sql.=')';
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
		private function crearRegistro($sql)
		{
			include_once "../php/crearConexion.php";
			$mysql->insUpdDel($sql);
			//header("Location:../php/inicio.php");
			//include('../php/usuarios.php');
		}
		
		private $datos;
		private $tabla;
		private $Sql;
	}	
?>