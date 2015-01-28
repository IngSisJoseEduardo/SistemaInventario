<?php
error_reporting("E-PARSE");
class CConexion{
	private $host,//direccion del host
			$usuario,//usuario de la base de datos
			$password,//contraseña del usuario
			$nombreBD;//nombre de la base de datos a conectar
			
	protected $varConexion;//variable de conexion
	
	public function CConexion($pHost,$pUsuario,$pPassword,$pNombreBD)//construcutor de la clase inicializa las variables anteriores y crea conexion
	{
		$this->host=$pHost;
		$this->usuario=$pUsuario;
		$this->password=$pPassword;
		$this->nombreBD=$pNombreBD;
		$this->crearConexion();
	}
	
	private function crearConexion()//crea la conexion al base de datos con las variables creadas
	{		
		try
		{
			$conex=$this->varConexion=mysqli_connect($this->host,$this->usuario,$this->password);
			if($conex==false)
			{
				throw new Exception('<img src="../img/dbAlert.jpg" width="1300" height="971" alt="alertDB" />');
			}
			$mibd=mysqli_select_db($this->varConexion,$this->nombreBD);// or die("Error Con La Base De Datos");
			 if($mibd==false)
			 {
				 throw new Exception("No Se Econtro La Base DE Datos");
			 }
		}
		catch(Exception $e)
		{
			$mensajeError=$e->getMessage();
			echo $mensajeError;
			$this->__destruct();
		}
	}
	public function insUpdDel($query)
	{
		try
		{
			$reg=mysqli_query($this->varConexion,$query);
			if($reg==false)
			{
				$error=strtoupper(substr($query,0,6));
				
				switch($error)
				{
					case "INSERT":throw new Exception("ERROR al insertar.</br> Por Favor Verifique bien sus datos"); break;
					case "UPDATE":throw new Exception("ERROR al Actualizar.</br> Por Favor Verifique bien sus datos"); break;
					case "DELETE":throw new Exception("No Se Puede Eliminar, Por que Este Dato Esta Siendo Usado"); break;
							  
				}
			}
		}
		catch(Exception $e)
		{
			$mensajeError=$e->getMessage();
			echo "<script>alert('ERROR:".$mensajeError."');</script>";
		}
	}
	public function consultas($query)
	{
		$reg=mysqli_query($this->varConexion,$query) or die("Error De Consulta".mysqli_error());	
		return $reg;
	}
	public function cerrarConexion()
	{
		mysqli_close($this->varConexion);
	}
}
?>