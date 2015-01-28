<?php
session_start();
include_once 'crearConexion.php';
include_once 'clases/CEncriptacion.php';

$usuario=$_REQUEST['Usuario'];
$pass=$_REQUEST['Pass'];


$sql="SELECT pk_usuarios,nickname,pass,tipo FROM usuario 
INNER JOIN cat_tipousuario ON fk_tipoUsuario=pk_tipoUsuario
WHERE nickname='".$usuario."'";
$reg=$mysql->consultas($sql);
if(!$result=mysqli_fetch_array($reg))
{
	header("Location:../index.php");
}
else
{
	$hash=$result['pass'];
	$encrip=new encriptacion();
	$arrHash=$encrip->desencriptar($hash);
	$evaluar=$arrHash['salt'].$pass;
	$resultado=$arrHash['longitud'].hash('whirlpool',$evaluar).$arrHash['salt'];
	if($resultado==$hash)
	{
		$_SESSION['user']=$usuario;
		$_SESSION['id']=$result['pk_usuarios'];
		$_SESSION['tipoU']=$result['tipo'];
		if($result['tipo']=="INVENTARIOS")
		{
		header("Location:asignarE");
		}
		else if($result['tipo']=="MATERIALES")
		{
			header("Location:Factura");
		}
		else if($result['tipo']=="FINANCIEROS")
		{
			header("Location:SalidaFac");
		}
		else if($_SESSION['tipoU']=="admin")
		{
			header("Location:usuarioA");
		}
	}
	else
	{
		header("Location:../index.php");
	}
}
?>