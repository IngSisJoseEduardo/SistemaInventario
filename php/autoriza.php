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
	$sql1="SELECT * FROM cat_autoriza";
	$autoriza=$mysql->consultas($sql1);
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
<div autoriza>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventB" class="list-group-item">Administrar Bajas</a>
            <a href="#modalnuevoautorizador" class="list-group-item" data-toggle="modal">Nuevo Autorizador</a>
          </div>
          </div>
</div>
<div tableautoriza id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Autorizantes</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rAutoriza=mysqli_fetch_array($autoriza))
				  {
                    $id=$rAutoriza['pk_autoriza'];
					$valor=$rAutoriza['autoriza'];
					echo "<tr>
                      <td>".$rAutoriza['autoriza']."</td>
					  <td><button type='button' class='btn btn-link' id='' OnClick='editar($id,\"autoriza\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"cat_autoriza\",\"pk_autoriza\",\"autoriza\");'>
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
    <div class="modal fade" id="modalnuevoautorizador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nuevo Autorizador</h4>
</div>
<div class="modal-body">
		  <div class="col-md-12">
          <div class="form-group">
            <label>Autorizador</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-ok"></span></span>
              <input type="text" id="nAutorizador" name="nAutorizador" class="form-control" placeholder="Autorizador" required>
              <input type="hidden" name="form" value="autoriza"/>
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