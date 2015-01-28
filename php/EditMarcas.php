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
	$sql3="SELECT * FROM cat_marca WHERE pk_marca=".$id;
	$marcas=$mysql->consultas($sql3);
	
	if(!$marcas=mysqli_fetch_array($marcas))
	{
		echo 'error';
	}
?>
<div marca>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventariogeneral.php" class="list-group-item">Administrar Inventario General</a>
            <a href="#" class="list-group-item" data-toggle="modal" OnClick="Marcas();">Administrar Marca</a>
            <a href="#" class="list-group-item" data-toggle="modal" OnClick="Categorias();">Administrar Categorias</a>
          </div>
          </div>
</div>
<div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Marca</h4>
    </div>
<form class="form-horizontal" role="form" action="actualizaDatos.php" method="post">
<div class="panel-body">
<div class="col-md-12">
          <div class="form-group">
            <label>Marca</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-registration-mark"></span></span>
              <input type="text" id="nMarca" name="nMarca" class="form-control" placeholder="Marca" value="<?php echo $marcas['marca']; ?>" required>
              <input type="hidden" name="pk_marca" value="<?php echo $id;?>"/>
              <input type="hidden" name="form" value="marca"/>
            </div>
</div>
</div>
</div>
<div class="panel-footer"><center>
<button type="button" class="btn btn-default" id="UCancelar" OnClick="Marcas();">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button></center>
</div>
</form>
</div>