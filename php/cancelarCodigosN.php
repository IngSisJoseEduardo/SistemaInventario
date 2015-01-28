<?php

foreach($_REQUEST as $indice => $contenido)
	{
		if($indice!="PHPSESSID")
		{
			
			if(substr($indice,0,6)=="codigo")
			{
				unlink("../images/CB/".$contenido.".png");
			}
		}
	}
?>