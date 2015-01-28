<?php
	/*session_start();
	if (!$_SESSION)
	{
		echo 
			'<script language="javascript">
				self.location="../index.php"
			</script>';
	}*/
?>
<?php
	include('crearConexion.php');
	$id=$_REQUEST['id'];
	$sql1="SELECT * FROM cat_ubicaciones WHERE pk_ubicacion=".$id;
	$ubicacion=$mysql->consultas($sql1);
	
	if(!$user=mysqli_fetch_array($ubicacion))
	{
		echo 'error';
	}
?>
<div ubicacion>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#" class="list-group-item" OnClick="Ubicaciones();">Administrar Ubicaciones</a>
            <a href="asignaciones.php" class="list-group-item">Administrar Asignaciones</a>
            <a href="#" class="list-group-item" OnClick="Departamentos();">Administrar Derpartamentos</a>
            <a href="#" class="list-group-item" OnClick="Empleados();">Administrar Empleados</a>
          </div>
          </div>
</div>
<div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Cargo</h4>
    </div>
<form class="form-horizontal" role="form" action="actualizaDatos.php" method="post">
<div class="panel-body">
<div class="col-md-12">
          <div class="form-group">
            <label>Ubicacion</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
              <input type="text" id="nUbicacion" name="nUbicacion" class="form-control" placeholder="Ubicacion" value="<?php echo $user['ubicacion']; ?>" required>
              <input type="hidden" name="pk_ubicacion" value="<?php echo $id;?>"/>
              <input type="hidden" name="form" value="ubicacion"/>
            </div>
</div>
</div>
</div>
<div class="panel-footer"><center>
<button type="button" class="btn btn-default" id="UCancelar" OnClick="Ubicaciones();">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button></center>
</div>
</form>
</div>