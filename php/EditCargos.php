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
	$sql3="SELECT * FROM cat_cargo WHERE pk_cargo=".$id;
	$usuarios=$mysql->consultas($sql3);
	
	if(!$user=mysqli_fetch_array($usuarios))
	{
		echo 'error';
	}
?>
<div usuarios>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="usuarioA" class="list-group-item">Administrar Usuarios</a>
            <a href="#" class="list-group-item" OnClick="Cargos();">Administrar Cargos</a>
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
            <label>Cargo</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
              <input type="text" id="nCargo" name="nCargo" class="form-control" placeholder="Cargo" value="<?php echo $user['cargo']; ?>" required>
              <input type="hidden" name="pk_cargo" value="<?php echo $id;?>"/>
              <input type="hidden" name="form" value="cargo"/>
            </div>
</div>
</div>
</div>
<div class="panel-footer"><center>
<button type="button" class="btn btn-default" id="UCancelar" OnClick="Cargos();">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button></center>
</div>
</form>
</div>