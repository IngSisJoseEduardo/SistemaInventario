<?php
	$opcion=$_POST['opcion'];
	if($opcion==0)
	{
		unlink("../img/encabezadopdf2.jpg");
		if(rename('temp/encabezado.jpg','../img/encabezadopdf2.jpg'))
		{
			$valor=false;
		}

	}
	else if($opcion==1)
	{
		unlink("../img/fondopdf.jpg");
		if(rename('temp/marcaAgua.jpg','../img/fondopdf.jpg'))
		{
			$valor=true;
		}
	}
echo $valor;
?>