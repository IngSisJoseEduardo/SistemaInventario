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
<?php
	include('crearConexion.php');
	$id=$_REQUEST['id'];
	$sql1="SELECT * FROM categoriasoftware WHERE pk_categoriaSoftware=".$id;
	$categoriasoftware=$mysql->consultas($sql1);
	
	if(!$categoriasoftware=mysqli_fetch_array($categoriasoftware))
	{
		echo 'error';
	}
?>
<div categoria>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventS" class="list-group-item">Administrar Software</a>
            <a href="#" class="list-group-item" OnClick="sCategorias();">Administrar Categorias</a>
          </div>
          </div>
</div>
<div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Categoria</h4>
    </div>
<form class="form-horizontal" role="form" action="actualizaDatos.php" method="post">
<div class="panel-body">
<div class="col-md-12">
          <div class="form-group">
            <label>Categoria</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <input type="text" id="nCategoria" name="nCategoria" class="form-control" placeholder="Categoria" value="<?php echo $categoriasoftware['categoriaSoftware']; ?>" required>
              <input type="hidden" name="pk_categoriaSoftware" value="<?php echo $id;?>"/>
              <input type="hidden" name="form" value="categoriaSoftware"/>
            </div>
</div>
</div>
</div>
<div class="panel-footer"><center>
<button type="button" class="btn btn-default" id="UCancelar" OnClick="sCategorias();">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button></center>
</div>
</form>
</div>