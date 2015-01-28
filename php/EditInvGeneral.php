<?php
	/*session_start();
	if (!$_SESSION)
	{
		echo 
			'<script language="javascript">
				self.location="../index.php"
			</script>';
	}*/
	
	include('crearConexion.php');
	$id=$_REQUEST['id'];
	$sql1="SELECT * FROM cat_categoria";
	$categorias=$mysql->consultas($sql1);
	$sql2="SELECT * FROM cat_marca";
	$marcas=$mysql->consultas($sql2);
	$sql3="SELECT * FROM invgeneral WHERE pk_inventario=".$id;
	$invgeneral=$mysql->consultas($sql3);
	
	$user=mysqli_fetch_array($invgeneral);
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#gCategoria > option[value="<?php echo $user['fk_categoria']?>"]').attr('selected', 'selected');
	$('#gMarca > option[value="<?php echo $user['fk_marca']?>"]').attr('selected', 'selected');
	
});

function Cancelar()
{
  document.location.href="inventG";
}
</script>
<div usuarios>
    	  <div class="col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventariogeneral.php" class="list-group-item">Administrar Inventario General</a>
            <a href="#" class="list-group-item" OnClick="Categorias();">Administrar Categorias</a>
            <a href="#" class="list-group-item" OnClick="Marcas();">Administrar Marcas</a>
          </div>
          </div>
</div>
<div editinvg>
    <div class="col-md-9">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Inventario General</h4>
    </div>
    <form role="form" action="actualizaDatos.php" method="post">
    <div class="panel-body">
  	<div class="col-md-6">
              <div class="form-group">
                <label>Modelo</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
                  <input type="text" id="gModelo" name="gModelo" class="form-control" placeholder="Modelo" value="<?php echo $user['modelo']; ?>" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">
              <div class="form-group">
                <label>Detalle</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span></span>
                  <input type="text" id="gDetalle" name="gDetalle" class="form-control" placeholder="Detalle" value="<?php echo $user['detalle']; ?>" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">
              <div class="form-group">
                <label>Marca</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-registration-mark"></span></span>
                  <select class="form-control input-sm" id="gMarca" name="gMarca"  Required>
                    <option> </option>
                    <?php 
                        while($rMarcas=mysqli_fetch_array($marcas))
                        {
                            echo "<option value=".$rMarcas['pk_marca'].">".$rMarcas['marca']."</option>";
                        }
                    ?>
                  </select>
                </div>
              </div>
    </div>          
    <div class="col-md-6">
              <div class="form-group">
                <label>Categoria</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
                  <select class="form-control input-sm" id="gCategoria" name="gCategoria"  Required>
                    <option> </option>
                    <?php 
                        while($rCategorias=mysqli_fetch_array($categorias))
                        {
                            echo "<option value=".$rCategorias['pk_categoria'].">".$rCategorias['categoria']."</option>";
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
                <input type="hidden" name="pk_invgeneral" value="<?php echo $id;?>"/>
                <input type="hidden" name="form" value="inventariogeneral"/></center>
            </div>
    </form>
    </div>
    </div>
</div>
