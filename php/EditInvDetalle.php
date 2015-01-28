<?php
	include('crearConexion.php');
	
	$sqlEstado="select * from cat_estado
				WHERE estado!='BAJA' and estado!='ASIGNADO'";
	$rsEstado=$mysql->consultas($sqlEstado);
	
	$id=$_REQUEST['id'];
	$sql1="SELECT * FROM invdetalle WHERE pk_invDetalle=".$id;
	$invDetalle=$mysql->consultas($sql1);
	
	if(!$invDetalle=mysqli_fetch_array($invDetalle))
	{
		echo 'error';
	}
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#nEstado> option[value="<?php echo $invDetalle['fk_estado']?>"]').attr('selected', 'selected');	
});
</script>
<div invderalle>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventG" class="list-group-item">Administrar Inventario General</a>
            <a href="inventD" class="list-group-item">Administrar Inventario Detalle</a>
            <a href="inventS" class="list-group-item">Administrar Software</a>
          </div>
          </div>
</div>
<div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Numero de Serie</h4>
    </div>
<form class="form-horizontal" role="form" action="actualizaDatos.php" method="post">
<div class="panel-body">
<div class="col-md-12">
          <div class="form-group">
            <label>Numero de Serie</label>
            <div class="input-group">
            <span class="input-group-addon">N.</span>
              <input type="text" id="nSerie" name="nSerie" class="form-control" placeholder="Numero de Serie" value="<?php echo $invDetalle['no_Serie']; ?>" required>
              <input type="hidden" name="pk_invDetalle" value="<?php echo $id;?>"/>
            </div>
            <div class="input-group">
            <span class="input-group-addon">Estado</span>
			  <select name="nEstado"class="form-control" id="nEstado">
              <option></option>
              <?php
              	while($regEstado=mysqli_fetch_array($rsEstado))
				{
					if($invDetalle['fk_estado']!=2)
					{
						echo "<option value='".$regEstado['pk_estado']."'>".$regEstado['estado']."</option>";
					}
				}
				if($invDetalle['fk_estado']==2)
				{
					echo "<option value='".$invDetalle['fk_estado']."'>ASIGNADO</option>";
				}
			  ?>
              </select>
            </div>
             <input type="hidden" name="form" value="NoSerie"/>
</div>
</div>
</div>
<div class="panel-footer"><center>
<button type="button" class="btn btn-default" id="UCancelar" OnClick="inventarioDetalles();">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button></center>
</div>
</form>
</div>