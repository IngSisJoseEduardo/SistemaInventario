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
	$sql1="SELECT * FROM cat_departamento";
	$departamento=$mysql->consultas($sql1);
	$sql3="SELECT * FROM cat_empleado WHERE pk_empleado=".$id;
	$empleado=$mysql->consultas($sql3);
	
	if(!$user=mysqli_fetch_array($empleado))
	{
		echo 'error';
	}
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#nDepartamento > option[value="<?php echo $user['fk_depto']?>"]').attr('selected', 'selected');
});
</script>
<div marca>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#" class="list-group-item" OnClick="Empleados();">Administrar Empleados</a>
            <a href="asignaciones.php" class="list-group-item">Administrar Asignaciones</a>
            <a href="#" class="list-group-item" OnClick="Departamentos();">Administrar Derpartamentos</a>
            <a href="#" class="list-group-item" OnClick="Ubicaciones();">Administrar Ubicaciones</a>
          </div>
          </div>
</div>
<div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Empleado</h4>
    </div>
<form class="form-horizontal" role="form" action="actualizaDatos.php" method="post">
<div class="panel-body">
<div class="col-md-5">
          <div class="form-group">
            <label>Empleado</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text" id="nEmpleado" name="nEmpleado" class="form-control" placeholder="Empleado" value="<?php echo $user['nombre_empleado']; ?>" required>
            </div>
</div>
</div>
<div class="col-md-6 col-md-offset-1">          
              <div class="form-group">
                <label>Departamento</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
                  <select class="form-control input-sm" id="nDepartamento" name="nDepartamento" Required>
                    <option> </option>
                    <?php 
                        while($rDepartamento=mysqli_fetch_array($departamento))
                        {
                            echo "<option value=".$rDepartamento['pk_departamento'].">".$rDepartamento['departamento']."</option>";
                        }
                    ?>
                  </select>
                </div>
              </div>
    </div>
</div>
<div class="panel-footer"><center>
<input type="hidden" name="pk_empleado" value="<?php echo $id;?>"/>
              <input type="hidden" name="form" value="empleado"/>
<button type="button" class="btn btn-default" id="UCancelar" OnClick="Empleado();">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button></center>
</div>
</form>
</div>