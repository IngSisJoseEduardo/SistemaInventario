<?php
include_once('../crearConexion.php');
extract($_REQUEST);
// $idFac=$_REQUEST['idFac'];
$sqlRegistro="INSERT INTO `scipgi`.`saliente` (`clave`, `importe`, `factura_pkFactura`) VALUES ('$clave', '$importeSalida', $idFac)";

$sqlUpdateRegistro="UPDATE `scipgi`.`factura` SET `fkEstadoSaliente`='2' WHERE `pkFactura`=$idFac;";

try 
{
	$mysql->insUpdDel($sqlRegistro);
	$mysql->insUpdDel($sqlUpdateRegistro);
	echo "MENSAJE";
		
} catch (Exception $e) {
		echo "NO SE PUDO REGISTRAR EL PAGO";
}
// INSERT INTO `scipgi`.`saliente` (`fkPartida`, `proyecto`, `clave`, `importe`, `factura_pkFactura`) VALUES ('2', 'tu proyecto', 'tu clave', '123123', '2');
// UPDATE `scipgi`.`factura` SET `fkEstadoSaliente`='2' WHERE `pkFactura`='2';  

// echo $sqlRegistro;
?>