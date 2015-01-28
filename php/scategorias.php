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
	$sql1="SELECT * FROM categoriasoftware";
	$categoriasoftware=$mysql->consultas($sql1);
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
<div categoria>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#modalnuevacategoria" class="list-group-item" data-toggle="modal">Nueva Categoria</a>
            <a href="inventS" class="list-group-item">Administrar Software</a>
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
				  while($rCategoriasoftware=mysqli_fetch_array($categoriasoftware))
				  {
                    $id=$rCategoriasoftware['pk_categoriaSoftware'];
					$valor=$rCategoriasoftware['categoriaSoftware'];
					echo "<tr>
                      <td>".$rCategoriasoftware['categoriaSoftware']."</td>
					  <td><button type='button' class='btn btn-link' id='' OnClick='editar($id,\"categoriaSoftware\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"categoriasoftware\",\"pk_categoriaSoftware\",\"categoriaSoftware\");'>
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
                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                  <input type="text" id="iCategoria" name="nCategoria" class="form-control" placeholder="Nueva Categoria de Software" required>
                </div>
              </div>
              </div>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" id="UCancelar" onclick="Ucancelar()">Cancelar</button>
    <button type="submit" class="btn btn-primary">Registrar</button>
    <input type="hidden" name="form" value="Csoftware"/>
    </div>
    </form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->