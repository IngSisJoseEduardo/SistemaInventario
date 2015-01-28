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
  document.location.href="asignarE";
}
</script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/misfunciones.js"></script>
<?php
	include_once("crearConexion.php");
	/*echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";*/
	
	$numEmpleado=$_REQUEST['empleado'];
	$numDepto=$_REQUEST['depto'];
	
	$query="SELECT pk_empleado,nombre_empleado,cat_departamento.departamento FROM cat_empleado
			INNER JOIN cat_departamento ON fk_depto=pk_departamento
			WHERE pk_empleado=".$numEmpleado;

	$rsAsignacion=$mysql->consultas($query);
	$regAsignacion=mysqli_fetch_array($rsAsignacion);
	$empleado=$regAsignacion['nombre_empleado'];
	$departamento=$regAsignacion['departamento'];
	
?>
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
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body  background="../img/tiny_grid.png">
<div class="panel panel-default" id="container" style="margin:25px auto; max-width:70%; box-shadow: 0 0 5px 5px #888;">
	<div class="panel-heading">
	<form action="asignarR" method="post" onSubmit="return evalaListaArticulos();">
    	<div class="col-md-6"><label>Empleado: <?php echo $empleado;?></label><input type="hidden" name="empleado" value="<?php echo $numEmpleado;?>"/></div>
    	<div class="col-md-6"><label>Departamento: <?php echo $departamento;?></label><input type="hidden" name="depto" value="<?php echo $numDepto;?>"/></div>
        <div class="col-md-6"><label>Folio:</label><div class="input-group"><span class="input-group-addon"><span>N.</span></span><input class="form-control" type="text" name="folioasignacion" id="folioasignacion" /></div></div>
        <div id="agregarArticulos">
        	<div class="col-md-4"><label>Codigo Del Articulo:</label></div><div class="col-md-5"><input class="aenter form-control" type="text" id="agregarProducto" /></div><div class="col-md-1"><button class="btn btn-success" type="button" id="agregar" name="Agregar" onclick="agregarArticulos();"  >&nbsp;<span class="glyphicon glyphicon-plus"></span></button></div>
            </div>
            <br><br>
        	<div class="col-md-12 panel-body" id="containerArticulo" style="overflow:auto;">
            	<table class="table table-striped table-bordered" id="articulos">
                <thead>
                    <tr class="active">
                      <th>Codigo</th>
                      <th>Nom. Serie</th>
                      <th>Modelo</th>
                      <th>Marca</th>
                      <th>Categoria</th>
                      <th>Ubicacion</th>
                      <th>Quitar</th>
                    </tr>
                  </thead>
                </table>
            </div>
            <center><input class="btn btn-info" type="button" id="aReporte" value="Generar Reporte" onClick="nuevaAsignacion();"/></center>
        </div>
	<div class="panel-footer">
    <center>
	<input class="btn btn-default" type="button" value="Cancelar" OnClick="Cancelar();"/>
    <input class="btn btn-primary" type="submit" value="Guardar" disabled />
    </center>
    </div>
    </form>
</div>
</body>
</html>