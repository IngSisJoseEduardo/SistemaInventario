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
	$sql1="SELECT * FROM cat_departamento";
	$departamento=$mysql->consultas($sql1);
?>
<script src="../js/bootstrap.min.js"></script>

        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('#datatables').dataTable({
                    "sPaginationType":"full_numbers",
                    "aaSorting":[[2, "desc"]],
                    "bJQueryUI":true
                });
            })
            
        </script>
<div departamento>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="asignarE" class="list-group-item">Administrar Asignaciones</a>
            <a href="#modalnuevodepartamento" class="list-group-item" data-toggle="modal">Nuevo Derpartamento</a>
            <a href="#" class="list-group-item" OnClick="Empleados();">Administrar Empleados</a>
            <a href="#" class="list-group-item" OnClick="Ubicaciones();">Administrar Ubicaciones</a>
          </div>
          </div>
</div>
<div tabledepartamento id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Departamento</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rDepartamento=mysqli_fetch_array($departamento))
				  {
                    $id=$rDepartamento['pk_departamento'];
					$valor=$rDepartamento['departamento'];
					echo "<tr>
                      <td>".$rDepartamento['departamento']."</td>
					  <td><button type='button' class='btn btn-link' id='' OnClick='editar($id,\"departamento\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"cat_departamento\",\"pk_departamento\",\"departamento\");'>
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
<div class="modal fade" id="modalnuevodepartamento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nuevo Departamento</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Departamento</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <input type="text" id="nDepto" name="nDepartamento" class="form-control" placeholder="Departamento" required>
              <input type="hidden" name="form" value="departamento"/>
            </div>
            </div>
          </div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->