<?php
session_start();

include_once('crearConexion.php');
include_once('cargadorClases.php');

$fk_inventario;
$datosS=$_REQUEST['arreglo'];
$datos=unserialize(stripslashes($datosS));//aqui llegan los datos generales

	foreach($_REQUEST as $indice => $contenido)
	{
		if($indice!="PHPSESSID")
		{
			
			if(substr($indice,0,6)=="codigo")
			{
				$codigo[]=$contenido;
			}
			else if(substr($indice,0,5)=="serie")
			{
				$serie[]=$contenido;
			}
			else if($indice=="ultimoNum")
			{
				$ultimoNumero=$contenido;
			}
		}
	}
	//proceso para registrar datos generales en inventario general
	$queryGeneral="SELECT pk_inventario,cantidad FROM invgeneral WHERE codigoBarra=".$datos['codigoBarra'];
	$rsGeneral=$mysql->consultas($queryGeneral);
	if($regGeneral=mysqli_fetch_array($rsGeneral))
	{
		//actualizando datos registrados
		$upGeneral="UPDATE invgeneral SET cantidad=".($datos['cantidad']+$regGeneral['cantidad'])." WHERE pk_inventario=".$regGeneral['pk_inventario'];
		$mysql->insUpdDel($upGeneral);
		$upUltimoNum="UPDATE ultimonumcodigo SET ultimoNum=".$ultimoNumero." WHERE fk_invG=".$regGeneral['pk_inventario'];
		$mysql->insUpdDel($upUltimoNum);
		$fk_inventario=$regGeneral['pk_inventario'];		
		//header("Location:inventariogeneral.php");
		//echo "los datos estan registrados";
	}
	else
	{
		//registrando datos generales del articulo
		$queryRegistroGeneral="INSERT INTO invgeneral (fk_marca,modelo,detalle,cantidad,fk_categoria,codigoBarra,fkConsumible,tipoInventario) VALUES (".$datos['fk_marca'].",'".$datos['modelo']."','".$datos['detalle']."',".$datos['cantidad'].",".$datos['fk_categoria'].",".$datos['codigoBarra'].",".$datos['fkConsumible'].",'".$datos['fkInventario']."')";
		$mysql->insUpdDel($queryRegistroGeneral);
		$consultaRegistroGeneral="SELECT pk_inventario FROM invgeneral WHERE codigoBarra=".$datos['codigoBarra'];
		$rsRegistroGral=$mysql->consultas($consultaRegistroGeneral);
		$regGral=mysqli_fetch_array($rsRegistroGral);
		$fk_inventario=$regGral['pk_inventario'];
		//guardando informacion del ultimo numero asignadp a esta articulo
		$registroUltimoNum="INSERT INTO ultimonumcodigo(ultimoNum,fk_invG)VALUES(".$ultimoNumero.",".$fk_inventario.")";
		$mysql->insUpdDel($registroUltimoNum);
	}
	
	
	
	$sqlEstadoArticulo="UPDATE  detalleFactura SET fkEstadoInventario=2 WHERE pkDetalleFactura=".$datos['xinventariar'];
	$mysql->insUpdDel($sqlEstadoArticulo);
	
	//proceso para registrar datos en inventario detalle
	$qUser="SELECT pk_usuarios FROM usuario WHERE nickname='".$_SESSION['user']."'";
	$rsU=$mysql->consultas($qUser);
	$regU=mysqli_fetch_array($rsU);
	$pk_user=$regU['pk_usuarios'];	
	
	
	for($x=0;$x<count($codigo);$x++)
	{
		$query="INSERT INTO invdetalle(codigoBarra, fk_inventario, no_Serie, fk_estado, fk_usuario) VALUES (".$codigo[$x].", ".$fk_inventario.", '".$serie[$x]."', 1, ".$pk_user.")";
		$mysql->insUpdDel($query);	
	}
	//despues de todo este rpoceso redireccionar al inventario general
	header("Location:inventG");

?>