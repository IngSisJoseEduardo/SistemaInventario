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
	$sql1="SELECT * FROM cat_categoria";
	$categoria=$mysql->consultas($sql1);
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
<div categoria>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="inventG" class="list-group-item">Administrar Inventario General</a>
            <a href="#modalnuevacategoria" class="list-group-item" data-toggle="modal">Crear Categoria</a>
            <a href="#" class="list-group-item" data-toggle="modal" OnClick="Marcas();">Administrar Marca</a>
          </div>
          </div>
</div>
<div tablecategoria id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Categoria</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rCategoria=mysqli_fetch_array($categoria))
				  {
                    $id=$rCategoria['pk_categoria'];
					$valor=$rCategoria['categoria'];
					echo "<tr>
                      <td>".$rCategoria['categoria']."</td>
					  <td><button type='button' class='btn btn-link' id='' OnClick='editar($id,\"categoria\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"cat_categoria\",\"pk_categoria\",\"categoria\");'>
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


    
<div class="modal fade" id="modalnuevacategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nueva Categoria</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Categoria</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <input type="text" id="idNCategoria" name="nCategoria" class="form-control" placeholder="Categoria" required>
            </div>
            </div>
          </div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-primary">Guardar</button>
<input type="hidden" name="form" value="categoria"/>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->