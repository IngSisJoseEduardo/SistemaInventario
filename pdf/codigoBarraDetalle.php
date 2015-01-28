<?php

/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
require_once("../dompdf/dompdf_config.inc.php");

$codigoBarra=$_REQUEST['codigo'];
$numSerie=$_REQUEST['serie'];

$codigo="
	<table>
		<tr><td>Numero de serie:".$numSerie."</td></tr>
		<tr><td><img src='../images/CB/".$codigoBarra.".png'/></td></tr>
	</table>
";
$codigo=utf8_decode($codigo);
$dompdf=new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit","50M");
$dompdf->render();
$dompdf->stream($codigoBarra.".pdf");
?>