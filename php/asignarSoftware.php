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
  document.location.href="inventariogeneral.php";
}
</script> 
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sistema Inventario</title>
    <link rel="shortcut icon" href="../img/logomenu.png" >

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
</head>
<body onLoad="load_em()" background="../img/tiny_grid.png">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/misfunciones.js"></script>
<script type="text/javascript">
function pulsar(obj)
{ 
    if (!obj.checked) return 
    //elem=document.getElementsByName('chk'); 
    elem=document.getElementsByName('so'); 

	for(i=0;i<elem.length;i++)  
        elem[i].checked=false; 
    obj.checked=true; 
} 	
</script>
<?php 
//incluyendo conexion a labase de datos
include('crearConexion.php');

function limpia_espacios($cadena){
     $cadena = str_replace(' ', '', $cadena);
     return $cadena;
}
//obteniendo la pk de la pc, para hacerla consulta y obtener los datos correspondientes
$pc=$_REQUEST['pc'];
$sql="SELECT invdetalle.codigoBarra, cat_categoria.categoria,invgeneral.modelo,equiposasignados.pk_equiposAsignados FROM invdetalle INNER JOIN invgeneral ON fk_inventario=pk_inventario INNER JOIN cat_categoria ON fk_categoria=pk_categoria INNER JOIN equiposasignados ON fk_invDetalle=pk_invDetalle WHERE pk_invDetalle=".$pc;
$rs=$mysql->consultas($sql);
$reg=mysqli_fetch_array($rs);

?>
<!--creando la interfaz de asignacion de software-->
<div class="panel panel-default" style="margin:25px auto; max-width:60%; box-shadow: 0 0 5px 5px #888;">
<div class="panel-heading"><center><h4>En este apartado usted podra registrar el software con el que contara el equipo, asi como su licencia de activacion</h4></center>
<br>
<?php
//div que mostrara mensaje
//div que contendra la inforamcion de la pc
//echo '<div style="border-bottom:1px solid #04F;"><label>'.$reg["codigoBarra"].'</label><label>'.$reg["categoria"].'</label><label>'.$reg["modelo"].'</label></div>';
echo '<div><table class="table">
		<tr class="active"><th><label>Codigo Barra:</label></th><th><label>Categoria:</label></th><th><label>Modelo:</label></th></tr>
	  	<tr class="warning"><td><label>'.$reg["codigoBarra"].'</label></td><td><label>'.$reg["categoria"].'</label></td><td><label>'.$reg["modelo"].'</label></td></tr>
	  </table></div>';
//creando y llenando arreglo con la categoria de software
$sqlSof="SELECT * FROM categoriasoftware ORDER BY pk_categoriaSoftware;";
$rsSof=$mysql->consultas($sqlSof);
while($regSof=mysqli_fetch_array($rsSof))
{
	$categorias[]=$regSof['categoriaSoftware'];
	$idCategorias[]=$regSof['pk_categoriaSoftware'];
}
/*echo "<pre>";
print_r($categorias);
echo "</pre>";*/
?></div>
<!--Creando formulario para inventariar software de la pc asignada-->
    <div class="panel-body">
    <form action="regInvSoftware.php" method="post" class="validar_Lista">
		  <?php 
          	for($i=0;$i<count($categorias);$i++)
			{
				if(strtolower(limpia_espacios($categorias[$i]))=="sistemaoperativo" | strtolower(limpia_espacios($categorias[$i]))=="so" | strtolower(limpia_espacios($categorias[$i]))=="s.o." | strtolower(limpia_espacios($categorias[$i]))=="s.o" | strtolower(limpia_espacios($categorias[$i]))=="sistema")
				{
					$sqlProgramas="SELECT * FROM software WHERE fk_categoriaSoftware=".$idCategorias[$i];
					$rsProgramas=$mysql->consultas($sqlProgramas);
					
					echo '<div class="col-md-6">';
					echo $categorias[$i];
						echo"<div><ul><table>";
							while($regProgramas=mysqli_fetch_array($rsProgramas))
							{
								echo "<tr>
										<td>
											<li><div class='checkbox'><input type='checkbox' name='so'class='chekboxSO' value='".$regProgramas['pk_software']."'id='so".$regProgramas['pk_software']."' onclick='pulsar(this)'/><label>".$regProgramas['nombreSoftware']."</label></li></div></td'></tr><tr><td id='campo".$regProgramas['pk_software']."'>
										</td>
									  </tr>";
							}
						echo "</table></ul></div>";
					echo "</div>";
					
				}
				else
				{
					$sqlProgramas="SELECT * FROM software WHERE fk_categoriaSoftware=".$idCategorias[$i];
					$rsProgramas=$mysql->consultas($sqlProgramas);
					
					echo '<div class="col-md-6">';
					echo $categorias[$i];
						echo"<div><ul><table>";
							while($regProgramas=mysqli_fetch_array($rsProgramas))
							{
								echo '<tr><td><li><div class="checkbox"><input class="chekboxP" type="checkbox" name="programa'.$regProgramas['pk_software'].'" value="'.$regProgramas['pk_software'].'"/><label>'.$regProgramas['nombreSoftware'].'</label></li></td></tr><tr><td id="campo'.$regProgramas['pk_software'].'"></div></td></tr>';
							}
						echo "</table></ul></div>";
					echo "</div>";
				}
			}
		  ?> 
          </div>
          <center><a class="btn btn-success" onClick="softwareMomento(<?php echo $pc;?>);" >Reporte PDF</a></center><br>
          <div class="panel-footer">
          <input type="hidden" name="pc" value="<?php echo $pc ?>"/>
          <center>
            <a class="btn btn-default" href="asignarE">Cancelar</a>
            <input class="btn btn-primary" type="submit" value="Guardar" disabled/>
          </center>
          </div>
     </form> 
     
<!--hasta aqui termina la creacion del formulario para invetario de software-->
    
</div>
</body>
</html>