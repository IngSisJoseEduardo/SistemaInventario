<?php
	session_start();
	if (!$_SESSION)
	{
		echo 
			'<script language="javascript">
				self.location="../inicio"
			</script>';
	}
?>
<script>
  function Cancelar()
  {
	codigos=$("input[name*='codigo']").serialize();
  	//alert(codigos);
	$.ajax({
            type: "POST",
            url: "cancelarCodigosN.php?",
            data:codigos,
            success: function() 
			{            
				  document.location.href="inventG";
            }
			});
  }
</script> 
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sistema Inventario</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/misfunciones.js"></script>
</head>
<body onLoad="load_em()" background="../img/tiny_grid.png">
<div class="panel panel-default" id="container" style="margin:25px auto; max-width:60%; box-shadow: 0 0 5px 5px #888;">
	<div class="panel-heading">
<center><h3>Introduzca el numero de serie de cada producto por favor</h3></center>
	</div>
<br>
<div class="panel-body">
<?php
// recibiendo datos de generales del articulo y guardadndolos en un arreglo asociativo
include_once('crearConexion.php');
$datos['fkInventario']=$_REQUEST['optionsRadios2'];
$datos['fkConsumible']=$_REQUEST['optionsRadios1'];
$datos['fk_marca']=$_REQUEST['marca'];
$datos['modelo']=$_REQUEST['modelo'];
$datos['detalle']=$_REQUEST['detalle'];
$datos['cantidad']=$_REQUEST['cantidad'];
$datos['fk_categoria']=$_REQUEST['categoria'];
$datos['codigoBarra']=$_REQUEST['codigoB'];
$datos['xinventariar']=$_REQUEST['xinventariar'];

//variable para guardar codigos a pdf
$codigos;


//consultando a la base de datos para ver cual es el ultimo numero guardado para el codigo general y si no esta registra uno nuevo
//esta accio se reliza para general los correspondientes codigos de barra si es que existe
$queryCodigoB=$mysql->consultas("SELECT pk_inventario,ultimonumcodigo.ultimoNum FROM invgeneral 
INNER JOIN ultimonumcodigo on fk_invG=pk_inventario
WHERE codigoBarra=".$datos['codigoBarra']);

//generando formulario
echo '<form action="invG.php" method="post">';
//evaluando la consulta si hay datos registrados se generan los codigos con dichos datos y si no se generan nuevos datos
if($reg=mysqli_fetch_array($queryCodigoB))
{
        $contaCantidad=$datos['cantidad'];//para saber cuanto campos crear
        $contaUltimoNo=$reg['ultimoNum'];//para saber de donde empezar el codigo
        $contaCiclo=1;//contador del ciclo
		
		//creando formularios aprtir del ultimo codigo asignaddo
        while($contaCiclo<=$contaCantidad)
        {
                echo '<div class="col-md-6"><div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span><input class="form-control" type="text" name="codigo'.$contaCiclo.'" value="'.$datos['codigoBarra'].++$contaUltimoNo.'" readonly /></div></div><div class="col-md-6"><input class="form-control" type="text" name="serie'.$contaCiclo.'" placeholder="no. serie"/></br></div>';
                $codigos[]=$datos['codigoBarra'].$contaUltimoNo;
				$contaCiclo++;
        }
		echo '<input type="hidden" name="ultimoNum" value="'.$contaUltimoNo.'" />';//enviando ultimo numero generado para su registro
}
else
{
        $contaCantidad=$datos['cantidad'];
        $contaCiclo=1;
		
		//generando formularios apartir de 1
        while($contaCiclo<=$contaCantidad)
        {
                echo '<div class="col-md-6"><div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span><input type="text" class="form-control" name="codigo'.$contaCiclo.'" value="'.$datos['codigoBarra'].$contaCiclo.'" readonly /></div></div><div class="col-md-6"><input class="form-control" type="text" name="serie'.$contaCiclo.'" placeholder="no. serie"/></br></div>';
				$codigos[]=$datos['codigoBarra'].$contaCiclo;
				$contaCiclo++;
        }
				echo '<input type="hidden" name="ultimoNum" value="'.--$contaCiclo.'" />';//enviando ultimo numero generado para su registro
	
}
$codigosS=serialize($codigos);
echo '
		<center>
		<input type="hidden" name="arreglo" value=\''.serialize($datos).'\' />
		<a class="btn btn-info" href=\'#\'  onClick="valoresPDF();" ><span class="glyphicon glyphicon-print"></span> Imprimir Codigos</a>
		</center>
		</div>
		<div class="panel-footer">
		<center>
		<input class="btn btn-default" type="button" value="Cancelar" OnClick="Cancelar();">
		<input class="btn btn-primary" type="submit" value="Registrar" disabled="disabled"/>


		</form>
		</center>
		</div>';
		/*echo "<pre>";
		print_r($codigos);
		echo "</pre>";*/
?>
</div>
</div>
</body>
</html>