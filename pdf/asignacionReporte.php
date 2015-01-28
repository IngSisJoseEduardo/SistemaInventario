<?php
//activando las sesiones
session_start();
//conexion a la base de datos
include_once("../php/crearConexion.php");
require_once("../dompdf/dompdf_config.inc.php");
include_once("../php/clases/CSlogan.php");

$actualSlogan=new CSlogan();
$contendioSlogan=stripslashes($actualSlogan->valorBandera());
	/*echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";*/
	
//genrando arreglos con los datos enviados por POST
foreach($_REQUEST as $indice => $contenido)
	{
		if($indice!="PHPSESSID")
		{
			
			if(substr($indice,0,6)=="equipo")
			{
				//arreglo para todos los equipos
				$equipo[]=$contenido;
			}
			else if(substr($indice,0,9)=="ubicacion")
			{
				//arreglo para todos los motivos
				$ubicacion[]=$contenido;
			}
			else if($indice=="empleado")
			{
				//nombre de autorizacion
				$empleado=$contenido;
			}
			else if($indice=="depto")
			{
				//nombre de autorizacion
				$depto=$contenido;
			}
		}
	}
	

	
//obteniendo nombre completo del usuario del sistema
$sqlUser="SELECT usuario.nom_usuario,usuario.ap_patusuario,usuario.ap_matusuario FROM usuario WHERE nickname='".$_SESSION['user']."'";
$rsUser=$mysql->consultas($sqlUser);
$regUser=mysqli_fetch_array($rsUser);
$usuarioSis="";
$usuarioSis.=$regUser['nom_usuario']." ";
$usuarioSis.=$regUser['ap_patusuario']." ";
$usuarioSis.=$regUser['ap_matusuario']." ";
//echo $usuarioSis."<br>";

//obteniedno departamento del empleado
$sqlDepto="SELECT departamento FROM cat_departamento WHERE pk_departamento=".$depto;
$rsDepto=$mysql->consultas($sqlDepto);
$regDepto=mysqli_fetch_array($rsDepto);
$nomDepto=$regDepto['departamento'];
//echo $regDepto['departamento']."<br>";

//obteniendo nombre del empleado
$sqlEmp="SELECT nombre_empleado FROM cat_empleado WHERE pk_empleado=".$empleado;
$rsEmp=$mysql->consultas($sqlEmp);
$regEmp=mysqli_fetch_array($rsEmp);
$nomEmp=$regEmp['nombre_empleado'];
//echo $regEmp['nombre_empleado']."<br>";

//obteniendo fecha del sistema
date_default_timezone_set('UTC'); 
$fecha=date("d-m-Y ");
//echo $fecha."<br>";

//formato de reporte
$codigo='
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../dompdf/www/test/css/print_static.css">
</head>

<body background="../img/fondopdf.jpg" style="background-position: center; background-attachment: fixed; background-repeat:repeat-x; overflow:auto;">
<img src="../img/encabezadopdf2.jpg" width="100%" height="20%">
<center>'.$contendioSlogan.'</center>
<br><br><br>
<div id="content">
  
<div class="page" style="font-size: 7pt">
<table style="width: 100%;" class="header">
	<tr>
		<td><h1 style="text-align: left">Asignaciones de informatica</h1></td>
		<!--<td><h1 style="text-align: right">Codigo:12345 </h1></td>-->
	</tr>
</table>

<table style="width: 100%; font-size: 8pt;">

	<tr>
		<td>Asignado por: <strong>'.$usuarioSis.'</strong></td>
		<td>Responsable de Equipos:<strong>'.$nomEmp.'</strong></td>
		<td>Departamento:<strong>'.$nomDepto.'</strong></td>
		<td>Fecha: <strong>'.$fecha.'</strong></td>
	</tr>

</table>


<table class="change_order_items">

	<tr><td colspan="9"><h2>Equipos asignados:</h2></td></tr>

<tbody>
	<tr>
		<th>Codigo</th>
		<th>No.Serie</th>
		<th>Modelo</th>
		<th>Marca</th>
		<th>Categoria</th>
		<th>Detalle</th>
		<th>Ubicacion</th>
	</tr>';

for($x=0;$x<count($equipo);$x++)
{
	//genrando consulta.
	$sqlBaja="SELECT pk_invDetalle,invgeneral.detalle,invgeneral.modelo,cat_marca.marca,invDetalle.codigoBarra,cat_categoria.categoria,no_Serie FROM invdetalle
			INNER JOIN invgeneral on fk_inventario=pk_inventario
			INNER JOIN cat_categoria on fk_categoria=pk_categoria
			INNER JOIN cat_marca on fk_marca=pk_marca
			WHERE pk_invDetalle=".$equipo[$x];
	$rsBaja=$mysql->consultas($sqlBaja);
	$regBaja=mysqli_fetch_array($rsBaja);	
	
	//obteniendo ubicacion del equipo
	$sqlUbicacion="SELECT ubicacion FROM cat_ubicaciones WHERE pk_ubicacion=".$ubicacion[$x];
	$rsUbicacion=$mysql->consultas($sqlUbicacion);
	$regUbicacion=mysqli_fetch_array($rsUbicacion);
	//formado el cuerpo de la tabla
	
	$codigo.='<tr class="even_row">
		<td style="text-align: center">'.$regBaja['codigoBarra'].'</td>
		<td style="text-align: center">'.$regBaja['no_Serie'].'</td>
		<td style="text-align: center">'.$regBaja['modelo'].'</td>
		<td style="text-align: center">'.$regBaja['marca'].'</td>
		<td style="text-align: center">'.$regBaja['categoria'].'</td>
		<td style="text-align: center">'.$regBaja['detalle'].'</td>
		<td style="text-align: center">'.$regUbicacion['ubicacion'].'</td>
	</tr>';
}
$codigo.='</tbody>

</table>

</div>
<br>
<table width="100%" border="0">
  <tr>
    <td style="text-align: center">__________________________________</td>
    <td style="text-align: center">__________________________________</td>
  </tr>
  <tr>
    <td style="text-align: center">'.$nomEmp.'<br>DEPARTAMENTO '.$nomDepto.'</td>
    <td style="text-align: center">'.$usuarioSis.'<br>DEPARTAMENTO INFORMATICA</td>
  </tr>
</table>
</div>

</body>
</html>';

//echo $codigo;
$codigo=utf8_decode($codigo);
$dompdf=new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit","50M");
$dompdf->render();
$dompdf->stream("Asignacion.pdf");
?>