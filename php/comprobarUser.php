
<?php
	extract($_REQUEST);

	include_once("crearConexion.php");
	$sql="SELECT nickname FROM usuario WHERE nickname='$nik';";
	$rsNik=$mysql->consultas($sql);
	
	if($reg=mysqli_fetch_array($rsNik))
	{
		echo 0;
	}
	else
	{
		echo 1;
	}
?>