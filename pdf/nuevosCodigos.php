<?php

	require_once("../dompdf/dompdf_config.inc.php");
	include_once "../php/clases/CCodigoBarra.php";
	/*echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";*/
	foreach($_REQUEST as $indice => $contenido)
	{
		if($indice!="PHPSESSID")
		{
			
			if(substr($indice,0,6)=="codigo")
			{
				$codigos[]=$contenido;
			}
			else if(substr($indice,0,5)=="serie")
			{
				$series[]=$contenido;
			}
		}
	}
$codigo="<div><table>";	
$cbImange=new CCodigoBarra();
foreach($codigos as $localidad => $valor)
{
$cbImange->imagenCB("../images/CB/".$valor,$valor);
$codigo.='<tr><td><label>No. Serie:</label><label>'.$series[$localidad].'</label></td></tr>';
$codigo.='<tr><td><img src="../images/CB/'.$valor.'.png" style="margin:10px;" /></td></tr>';
}
$codigo.="</table></div>";

$codigo=utf8_decode($codigo);
$dompdf=new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit","50M");
$dompdf->render();
$dompdf->stream("codigosNuevos.pdf");
?>