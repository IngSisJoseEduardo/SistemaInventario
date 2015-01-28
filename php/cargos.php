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
	$sql1="SELECT * FROM cat_cargo";
	$cargo=$mysql->consultas($sql1);
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
<div usuarios>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="usuarioA" class="list-group-item">Administrar Usuarios</a>
            <a href="#modalcrearcargo" class="list-group-item" data-toggle="modal">Crear Cargo</a>
          </div>
          </div>
</div>
<div tableusuarios id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Cargo</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rCargo=mysqli_fetch_array($cargo))
				  {
                    $id=$rCargo['pk_cargo'];
					$valor=$rCargo['cargo'];
					echo "<tr>
                      <td>".$rCargo['cargo']."</td>
					  <td><button type='button' class='btn btn-link' id='' OnClick='editar($id,\"cargo\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"cat_cargo\",\"pk_cargo\",\"cargo\");'>
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


    
<div class="modal fade" id="modalcrearcargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Crear Cargo</h4>
</div>
<div class="modal-body">
		  <div class="col-md-12">
          <div class="form-group">
            <label>Cargo</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
              <input type="text" id="nCargo" name="nCargo" class="form-control" placeholder="Cargo" required>
              <input type="hidden" name="form" value="cargo"/>
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