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
	$sql1="SELECT * FROM cat_marca";
	$marca=$mysql->consultas($sql1);
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
<div marca>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventG" class="list-group-item">Administrar Inventario General</a>
            <a href="#modalnuevamarca" class="list-group-item" data-toggle="modal">Nueva Marca</a>
            <a href="#" class="list-group-item" data-toggle="modal" OnClick="Categorias();">Administrar Categorias</a>
          </div>
          </div>
</div>
<div tablemarca id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Marca</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rMarca=mysqli_fetch_array($marca))
				  {
                    $id=$rMarca['pk_marca'];
					$valor=$rMarca['marca'];
					echo "<tr>
                      <td>".$rMarca['marca']."</td>
					  <td><button type='button' class='btn btn-link' id='' OnClick='editar($id,\"marca\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"cat_marca\",\"pk_marca\",\"marca\");'>
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


    
<div class="modal fade" id="modalnuevamarca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nueva Marca</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Marca</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-registration-mark"></span></span>
              <input type="text" id="idMarca" name="nMarca" class="form-control" placeholder="Marca" required>
            </div>
            </div>
          </div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button>
<input type="hidden" name="form" value="marca"/>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->