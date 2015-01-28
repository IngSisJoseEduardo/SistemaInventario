<?php
include("../php/crearConexion.php");
require_once("../dompdf/dompdf_config.inc.php");
//incluyendo la clase CSlogan
include_once("../php/clases/CSlogan.php");
//creando Objeto de La clase CSlogan
$oSlogan=new CSlogan("","../php/slogan.txt");
//onteniedno Contenido del Slogan
$tSlogan=stripslashes($oSlogan->contenidoSlogan());


//obteniendo numero del equipo
$equipo=$_REQUEST['equipo'];
//formato de fecha para mexico
$mysql->insUpdDel("SET lc_time_names = 'es_MX';");
//obteniendo informacion de empleado y departamento relacionado a este equipo
$sqlInfoEmp="SELECT cat_departamento.departamento,cat_empleado.nombre_empleado FROM equiposasignados 
				INNER JOIN asignacion ON fk_asigancion=pk_asigancion
				INNER JOIN cat_departamento ON fk_departamento=pk_departamento
				INNER JOIN cat_empleado ON fk_empleadoAsignado=pk_empleado
				WHERE fk_invDetalle=".$equipo;
$rsInoEmp=$mysql->consultas($sqlInfoEmp);
$regInfoEmp=mysqli_fetch_row($rsInoEmp);
$responsable=strtoupper($regInfoEmp[1]);
$departamento=strtoupper($regInfoEmp[0]);
//echo $regInfoEmp[0]."</br>";
//echo $regInfoEmp[1]."</br>";

//obteniendo informacion basica del equipo
$sqlInfoEquipo="SELECT invdetalle.pk_invDetalle,invdetalle.codigoBarra,invdetalle.no_serie,invgeneral.modelo,cat_marca.marca,cat_categoria.categoria,cat_ubicaciones.ubicacion FROM invdetalle 
				INNER JOIN invgeneral ON fk_inventario=pk_inventario
				INNER JOIN cat_marca ON fk_marca=pk_marca
				INNER JOIN cat_categoria ON fk_categoria=pk_categoria
				INNER JOIN equiposasignados ON fk_invDetalle=pk_invDetalle
				INNER JOIN cat_ubicaciones ON fk_ubicacion=pk_ubicacion
				WHERE pk_invDetalle=".$equipo;
$rsInoEquipo=$mysql->consultas($sqlInfoEquipo);
$regInfoEquipo=mysqli_fetch_row($rsInoEquipo);
/*echo $regInfoEquipo[1]."</br>";
echo $regInfoEquipo[2]."</br>";
echo $regInfoEquipo[3]."</br>";
echo $regInfoEquipo[4]."</br>";
echo $regInfoEquipo[5]."</br>";*/



//obteniendo todos los programas intalados a este equipo
$sqlProgramas="SELECT software.nombreSoftware,softwareasignado.serialActivacion,categoriasoftware.categoriaSoftware,date_format(softwareasignado.fechaInstalacion, '%d/%M/%Y </br>%r') AS Fecha FROM equiposasignados
				INNER JOIN softwareasignado ON fk_equiposAsignados=pk_equiposAsignados
				INNER JOIN software ON fk_software=pk_software
				INNER JOIN categoriasoftware ON fk_categoriaSoftware=pk_categoriaSoftware
				WHERE fk_invDetalle=".$equipo;
$rsProgramas=$mysql->consultas($sqlProgramas);

//obteniendo fecha del sistema
date_default_timezone_set('America/Mexico_City'); 
$fecha=date("d-m-Y ");

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
		<td><h1 style="text-align: left">Todos lso programas</h1></td>
		<!--<td><h1 style="text-align: right">Codigo:12345 </h1></td>-->
	</tr>
</table>

<table style="width: 100%; font-size: 8pt;">

	<tr>
		<!--<td>Responsable: <strong></strong></td>-->
		<td>Responsable:<strong>'.$responsable.'</strong></td>
		<td>Departamento:<strong>'.$departamento.'</strong></td>
		<td>Fecha: <strong>'.$fecha.'</strong></td>
	</tr>

</table>


<table class="change_order_items">

	<tr><td colspan="6"><h2>Informacion Del Equipo:</h2></td></tr>

<tbody>
	<tr>
		<th>Codigo</th>
		<th>No.Serie</th>
		<th>Modelo</th>
		<th>Marca</th>
		<th>Categoria</th>
		<th>Ubicacion</th>
	</tr>
	<tr>
		<td>'.$regInfoEquipo[1].'</td>
		<td>'.$regInfoEquipo[2].'</td>
		<td>'.$regInfoEquipo[3].'</td>
		<td>'.$regInfoEquipo[4].'</td>
		<td>'.$regInfoEquipo[5].'</td>
		<td>'.$regInfoEquipo[6].'</td>
	</tr>
</tbody>

</table>
<table class="change_order_items">

	<tr><td colspan="4"><h2>Programas Instalados:</h2></td></tr>

<tbody>
	<tr>
		<th>Programa</th>
		<th>Serial Activacion</th>
		<th>Categoria</th>
		<th>Fecha Instalacion</th>
	</tr>';

while($regProgramas=mysqli_fetch_array($rsProgramas))
{

	//formado el cuerpo de la tabla
	$codigo.='<tr class="even_row">
		<td style="text-align: center">'.$regProgramas['nombreSoftware'].'</td>
		<td style="text-align: center">'.$regProgramas['serialActivacion'].'</td>
		<td style="text-align: center">'.$regProgramas['categoriaSoftware'].'</td>
		<td style="text-align: center">'.$regProgramas['Fecha'].'</td>
	</tr>';
}
$codigo.='</tbody>

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
$dompdf->stream("todosSoftwares.pdf");

?>