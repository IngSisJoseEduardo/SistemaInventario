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
<?PHP 
	include_once 'crearConexion.php';
	$sqlA="SELECT * FROM cat_departamento";
	$departamentos=$mysql->consultas($sqlA);
	$sql1="SELECT pk_empleado,nombre_empleado,cat_departamento.departamento FROM cat_empleado
	INNER JOIN cat_departamento on fk_depto=pk_departamento";
	$empleado=$mysql->consultas($sql1);
?>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('#datatables').dataTable({
                    "sPaginationType":"full_numbers",
                    "aaSorting":[[2, "desc"]],
                    "bJQueryUI":true
                });
            })
            
        </script>
<script src="../js/bootstrap.min.js"></script>
<div empleado>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="asignarE" class="list-group-item">Administrar Asignaciones</a>
            <a href="#modalnuevoempleado" class="list-group-item" data-toggle="modal">Nuevo Empleado</a>
            <a href="#" class="list-group-item" OnClick="Departamentos();">Administrar Departamentos</a>
            <a href="#" class="list-group-item" OnClick="Ubicaciones();">Administrar Ubicaciones</a>
          </div>
          </div>
</div>
<div tableempleado id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Empleados</th>
                      <th>Departamento</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rEmpleado=mysqli_fetch_array($empleado))
				  {
                    $id=$rEmpleado['pk_empleado'];
					$valor=$rEmpleado['nombre_empleado'];
					echo "<tr>
                      <td>".$rEmpleado['nombre_empleado']."</td>
					  <td>".$rEmpleado['departamento']."</td>
					  <td><button type='button' class='btn btn-link' id='' OnClick='editar($id,\"empleado\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"cat_empleado\",\"pk_empleado\",\"empleado\");'>
					  		<span class='glyphicon glyphicon-trash'></span>
						  </button>
					  </td>
                    </tr>";
				  }
				  ?>
                  </tbody>
  			</table>
	</div>
</div>
</div>
<div class="modal fade" id="modalnuevoempleado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nuevo Empleado</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Departamento</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <select class="form-control input-sm" name="eDepto" Required>
              <option value=" "> </option>
              <?php 
              while($rDeptos=mysqli_fetch_array($departamentos))
              {
                  echo "<option value=".$rDeptos['pk_departamento'].">".$rDeptos['departamento']."</option>";
              }
              ?>
              </select>
            </div>
            </div>
          </div>
          <div class="col-md-12">
          <div class="form-group">
            <label>Empleado</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text"  name="eNombre" class="form-control" placeholder="Empleado" required>
            </div>
            </div>
          </div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="submit" id="idNuevoEmpleado" name="nuevoEmpleado" class="btn btn-primary">Guardar</button>
<input type="hidden" name="form" value="nuevoempleado"/>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->