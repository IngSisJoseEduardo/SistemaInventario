<html>
<head>
<title>pruebas</title>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery-barcode.js"></script>
    
    <script type="text/javascript">
		$(document).ready(function(e)
		{
			$(" .generar").each(function(i){
       			var titulo = $(this).attr("title");
       			$(this).barcode(titulo, "codabar",{barWidth:1.5, barHeight:30});
				//alert("Atributo title del enlace " + i + ": " + titulo);
    		});
			
			//var codigo=$(" .generar").data('codigo');
			//alert(codigo);
			//$(" .generar").barcode(codigo, "codabar"); 
		});
    </script>
</head>
<body>
<!--<input type="button" onclick='$("#bcTarget").barcode("8765432112345678", "codabar",{barWidth:1.5, barHeight:30});' value="codabar"> -->
	<div class="generar" title="98989"  style="margin: auto; width:50%; " ></div>
    <div class="generar" title="7878"  style="margin: auto; width:50%;" ></div>   
       
<?php
	for($x=0;$x<3;$x++)
	{
		echo '<div class="generar" title="123987" style="margin: auto;" ></div>';
	}
	 
?>
</body>
</html>