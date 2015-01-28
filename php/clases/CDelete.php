<?php
class CDelete
{
	public function Delete($pId,$pTabla,$pCampo)
	{
		$this->id=$pId;
		$this->tabla=$pTabla;
		$this->campo=$pCampo;
		$this->eliminarRegistro($this->crearSQL());
	}
	private function crearSQL()
	{
		$this->Sql="DELETE FROM ".$this->tabla." WHERE ".$this->campo."=".$this->id;
		return($this->Sql);
	}
	private function eliminarRegistro($sql)
	{
		include_once "../php/crearConexion.php";
		$mysql->insUpdDel($sql);
	}
	private $id;
	private $campo;
	private $tabla;
	private $Sql;
}
?>