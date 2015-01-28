<?php
	session_start();
	if (!$_SESSION)
	{
		echo 
			'<script language="javascript">
				self.location="../index.php"
			</script>';
	}
?>
<?php
	include('crearConexion.php');
	$id=$_REQUEST['id'];
	$sql3="SELECT * FROM cat_departamento WHERE pk_departamento=".$id;
	$departamentos=$mysql->consultas($sql3);
	
	if(!$departamentos=mysqli_fetch_array($departamentos))
	{
		echo 'error';
	}
?>
<div departamento>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#" class="list-group-item" OnClick="Departamentos();">Administrar Derpartamentos</a>
            <a href="asignaciones.php" class="list-group-item">Administrar Asignaciones</a>
            <a href="#" class="list-group-item" OnClick="Ubicaciones();">Administrar Ubicaciones</a>
            <a href="#" class="list-group-item" OnClick="Empleados();">Administrar Empleados</a>
          </div>
          </div>
</div>
<div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Departamento</h4>
    </div>
<form class="form-horizontal" role="form" action="actualizaDatos.php" method="post">
<div class="panel-body">
<div class="col-md-12">
          <div class="form-group">
            <label>Departamento</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <input type="text" id="nDepartamento" name="nDepartamento" class="form-control" placeholder="Departamento" value="<?php echo $departamentos['departamento']; ?>" required>
              <input type="hidden" name="pk_departamento" value="<?php echo $id;?>"/>
              <input type="hidden" name="form" value="departamento"/>
            </div>
</div>
</div>
</div>
<div class="panel-footer"><center>
<button type="button" class="btn btn-default" id="UCancelar" OnClick="Departamentos();">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button></center>
</div>
</form>
</div>