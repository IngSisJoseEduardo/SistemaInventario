<?php
	include('crearConexion.php');
	$id=$_REQUEST['id'];
	$sql1="SELECT * FROM cat_autoriza WHERE pk_autoriza=".$id;
	$autoriza=$mysql->consultas($sql1);
	
	if(!$user=mysqli_fetch_array($autoriza))
	{
		echo 'error';
	}
?>
<div autoriza>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventariobajas.php" class="list-group-item">Administrar Bajas</a>
            <a href="#" onClick="autoriza();" class="list-group-item">Administrar Autorizadores</a>
          </div>
          </div>
</div>
<div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Autorizador</h4>
    </div>
<form class="form-horizontal" role="form" action="actualizaDatos.php" method="post">
<div class="panel-body">
<div class="col-md-12">
          <div class="form-group">
            <label>Autorizador</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
              <input type="text" id="nAutoriza" name="nAutoriza" class="form-control" placeholder="Autorizador" value="<?php echo $user['autoriza']; ?>" required>
              <input type="hidden" name="pk_autoriza" value="<?php echo $id;?>"/>
              <input type="hidden" name="form" value="autoriza"/>
            </div>
</div>
</div>
</div>
<div class="panel-footer"><center>
<button type="button" class="btn btn-default" id="UCancelar" OnClick="autoriza();">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button></center>
</div>
</form>
</div>