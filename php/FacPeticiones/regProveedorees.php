<?PHP
//include_once("../clases/CInsert.php");//CLAS QUE REGISTRA LOS DATOS EN LA BD
//INCLUYENDO OBJETO DE CONEXION BD
include_once("../crearConexion.php");

//OBENIENIENDO LOS DATOS DE LOS PROVEEDORES
$nombre=addslashes(htmlspecialchars($_REQUEST['nombrePro']));
$rfc=addslashes(htmlspecialchars($_REQUEST['rfcPro']));
$direccion=addslashes(htmlspecialchars($_REQUEST['dirPro']));
$telefono=addslashes(htmlspecialchars($_REQUEST['telPro']));
//END DATOS PROVEEDORES

//REGISTRANDO DATOS

	$sql="INSERT INTO catproveedor(nombreProveedor,rfc,direccion,telefono)VALUES('".$nombre."', '".$rfc."', '".$direccion."', '".$telefono."')";

		$mysql->insUpdDel($sql);
		echo("PROVEEDOR GUARDDO CON EXITO");	

//END REGISTRO DATOS
?>