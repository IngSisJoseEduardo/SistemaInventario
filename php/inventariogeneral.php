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
  		// if($_SESSION['tipoU']=="MATERIALES")
  		// {
  		// 	echo 
  		//   '<script language="javascript">
  		// 	self.location="Factura"
  		//   </script>';
  		// }
	  }
	include('crearConexion.php');
	$sql1="SELECT * FROM cat_categoria";
	$categorias=$mysql->consultas($sql1);
	$sql2="SELECT * FROM cat_marca";
	$marcas=$mysql->consultas($sql2);
	$sql3="SELECT pk_inventario,cat_marca.marca,modelo,detalle,cantidad,cat_categoria.categoria,codigoBarra,catconsumible.estadoConsumible,tipoInventario FROM invgeneral
			INNER JOIN cat_marca on fk_marca=pk_marca
			INNER  JOIN cat_categoria on fk_categoria=pk_categoria
			INNER JOIN catconsumible on fkConsumible=pkConsumible";
	$Invgeneral=$mysql->consultas($sql3);
	
	$sql4="SELECT cantidad,descripcion,pkDetalleFactura FROM detalleFactura
			WHERE fkEstadoInventario=1;";
	$rsPorInventariar=$mysql->consultas($sql4);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
  <title>Sistema Inventario</title>
  <link rel="shortcut icon" href="../img/logomenu.png" >

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css">

<script src="../js/jquery.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="../js/bootstrap.min.js"></script>
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
						echo '<li ><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
								<li class="dropdown active">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
								  <ul class="dropdown-menu">
									<li class="active"><a href="inventG">Inventario General</a></li>
									<li><a href="inventD">Inventario Detalle</a></li>
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
								  <a href="#" class="dropdown-toggle active" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
								  <ul class="dropdown-menu ">
									<li class="active"><a href="inventG">Inventario General</a></li>
									<li><a href="inventD">Inventario Detalle</a></li>
									<li><a href="inventS">Inventario Software</a></li>
									<li><a href="inventB">Inventario Bajas</a></li>
								  </ul>
								</li>
							 <li><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>';
					}
          else if($regPrivilegios['tipo']=="MATERIALES")
          {
            echo '<li><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
                <li class="dropdown">
                  <a href="#" class="active dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                  <li class="active"><a href="inventG">Inventario General</a></li>
                  <li><a href="inventD">Inventario Detalle</a></li>
                  <li><a href="inventS">Inventario Software</a></li>
                  <li><a href="inventB">Inventario Bajas</a></li>
                  </ul>
                </li>
               <li class=""><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>
               <li class=""><a href="Factura"><span class="glyphicon glyphicon-file"></span>Materiáles</a></li>';
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
<div class="navbar" >
          <ul class="nav nav-pills">
            <li class="active"><a >
              Opciones
            </a></li>
            <!--<li><a href="#modalregistroarticulos" data-toggle="modal">Registrar Articulos</a></li>-->
            <li><a href="#modalnuevacategoria"  data-toggle="modal">Nueva Categoria</a></li>
            <li><a href="#"  OnClick="Categorias();">Administrar Categorias</a></li>
            <li><a href="#modalnuevamarca"  data-toggle="modal">Nuevo Marca</a></li>
            <li><a href="#"  OnClick="Marcas();">Administrar Marcas</a></li>
          </ul>
</div>  
    <div  class="row col-lg-12" >
            <div class="col-md-3"><h2 style="margin-top:0px;">Por Registrar</h2></div>
            <div class="col-md-6"><button id="actualizarPendientes" onClick="actualizarinvgeneral();" class="btn btn-info">Actualizar</button></div>
    </div>
<div class="container">            
        <div class="row col-md-12">
                 <div class="col-md-12" style="height:200px; background-color:#FFF; overflow:auto;">
                    <table class="table table-bordered table-responsive table-striped table-hover" >
                        <tr><th>Cantidad</th><th>Descripción</th><th>Registrar</th></tr>
                        <?php
                            while($regPorInventariar=mysqli_fetch_row($rsPorInventariar))
                            {
                                echo "<tr><td>".$regPorInventariar[0]."</td><td>".$regPorInventariar[1]."</td><td><a href='#modalregistroarticulos' data-toggle='modal' onclick='inventariar(".$regPorInventariar[2].",".$regPorInventariar[0].",\"".$regPorInventariar[1]."\");'>Registrar Articulos</a></td></tr>";
                            }
                        ?>
                    </table>
                </div>
		</div>
</div>
<div tableinventariog id="resultado" style="margin-top:10px;">
	<div class="col-sm-4 col-md-12">
    <h2>Registrados</h2>
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Categoria</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>Detalle</th>
                      <th>Cantidad</th>
                      <th>Consumible</th>
                      <th>Inventario</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rInvgeneral=mysqli_fetch_array($Invgeneral))
				  {
                    $id=$rInvgeneral['pk_inventario'];
					$valor=$rInvgeneral['codigoBarra'];
					echo "<tr>
                      <td>".$rInvgeneral['codigoBarra']."</td>
					  <td>".$rInvgeneral['categoria']."</td>
					  <td>".$rInvgeneral['marca']."</td>
					  <td>".$rInvgeneral['modelo']."</td>
					  <td>".$rInvgeneral['detalle']."</td>
					  <td>".$rInvgeneral['cantidad']."</td>
					  <td>".$rInvgeneral['estadoConsumible']."</td>
					  <td>".$rInvgeneral['tipoInventario']."</td>
                    <td><button type='button' class='btn btn-link'  OnClick='editar($id,\"inventariogeneral\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
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
              <input type="number" min="1" name="cantidad" id="cantidadR" class="form-control" required>
            </div>
            </div>
          </div>
          <div class="col-md-12">
          <div class="form-group col-md-6">
          <label>Consumible</label><br>
          <div class="radio-inline">
              <label>
                <input type="radio" name="optionsRadios1" id="optionsRadios1" value="2" required>
                Si
              </label>
            </div>
            <div class="radio-inline">
              <label>
                <input type="radio" name="optionsRadios1" id="optionsRadios1" value="1" required>
                No
              </label>
            </div>
          </div>
          		<div class="form-group">
                <label>Inventario</label>
                <div class="input-group">
                <span class="input-group-addon">Tipo</span>
                  <input type="text"  name="optionsRadios2"  class="form-control" required>
				<input type="hidden" name="detalleFactura"/>
                </div>
                </div>
          </div>
          <input type="hidden" name="xinventariar" id="xinventariar">
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