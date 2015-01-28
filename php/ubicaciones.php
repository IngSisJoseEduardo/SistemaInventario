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
	$sql1="SELECT * FROM cat_ubicaciones";
	$ubicacion=$mysql->consultas($sql1);
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
<div ubicacion>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="asignarE" class="list-group-item">Administrar Asignaciones</a>
            <a href="#modalnuevaubicacion" class="list-group-item" data-toggle="modal">Nueva Ubicacion</a>
            <a href="#" class="list-group-item" OnClick="Departamentos();">Administrar Derpartamentos</a>
            <a href="#" class="list-group-item" OnClick="Empleados();">Administrar Empleados</a> 
          </div>
          </div>
</div>
<div tableubicacion id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Ubicacion</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rUbicacion=mysqli_fetch_array($ubicacion))
				  {
                    $id=$rUbicacion['pk_ubicacion'];
					$valor=$rUbicacion['ubicacion'];
					echo "<tr>
                      <td>".$rUbicacion['ubicacion']."</td>
					  <td><button type='button' class='btn btn-link' id='' OnClick='editar($id,\"ubicacion\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"cat_ubicaciones\",\"pk_ubicacion\",\"ubicacion\");'>
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
<div class="modal fade" id="modalnuevaubicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nueva Ubicacion</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Ubicacion</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
              <input type="text" id="nUbicacion" name="nUbicacion" class="form-control" placeholder="Ubicacion" required>
              <input type="hidden" name="form" value="Ubicacion"/>
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