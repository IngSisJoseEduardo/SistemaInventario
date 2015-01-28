<?php
	session_start();
	if (!$_SESSION)
	{
		echo 
			'<script language="javascript">
				self.location="../inicio"
			</script>';
	}
	else
	  {
		if($_SESSION['tipoU']=="FINANCIEROS")
		{
			echo 
		  '<script language="javascript">
			self.location="SalidaFac"
		  </script>';
		}
		if($_SESSION['tipoU']=="MATERIALES")
		{
			echo 
		  '<script language="javascript">
			self.location="Factura"
		  </script>';
		}
	  }
	include('crearConexion.php');
	$sql1="SELECT * FROM cat_categoria";
	$categorias=$mysql->consultas($sql1);
	$sql2="SELECT * FROM cat_marca";
	$marcas=$mysql->consultas($sql2);
	$sql3="SELECT pk_inventario,cat_marca.marca,modelo,detalle,cantidad,cat_categoria.categoria,codigoBarra FROM invgeneral
			INNER JOIN cat_marca on fk_marca=pk_marca
			INNER  JOIN cat_categoria on fk_categoria=pk_categoria";
			
	$mysql->insUpdDel("SET lc_time_names = 'es_MX';");
	$Invgeneral=$mysql->consultas($sql3);
	$sql4="SELECT pk_invDetalle,invgeneral.detalle,invgeneral.modelo,cat_marca.marca,invDetalle.codigoBarra,cat_categoria.categoria,no_Serie,cat_estado.estado,usuario.nom_usuario,usuario.ap_patusuario,usuario.ap_matusuario,date_format(invDetalle.fecha_alta, '%d/%M/%Y </br>%r') AS Fecha FROM invdetalle
			INNER JOIN invgeneral on fk_inventario=pk_inventario
			INNER JOIN cat_estado on fk_estado=pk_estado
			INNER JOIN usuario on fk_usuario=pk_usuarios
			INNER  JOIN cat_categoria on fk_categoria=pk_categoria
			INNER  JOIN cat_marca on fk_marca=pk_marca";
	$Invdetalle=$mysql->consultas($sql4);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
  <title>Sistema Inventario</title>
  <link rel="shortcut icon" href="../img/logomenu.png" >

  <script src="../js/jquery.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="../js/bootstrap.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css">


<script src="../js/misfunciones.js"></script>
<script src="../js/cargarForm.js"></script>
<script src="../js/arti.js"></script>
<script type="text/javascript" src="../js/misfunciones.js"></script>
<script type="text/javascript" src="../js/jqueryT.js"></script>
<script type="text/javascript" src="../js/jquery.dataTablesT.js"></script>
        <style type="text/css">
            @import "../css/demo_table_jui.css";
            @import "../themes/smoothness/jquery-ui-1.8.4.custom.css";
        </style>
        
        <style>
            *{
                font-family: arial;
            }
        </style>
</head>
<body background="../img/tiny_grid.png" style="background-attachment: fixed;">
  <nav class="navbar navbar-inverse	 navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="../img/logomenu.png" alt="header" width="20px" height="20px">&nbsp &nbsp Sistema Inventario</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
             <?php
            	$sqlPrivilegios="SELECT tipo FROM usuario 
								INNER JOIN cat_tipousuario ON fk_tipoUsuario=pk_tipoUsuario
								WHERE nickname='".$_SESSION['user']."'";
				$rsPrivilegios=$mysql->consultas($sqlPrivilegios);
				if($regPrivilegios=mysqli_fetch_array($rsPrivilegios))
				{
					if($regPrivilegios['tipo']=="admin")
					{
						echo '<li><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
								<li class="dropdown active">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
								  <ul class="dropdown-menu">
									<li><a href="inventG">Inventario General</a></li>
									<li class="active"><a href="inventD">Inventario Detalle</a></li>
									<li><a href="inventS">Inventario Software</a></li>
									<li><a href="inventB">Inventario Bajas</a></li>
								  </ul>
								</li>
							  <li><a href="usuarioA"><span class="glyphicon glyphicon-user"></span>  Usuarios</a></li>
							  <li><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>
							  <li><a href="Factura"><span class="glyphicon glyphicon-file"></span>Materiáles</a></li>
							  <li><a href="SalidaFac"><span class="glyphicon glyphicon glyphicon-file"></span>Financiéros</a></li>';
					}
					else if($regPrivilegios['tipo']=="INVENTARIOS")
					{
						echo '<li><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
								<li class="dropdown active">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
								  <ul class="dropdown-menu">
									<li><a href="inventG">Inventario General</a></li>
									<li class="active"><a href="inventD">Inventario Detalle</a></li>
									<li><a href="inventS">Inventario Software</a></li>
									<li><a href="inventB">Inventario Bajas</a></li>
								  </ul>
								</li>
							 <li><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>';
					}
				}
			 	else
				{
					$nada="no trae nada";
				}
			?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="salir.php"><?php echo $_SESSION['user'];?>   Salir   <span class="glyphicon glyphicon-off"></span></a></li>
          </ul>
        </div>
    </nav>

    <div id="content" style="margin-top:60px;">
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('#datatables').dataTable({
                    "sPaginationType":"full_numbers",
                    "aaSorting":[[2, "desc"]],
                    "bJQueryUI":true
                });
            })
            
        </script>
