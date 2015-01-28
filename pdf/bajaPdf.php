<?php
session_start();
//incluyendo libbreria de pdf
require_once("../dompdf/dompdf_config.inc.php");
//incluyendo conexion a la bd
include_once("../php/crearConexion.php");
//para obtener el mensaje del slogan
include_once("../php/clases/CSlogan.php");
//creadno objeto de l aclase CSlogan
$contenidoSlogan=new CSlogan("","../php/slogan.txt");
$slogan=stripslashes($contenidoSlogan->contenidoSlogan());

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
			else if(substr($indice,0,6)=="motivo")
			{
				//arreglo para todos los motivos
				$motivo[]=$contenido;
			}
			else if($indice=="autoriza")
			{
				//nombre de autorizacion
				$autoriza=$contenido;
			}
			else if($indice=="foliobaja")
			{
				//nombre de autorizacion
				$foliobaja=$contenido;
			}
		}
	}
	
//obteniendo nombre completo del usuario del sistema
$sqlUser="SELECT usuario.nom_usuario,usuario.ap_patusuario,usuario.ap_matusuario FROM usuario WHERE nickname='".$_SESSION['user']."'";
$rsUser=$mysql->consultas($sqlUser);
$regUser=mysqli_fetch_array($rsUser);
$usuarioSis="";
$usuarioSis.=strtoupper($regUser['nom_usuario'])." ";
$usuarioSis.=strtoupper($regUser['ap_patusuario'])." ";
$usuarioSis.=strtoupper($regUser['ap_matusuario'])." ";
//$usuarioSis="lalo";
//obteniendo fecha del sistema
date_default_timezone_set('UTC'); 
$fecha=date("d-m-Y ");

//consultando el nombre de la persona que autoriza

$sqlAutoriza="SELECT * FROM cat_autoriza WHERE pk_autoriza=".$autoriza;
$rsAutoriza=$mysql->consultas($sqlAutoriza);
$rgAutoriza=mysqli_fetch_array($rsAutoriza);
$nomAutoriza=strtoupper($rgAutoriza['autoriza']);

//codigo del pdf
$codigo='
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../dompdf/www/test/css/print_static.css">
</head>

<body background="../img/fondopdf.jpg" style="background-position: center; background-attachment: fixed; background-repeat:repeat-x; overflow:auto;">
<img src="../img/encabezadopdf2.jpg" width="100%" height="20%">
<center>'.$slogan.'</center>
<br><br><br>
<div id="content">
  
<div class="page" style="font-size: 7pt">
<table style="width: 100%;" class="header">
	<tr>
		<td><h1 style="text-align: left">Bajas de informatica</h1></td><td>Folio: <strong>'.$foliobaja.'</strong></td>
		<!--<td><h1 style="text-align: right">Codigo:12345 </h1></td>-->
	</tr>
</table>

<table style="width: 100%; font-size: 8pt;">

	<tr>
		<td>Dado de baja por: <strong>'.$usuarioSis.'</strong></td>
		<td>Atorizada la baja por:<strong>'.$nomAutoriza.'</strong></td>
		<td>Fecha: <strong>'.$fecha.'</strong></td>
	</tr>

</table>


<table class="change_order_items">

	<tr><td colspan="7"><h2>Equipos dados de baja:</h2></td></tr>

<tbody>
	<tr>
		<th>Codigo</th>
		<th>No.Serie</th>
		<th>Articulo</th>
		<th>Modelo</th>
		<th>Marca</th>
		<th>Detalle</th>
		<th>Motivo</th>
	</tr>';
//Generando tabla con valores de la base de datos que ira en el pdf
for($x=0;$x<count($equipo);$x++)
{
	//genrando consulta.
	$sqlBaja="SELECT pk_invDetalle,invgeneral.detalle,invgeneral.modelo,cat_marca.marca,invDetalle.codigoBarra,cat_categoria.categoria,no_Serie FROM invdetalle
			INNER JOIN invgeneral on fk_inventario=pk_inventario
			INNER  JOIN cat_categoria on fk_categoria=pk_categoria
			INNER  JOIN cat_marca on fk_marca=pk_marca
			WHERE pk_invDetalle=".$equipo[$x];
	//ejecutnado consulta
	$rsBaja=$mysql->consultas($sqlBaja);
	//obteniendo valores de la base de datos
	$regBaja=mysqli_fetch_array($rsBaja);	
	$codigo.='<tr class="even_row">
		<td style="text-align: center">'.$regBaja['codigoBarra'].'</td>
		<td style="text-align: center">'.$regBaja['no_Serie'].'</td>
		<td style="text-align: center">'.$regBaja['categoria'].'</td>
		<td style="text-align: center">'.$regBaja['modelo'].'</td>
		<td style="text-align: center">'.$regBaja['marca'].'</td>
		<td style="text-align: center">'.$regBaja['detalle'].'</td>
		<td style="text-align: center">'.$motivo[$x].'</td>
	</tr>';
}
//continucaion del codigo de pdf
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
    <td style="text-align: center">'.$nomAutoriza.'<br>Recursos Materiales</td>
    <td style="text-align: center">'.$usuarioSis.'<br>Departamento Informatica</td>
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
$dompdf->stream("Bajas.pdf");
?>