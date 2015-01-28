<?php
session_start();
include_once("../php/crearConexion.php");
require_once("../dompdf/dompdf_config.inc.php");
//inclyendo clase para obtener el slogan
include_once("../php/clases/CSlogan.php");
$oSlogan=new CSlogan("","../php/slogan.txt");
$tSlogan=stripslashes($oSlogan->contenidoSlogan());

/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/

extract($_REQUEST);
//obteniendo nombre completo del usuario del sistema
$sqlUser="SELECT usuario.nom_usuario,usuario.ap_patusuario,usuario.ap_matusuario FROM usuario WHERE nickname='".$_SESSION['user']."'";
$rsUser=$mysql->consultas($sqlUser);
$regUser=mysqli_fetch_array($rsUser);
$usuarioSis="";
$usuarioSis.=strtoupper($regUser['nom_usuario'])." ";
$usuarioSis.=strtoupper($regUser['ap_patusuario'])." ";
$usuarioSis.=strtoupper($regUser['ap_matusuario'])." ";
//echo $usuarioSis."<br>";
//obteniendo empleado y departamento
$sqlInfo="SELECT cat_empleado.nombre_empleado,cat_departamento.departamento FROM equiposasignados
INNER JOIN asignacion ON fk_asigancion=pk_asigancion
INNER JOIN cat_empleado ON fk_empleadoAsignado=pk_empleado
INNER JOIN cat_departamento ON fk_departamento=pk_departamento
WHERE fk_asigancion=".$pkasignacion;
$rsInfo=$mysql->consultas($sqlInfo);
$regInfo=mysqli_fetch_row($rsInfo);
$nomEmp=strtoupper($regInfo[0]);
$nomDepto=strtoupper($regInfo[1]);
/*echo $regInfo[0];
echo "<br>";
echo $regInfo[1];
echo "<br>";*/
//obteniendo fecha del sistema
date_default_timezone_set('America/Mexico_City'); 
$fecha=date("d-m-Y ");
//echo $fecha."<br>";

//generando cuerp del Formato
$codigo='
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../dompdf/www/test/css/print_static.css">
</head>

<body background="../img/fondopdf.jpg" style="background-position: center; background-attachment: fixed; background-repeat:repeat-x; overflow:auto;">
<img src="../img/encabezadopdf2.jpg" width="100%" height="20%">
<center>'.$tSlogan.'</center>
<br><br><br>
<div id="content">
  
<div class="page" style="font-size: 7pt">
<table style="width: 100%;" class="header">
	<tr>
		<td><h1 style="text-align: left">Devolucion de Equipos Informatica</h1></td>
		<!--<td><h1 style="text-align: right">Codigo:12345 </h1></td>-->
	</tr>
</table>

<table style="width: 100%; font-size: 8pt;">

	<tr>
		<td>Recibe: <strong>'.$usuarioSis.'</strong></td>
		<td>Devuelve:<strong>'.$nomEmp.'</strong></td>
		<td>Departamento:<strong>'.$nomDepto.'</strong></td>
		<td>Fecha: <strong>'.$fecha.'</strong></td>
	</tr>

</table>


<table class="change_order_items">

	<tr><td colspan="7"><h2>Equipos asignados:</h2></td></tr>

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

for($x=0;$x<count($equipos);$x++)
{
	//genrando consulta.
	$sqlBaja="SELECT pk_invDetalle,invgeneral.detalle,invgeneral.modelo,cat_marca.marca,invDetalle.codigoBarra,cat_categoria.categoria,no_Serie,cat_ubicaciones.ubicacion FROM invdetalle
			INNER JOIN invgeneral on fk_inventario=pk_inventario
			INNER JOIN cat_categoria on fk_categoria=pk_categoria
			INNER JOIN cat_marca on fk_marca=pk_marca
			INNER JOIN equiposasignados ON fk_invDetalle=pk_invDetalle
			INNER JOIN cat_ubicaciones ON fk_ubicacion=pk_ubicacion
			WHERE pk_invDetalle=".$equipos[$x];
	$rsBaja=$mysql->consultas($sqlBaja);
	$regBaja=mysqli_fetch_array($rsBaja);	

	//formado el cuerpo de la tabla
	
	$codigo.='<tr class="even_row">
		<td style="text-align: center">'.$regBaja['codigoBarra'].'</td>
		<td style="text-align: center">'.$regBaja['no_Serie'].'</td>
		<td style="text-align: center">'.$regBaja['modelo'].'</td>
		<td style="text-align: center">'.$regBaja['marca'].'</td>
		<td style="text-align: center">'.$regBaja['categoria'].'</td>
		<td style="text-align: center">'.$regBaja['detalle'].'</td>
		<td style="text-align: center">'.$regBaja['ubicacion'].'</td>
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
$dompdf->stream("Devoluciones.pdf");
?>