<div invgeneral>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <!--<a href="#modalregistroarticulos" class="list-group-item" data-toggle="modal">Registrar Articulos</a>-->
            <a href="#modalnuevacategoria" class="list-group-item" data-toggle="modal">Nueva Categoria</a>
            <a href="#" class="list-group-item" OnClick="Categorias();">Administrar Categorias</a>
            <a href="#modalnuevamarca" class="list-group-item" data-toggle="modal">Nuevo Marca</a>
            <a href="#" class="list-group-item" OnClick="Marcas();">Administrar Marcas</a>
          </div>
</div>
<div tableinventariod id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Tipo articulo</th>
                      <th>No Serie</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>Estado</th>
                      <th>Detalle</th>
                      <th>Usuario que registro</th>
                      <th>Fecha Alta</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rInvdetalle=mysqli_fetch_array($Invdetalle))
				  {
					 if($rInvdetalle['estado']!="BAJA")
					 {
                    $id=$rInvdetalle['pk_invDetalle'];
					$valor=$rInvdetalle['codigoBarra'];
					echo "<tr>
                      <td>".$rInvdetalle['codigoBarra']."</td>
					  <td>".$rInvdetalle['categoria']."</td>
					  <td><div style='width:150px; overflow-x:scroll;'>".$rInvdetalle['no_Serie']."</div></td>
					  <td>".$rInvdetalle['marca']."</td>
					  <td>".$rInvdetalle['modelo']."</td>
					  <td>".$rInvdetalle['estado']."</td>
					  <td>".$rInvdetalle['detalle']."</td>
					  <td>".$rInvdetalle['nom_usuario']."
					  	  ".$rInvdetalle['ap_patusuario']."
					  	  ".$rInvdetalle['ap_matusuario']."
					  </td>
					  <td>".$rInvdetalle['Fecha']."</td>
                      <td><button type='button' class='btn btn-link'  OnClick='editar($id,\"inventariodetalle\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='codigoDetalle(".$rInvdetalle['codigoBarra'].",\"".$rInvdetalle['no_Serie']."\")'>
					  		<span class='glyphicon glyphicon-barcode'></span>
						  </button>
					  </td>
                    </tr>";
					 }
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

<div class="modal fade" id="modalregistroarticulos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" name="datosForm" action="inventR" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Registrar Articulos</h4>
</div>
<div class="modal-body">
         <div class="col-md-12">
          <div class="form-group">
            <label>Codigo</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span>
              <input name="codigoB" id="codigoB" type="text"  class="form-control" placeholder="Codigo" onkeypress="checkKey(event);" required>
            </div>
            </div>
          </div>
         <div class="col-md-12">
          <div class="form-group">
            <label>Categoria</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <select name="categoria" id="categoria" class="form-control input-sm" Required>
              	<option></option>
                <?php
                	while($reg=mysqli_fetch_array($categorias))
					{
						echo "<option value=".$reg['pk_categoria'].">".$reg['categoria']."</option>";
					}
				?>
              </select>
            </div>
            </div>
          </div>
         <div class="col-md-12">
          <div class="form-group">
            <label>Marca</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-registration-mark"></span></span>
              <select name="marca" id="marca" class="form-control input-sm" Required>
              	<option></option>
                <?php
                	while($reg=mysqli_fetch_array($marcas))
					{
						echo "<option value=".$reg['pk_marca'].">".$reg['marca']."</option>";
					}
				?>
              </select>
            </div>
            </div>
          </div>
         <div class="col-md-12">
          <div class="form-group">
            <label>Modelo</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
              <input name="modelo"  id="modelo" type="text"  class="form-control" placeholder="Modelo" required>
            </div>
            </div>
          </div>
         <div class="col-md-12">
          <div class="form-group">
            <label>Detalle</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span></span>
              <textarea name="detalle" id="detalle" class="form-control" placeholder="Detalles"></textarea>
            </div>
            </div>
          </div>
         <div class="col-md-12">
          <div class="form-group">
            <label>Cantidad</label>
            <div class="input-group">
            <span class="input-group-addon">N.</span>
              <input type="number" min="1" name="cantidad"  class="form-control" required>
            </div>
            </div>
          </div>
          <div class="col-md-12">
          <div class="form-group col-md-6">
          <label>Consumible</label><br>
          <div class="radio-inline">
              <label>
                <input type="radio" name="optionsRadios1" id="optionsRadios1" value="1">
                Si
              </label>
            </div>
            <div class="radio-inline">
              <label>
                <input type="radio" name="optionsRadios1" id="optionsRadios1" value="2">
                No
              </label>
            </div>
          </div>
          <div class="form-group">
          <label>Inventario</label><br>
          <div class="radio-inline">
              <label>
                <input type="radio" name="optionsRadios2" id="optionsRadios2" value="1">
                Normal
              </label>
            </div>
            <div class="radio-inline">
              <label>
                <input type="radio" name="optionsRadios2" id="optionsRadios2" value="2">
                Patrimonio
              </label>
            </div>
          </div>
          </div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-primary">Continuar</button>
</div>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    </div>
    </div>
    </body>
</html>