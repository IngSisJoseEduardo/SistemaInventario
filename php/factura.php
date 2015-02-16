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
    if($_SESSION['tipoU']=="INVENTARIOS")
    {
        echo 
      '<script language="javascript">
        self.location="asignarE"
      </script>';
    }
  }
  include_once 'crearConexion.php';
  $mysql->insUpdDel("SET lc_time_names = 'es_MX';");
  $sql2="SELECT * FROM cat_tipoUsuario";
  $tiposU=$mysql->consultas($sql2);
  
  $SQL="SELECT * FROM catproveedor";//CONSULTANDO TODOS LOS PROVEDORES
  $rsProveedores=$mysql->consultas($SQL);//EJECUTANDO LA CONSULTA

  
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
  <title>Sistema Inventario</title>
  <link rel="shortcut icon" href="../img/logomenu.png" >

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.tableTools.css">
<!-- Latest compiled and minified JavaScript -->
<script src="../js/jquery.dataTables2.js"></script>
<script src="../js/dataTables.bootstrap.js"></script>
<script src="../js/refrescarTabla.js"></script>
<script src="../js/misfunciones.js"></script>
<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">
<script src="../js/tab.js"></script>
<script src="../js/number.js"></script>
<script src="../js/timer.js"></script>
<script src="../js/tablasQuery.js"></script>
<script src="../js/modificaciones.js"></script>

