<?php
	include('crearConexion.php');
	$id=$_REQUEST['id'];
	$sql1="SELECT * FROM categoriasoftware";
	$categoriasoftware=$mysql->consultas($sql1);
	$sql2="SELECT * FROM software WHERE pk_software=".$id;
	$software=$mysql->consultas($sql2);
	
	if(!$user=mysqli_fetch_array($software))
	{
		echo 'error';
	}
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#eCategoria > option[value="<?php echo $user['fk_categoriaSoftware']?>"]').attr('selected', 'selected');
});
function Cancelar()
{
  document.location.href="inventS";
}
</script>
<div isoftware>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventS" class="list-group-item">Administrar Software</a>
            <a href="#" class="list-group-item" data-toggle="modal" OnClick="sCategorias();">Administrar Categorias</a>
          </div>
          </div>
</div>
<div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Software</h4>
    </div>
<form class="form-horizontal" role="form" action="actualizaDatos.php" method="post">
<div class="panel-body">
<div class="col-md-5">
          <div class="form-group">
            <label>Software</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
              <input type="text" id="eSoftware" name="eSoftware" class="form-control" placeholder="Software" value="<?php echo $user['nombreSoftware']; ?>" required>
            </div>
</div>
</div>
<div class="col-md-6 col-md-offset-1">         
              <div class="form-group">
                <label>Categoria</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
                  <select class="form-control input-sm" id="eCategoria" name="eCategoria" Required>
                    <option> </option>
                    <?php 
                        while($rCategoriasoftware=mysqli_fetch_array($categoriasoftware))
                        {
                            echo "<option value=".$rCategoriasoftware['pk_categoriaSoftware'].">".$rCategoriasoftware['categoriaSoftware']."</option>";
                        }
                    ?>
                  </select>
                </div>
              </div>
    </div>
    </div>
<div class="panel-footer"><center>
			<button type="button" class="btn btn-default" id="UCancelar" OnClick="Cancelar();">Cancelar</button>
			<button type="submit" class="btn btn-primary">Guardar</button>
			<input type="hidden" name="pk_software" value="<?php echo $id;?>"/>
            <input type="hidden" name="form" value="inventariosoftware"/></center>
</div>
</form>
</div>