</head>
<body background="../img/tiny_grid.png" style="background-attachment: fixed;">
  <nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation" >
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
								<li class="dropdown">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
								  <ul class="dropdown-menu">
									<li><a href="inventG">Inventario General</a></li>
									<li><a href="inventD">Inventario Detalle</a></li>
									<li><a href="inventS">Inventario Software</a></li>
									<li><a href="inventB">Inventario Bajas</a></li>
								  </ul>
								</li>
							  <li><a href="usuarioA"><span class="glyphicon glyphicon-user"></span>  Usuarios</a></li>
							  <li><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>
							  <li class="active"><a href="Factura"><span class="glyphicon glyphicon-file"></span>Materiáles</a></li>
							  <li><a href="SalidaFac"><span class="glyphicon glyphicon glyphicon-file"></span>Financiéros</a></li>';
					}
					else if($regPrivilegios['tipo']=="MATERIALES")
					{
						echo '
            <li><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                  <li><a href="inventG">Inventario General</a></li>
                  <li><a href="inventD">Inventario Detalle</a></li>
                  <li><a href="inventS">Inventario Software</a></li>
                  <li><a href="inventB">Inventario Bajas</a></li>
                  </ul>
                </li>
                <li><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>
                <li class="active"><a href="Factura"><span class="glyphicon glyphicon-file"></span>Materiáles</a></li>
            ';
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
    
    <div id="content" style="margin-top:60px; ">
        <div id="operaciones" ><!--navbar-inverse  navbar-fixed-top-->
              <div class="col-sm-3 col-md-2" style="position:fixed;">
              <div class="list-group">
                <a class="list-group-item active">
                  Opciones
                </a>
                <a href="#" class="list-group-item" id="btnFactura">Factura</a>
                <a href="#" class="list-group-item" id="btnProveedor">Proveedor</a>
                <a href="#" class="list-group-item" id="btnPartida">Partidas</a>
                <a href="#" class="list-group-item" id="btnModificarFac">Modificar Factura</a>
              </div>
              </div>
        </div>
        <div id="workspace">
            <div class="col-md-10 col-md-offset-2"  id="contenedor1">
                  <div class="col-md-12">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              <h4>Proveedor</h4>
                          </div>
                          <!-- /.panel-heading -->
                          <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li ><a href="#nuevoP" data-toggle="tab" id="nuevoPro">Nuevo Proveedor</a>
                                </li>
                                <li class="active"><a href="#administrarP" data-toggle="tab" id="idAdministrarP">Administrar</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            <div id="alertProveedor"></div>
                                <div class="tab-pane fade " id="nuevoP">
                                  <div id="fProveedor" style="padding:1em;"><!--div form-->
                                    <form role="form" action="" onSubmit="return false" id="prove">
                                      <div class="col-md-6"><!--input nombre-->
                                        <div class="form-group">
                                          <label>Nombre</label>
                                          <div class="input-group">
                                            <span class="input-group-addon "><span class="glyphicon glyphicon-shopping-cart"></span></span>
                                            <input type="text"  name="nombrePro" class="form-control provedor" placeholder="Nombre Proveedor" required>
                                          </div>
                                        </div>
                                      </div><!--end input nombre-->
                                      <div class="col-md-6"><!--input RFC-->
                                        <div class="form-group">
                                          <label>R.F.C</label>
                                          <div class="input-group">
                                            <span class="input-group-addon "><span class="glyphicon  glyphicon-registration-mark"></span></span>
                                            <input type="text"  name="rfcPro" class="form-control provedor" placeholder="R.F.C" required>
                                          </div>
                                        </div>
                                      </div><!--end input RFC-->
                                      <div class="col-md-6"><!--input Direccion-->
                                        <div class="form-group">
                                          <label>Dirección</label>
                                          <div class="input-group">
                                            <span class="input-group-addon "><span class="glyphicon glyphicon-home"></span></span>
                                            <input type="text"  name="dirPro" class="form-control provedor" placeholder="Dirección" required>
                                          </div>
                                        </div>
                                      </div><!--end input Direccion-->
                                      <div class="col-md-6"><!--input Telefono-->
                                        <div class="form-group">
                                          <label>Teléfono</label>
                                          <div class="input-group">
                                            <span class="input-group-addon "><span class="glyphicon glyphicon-phone-alt"></span></span>
                                            <input type="text"  name="telPro" class="form-control provedor" placeholder="Teléfono" required>
                                          </div>
                                        </div>
                                      </div><!--end input Telefono-->
                                      <center>
                                        <input type="hidden" name="idPro" />
                                        <input type="hidden" name="tabla" value="catProveedor"/>
                                        <input type="button" value="Cancelar" class="btn btn-danger " id="btnCancelar">
                                        <input type="submit" value="Guardar" class="btn btn-info" id="btnGuardarPro">
                                        <input type="button" value="Actualizar" class="btn btn-info" id="btnActualizar"> 
                                      </center>
                                    </form>
                                    </div><!--end div form-->
                                </div>
                                <div class="tab-pane fade in active" id="administrarP">
                                  <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h5>Proveedores</h5>
                                                </div>
                                                <!-- /.panel-heading -->
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover" id="tablaProveedores">
                                                            <thead>
                                                              <tr>
                                                                  <th>Proveedor</th>
                                                                    <th>R.F.C</th>
                                                                    <th>Direccion</th>
                                                                    <th>Telefono</th>
                                                                    <th>Operaciones</th>
                                                                    <!--<th>Operaciones</th>-->
                                                                </tr>
                                                            </thead>
                                                            <tbody >
                                                              <!--el contendio se muestra por ajax-->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- /.table-responsive -->
                                                    
                                                </div>
                                                <!-- /.panel-body -->
                                            </div>
                                            <!-- /.panel -->
                                        </div>
                                        <!-- /.col-lg-12 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-10 col-md-offset-2"  id="contenedorF">
  				
                  <div class="col-md-12">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              <h4>Facturas</h4>
                          </div>
                          <!-- /.panel-heading -->
                          <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#nuevaF" data-toggle="tab" id="nuevaFac">Nueva Factura</a>
                                </li>
                                <li><a href="#adminFac" data-toggle="tab" id="tabAdminFac"><span style="margin-right:5px;"><img src="../img/actualizar.png" width="20" height="20" alt="actualizar" style="cursor:pointer;"></span>Facturas Pendientes</a>
                                </li>
                                <li><a href="#facPendientes" data-toggle="tab" class="facturasPagadas"><span style="margin-right:5px;"><img src="../img/actualizar.png" width="20" height="20" alt="actualizar" style="cursor:pointer;"></span>Facturas Tramitadas</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                              <div class="tab-pane fade in active" id="nuevaF">
                                <div id="alertSaveFac"></div>
                                   <div class="col-md-12" style="margin-top:1em;">
                                      <div class="panel panel-default">
                                        <div class="panel-body"><!--CUERPO FACTURA-->
                                          <form  role="form" action="" id="nFactura" onsubmit="return false">
                                            <div class="row">
                                              <div class="input-group col-md-6">
                                                <span class="input-group-addon">Tipo</span>
                                                <select name="tipo" id="slTipo" class="input-group form-control" required>
                                                  <option value="">Seleccione un tipo de factura..</option>
                                                  <option value="Factura">Factura</option>
                                                  <option value="Remision">Remision</option>
                                                </select>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="input-group">
                                                    <input type="text" class="form-control" id="partidaA" placeholder="Busque una Partida">
                                                    <span class="input-group-addon"> <input type="button" value="Buscar" id="busquedaPar" ></span>
                                                  </div>
                                              </div>
                                            </div>
                                            <!-- <label for="tipo">Tipo</label>
                                              <select name="tipo" id="slTipo" required>
                                              <option value="">Seleccione un tipo de factura..</option>
                                              <option value="Factura">Factura</option>
                                              <option value="Remision">Remision</option>
                                            </select> -->
                                   <!--        <input type="radio" name="tipo"  value="Factura" checked="true">Factura
                                          <input type="radio" name="tipo"  value="Remision">Nota Remision -->
                                          <input type="hidden" name="usuarioFac" value="<?php echo $_SESSION['id'] ?>">
                                            <div class="panel-body"><!--PANEL DEL SELECT-->
                                              <div class="form-group col-md-6"><!--SELECT PROVEEDOR-->
                                              <div class="form-group input-group">
                                                  <span class="input-group-addon"> &nbsp; N. Folio: &nbsp;</span>
                                                      <input class="form-control" name="folioFac" placeholder="Folio" type="text" id="folioFac" required>
                                              </div>
                                                   <div class="form-group input-group">
                                                       <span class="input-group-addon">&nbsp; N. Serie: &nbsp;</span>
                                                       <input class="form-control" name="serieFac" placeholder="Serie" type="text" id="serieFac">
                                                   </div>
                                                <div class="form-group">
                                                  <div class="input-group input-group">
                                                    <span class="input-group-addon">Proveedor:</span>
                                                    <select name="proFac" class="form-control" id="slPro" required>
                                                        <!--opciones cargadas con ajax-->
                                                    </select>
                                                  </div>
                                                </div>
                                                   <div class="form-group input-group">
                                                       <span class="input-group-addon">&nbsp;Proyecto&nbsp;</span>
                                                       <input class="form-control" name="proyectoFac" placeholder="Proyecto" type="text" id="proyectoFac" >
                                                   </div>
                                                <div class="form-group">
                                                  <div class="input-group input-group">
                                                    <span class="input-group-addon">&nbsp;  Partida  &nbsp;</span>
                                                    <select name="partidaFac[]" class="form-control" id="slPartidaFac2" multiple required readonly>
                                                        <!--opciones cargadas con ajax-->
                                                      <!--   <option value="1">algo</option>
                                                        <option value="2">algo</option>
                                                        <option value="3">algo</option>
                                                        <option value="4">algo</option> -->
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="form-group input-group">
                                                       <span class="input-group-addon">&nbsp; &nbsp; Fecha: &nbsp; </span>
                                                       <input class="form-control" placeholder="AAAA/MM/DD" type="date" name="fechaFac" id="fechaFac" required>
                                                </div>
                                              </div><!--END SELECT PROVEEDOR-->

                                            <div class="panel panel-default col-md-6">
                                                  <div class="panel-body" id="total">
                                                    <div style="margin-top:-1.5%;">
                                                            <h3>Subtotal:$0.00 m/n</h3>
                                                            <h3>Total:$0.00 m/n</h3>
                                                    </div>
                                                  </div>
                                                  <input type="hidden" name="subT">
                                                  <input type="hidden" name="total">
                                            </div>
                                             <div class="row">
                                                         <div class="col-md-2" >
                                                            <input type="number" class="form-control" id="cantRow" min="1">
                                                        </div>
                                                        <div>
                                                          <input type="button" class="btn btn-info " id="btnDetalle"  value="Agregar Detalle">
                                                          <!--<input type="button" class="btn btn-warning" style="margin-top:5%;" value="Calcular Total" id="btnCalcularTotal">-->
                                                          <input type="button" class="btn btn-danger"  value="Cancelar" id="btnCancelarFac">
                                                          <input type="submit" class="btn btn-success"  value="Guardar" id="btnGuardarFac" onSubmit="return False">
                                                        </div>
                                            </div>
                                                <!-- <div class="col-lg-6">
                                                  <label>Agregar deciamles</label>
                                                  <input type="checkbox" name="chceros" id="idchceros"><input type="text" name="ceros" id="idceros"  size="2" value="0" disabled>
                                                </div> -->

                                            </div><!--END PANEL DEL SELECT-->
                                            <div class="panel-body" style="height:300px;overflow-y:scroll;"><!--TABLA DETALLE FACTURA-->
                                                <table class="table table-striped table-bordered table-hover" id="tablaProveedores">
                                                    <thead>
                                                      <tr>
                                                          <th>Cantidad</th>
                                                          <th>Unidad</th>
                                                          <th>Descripción</th>
                                                          <th>Precio Unitario</th>
                                                          <th>IVA</th>
                                                          <th>Importe</th>
                                                          <th>Importe(+IVA)</th>
                                                          <th>Remover</th>
                                                            <!--<th>Operaciones</th>-->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbDetalle">
                                                      <!--contendio cargado via jqery-->
                                                    </tbody>
                                                </table>
                                            </div><!--END TABLA DETALLE FACTURA-->
                                          </form>
                                        </div><!--END CUERPO FACTURA-->
                                      </div>
                                  </div>
                                </div>
                                <div class="tab-pane fade " id="adminFac">
                                	<div class="panel panel-body"><!--contenedor de la tabla Facturas-->
                                           <table class="table table-striped table-bordered table-hover"  id="tbAdminFac" >
                                                <thead>
                                                    <tr>
                                                        <!-- <th></th> -->
                                                        <th>Folio</th>
                                                        <th>Serie</th>
                                                        <th>Proveedor</th>
                                                        <th>Subtotal</th>
                                                        <th>Total</th>
                                                        <th>Tipo</th>
                                                        <th>Fecha</th>
                                                        <th>Detalles</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                              <!--el contendio se muestra por ajax-->
                                                </tbody>
                                            </table>
                                    </div><!--fin de la tabla facturas-->
                                </div><!-- end administrarP-->
                                <div class="tab-pane fade"  id="facPendientes">
                                <div class="panel panel-body"><!--contenedor facturas pagadas materiales-->
                                           <table class="table table-striped table-bordered table-hover"  id="facPagFin" >
                                                <thead>
                                                    <tr>
                                                        <th>Folio</th>
                                                        <th>Serie</th>
                                                        <th>Proveedor</th>
                                                        <th>Subtotal</th>
                                                        <th>Total</th>
                                                        <th>Fecha</th>
                                                        <th>Partida</th>
                                                        <th>Proyecto</th>
                                                        <th>Clave</th>
                                                        <th>Descripcion</th>
                                                        <th>Importe</th>
                                                        <th>Operaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                              <!--el contendio se muestra por ajax-->
                                                </tbody>
                                            </table>
                                    </div><!--fin de la tabla facturas pagadas materiales-->
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                  </div>
             <!-- /.col-lg-12 -->
            </div>
            <div class="col-md-10 col-md-offset-2"  id="contenedorPar">
                <?php  include 'import/partidas.php'; ?>
            </div>

            <div  class="col-md-10 col-md-offset-2" id="contenedorModificarPar">
               <?php include_once "modificarFactura.php"; ?>
            </div>
        </div><!--fin workspace-->

    </div>
    </div>
    <div class="modal fade" id="materialesPenDet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:70%;">
          <div class="modal-content" >
              <div class="modal-header" style="text-align:center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3 class="modal-title">Detalles De Factura</h3>
              <div class="facGral"></div>
              </div>
              <div class="modal-body tablaDetalles">
                   <!--Tabla Cargada por AJAX-->
              </div>
              <div class="modal-footer" style="text-align:center">
              <h3>Detalles De Factura</h3>
              </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--MODAL DE FACTURAS PAGADAS-->
     <div class="modal fade" id="financierosPenDet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:70%;">
          <div class="modal-content" >
              <div class="modal-header" style="text-align:center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3 class="modal-title">Detalles De Factura</h3>
              <div class="facGral"></div>
              </div>
              <div class="modal-body tablaDetalles">
                   <!--Tabla Cargada por AJAX-->
              </div>
              <div class="modal-footer" style="text-align:center">
              <h3>Detalles De Factura</h3>
              </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
     <!--FIN MODAL DE FACTURAS PAGADAS-->
</body>
</html>
