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
    if($_SESSION['tipoU']=="MATERIALES")
    {
        echo 
      '<script language="javascript">
        self.location="Factura"
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
<!-- Latest compiled and minified JavaScript -->
<script src="../js/misfunciones.js"></script>
<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">
<script src="../js/jquery.dataTables2.js"></script>
<script src="../js/dataTables.bootstrap.js"></script>
<script src="../js/refrescarTabla.js"></script>
<script src="../js/tab.js"></script>
<script src="../js/number.js"></script>
<script src="../js/timer.js"></script>
<script src="../js/tablasQuery.js"></script>

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
							  <li><a href="Factura"><span class="glyphicon glyphicon-file"></span>Materiáles</a></li>
							  <li class="active"><a href="SalidaFac"><span class="glyphicon glyphicon glyphicon-file"></span>Financiéros</a></li>';
					}
					else if($regPrivilegios['tipo']=="FINANCIEROS")
					{
						echo '<li class="active"><a href="SalidaFac"><span class="glyphicon glyphicon glyphicon-file"></span>Financieros</a></li>';
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
                <a href="#" class="list-group-item" id="idSalidas">Salidas</a>
                <a href="#" class="list-group-item" id="idPartidasSal">Partidas</a>
              </div>
              </div>
        </div>
        <div class="col-md-10 col-md-offset-2" id="workspace">
        	<div class="panel panel-default" id="contenedorSalidas">
                          <div class="panel-heading">
                              <label>Salida Facturas</label>
                          </div>
                          <!-- /.panel-heading -->
                          <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#salFacPen" data-toggle="tab" id="idFinPen"><span style="margin-right:5px;"><img src="../img/actualizar.png" width="20" height="20" alt="actualizar" style="cursor:pointer;"></span>Facturas Pendientes</a>
                                </li>
                                <li ><a href="#pagarFac" data-toggle="tab" id="idDarSalida">Dar Salida</a>
                                </li>
                                <li ><a href="#facPagadas" data-toggle="tab" class="facturasPagadas"><span style="margin-right:5px;"><img src="../img/actualizar.png" width="20" height="20" alt="actualizar" style="cursor:pointer;"></span>Facturas Tramitadas</a>
                                </li>
                            </ul>
                            </div>
                          <div class="tab-content">
                          		<div class="tab-pane fade in active" id="salFacPen">
                                	<div class="panel panel-body"><!--contenedor de la tabla Facturas-->
                                           <table class="table table-striped table-bordered table-hover"  id="facPenFin" >
                                                <thead>
                                                    <tr>
                                                        <th>Folio</th>
                                                        <th>Serie</th>
                                                        <th>Proveedor</th>
                                                        <th>Subtotal</th>
                                                        <th>Total</th>
                                                        <th>Fecha</th>
                                                        <th>Operaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                              <!--el contendio se muestra por ajax-->
                                                </tbody>
                                            </table>
                                    </div><!--fin de la tabla facturas-->
                                </div>
                                <div class="tab-pane fade " id="pagarFac">
                                   <div id="alertFinancieros"></div>
                                	 <div class="panel panel-body">
                                      <form role="form" id="formPago" method="post" onsubmit="return false" >
                                    <div class="col-md-6">
                                                  <div class="form-group">
                                                    <label>Partida</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><span class=""></span></span>
                                                      <select class="form-control input-sm" id="idPartida" name="partida"  required>
                                                          <option value="">Seleccióne una Partida...</option>
                                                      </select>
                                                    </div>
                                                  </div>
                                        </div>
                                        <div class="col-md-6">
                                                  <div class="form-group">
                                                    <label>Proyecto</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><span class=""></span></span>
                                                      <input type="text" id="idProyecto" name="proyecto" class="form-control salidaFac" required>
                                                    </div>
                                                  </div>
                                        </div>
                                        <div class="col-md-6">
                                                  <div class="form-group">
                                                    <label>Clave</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><span class=""></span></span>
                                                      <input type="text" id="" name="clave" class="form-control salidaFac" required>
                                                    </div>
                                                  </div>
                                        </div>
                                        <div class="col-md-6">
                                                  <div class="form-group">
                                                    <label>Descripcion</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><span class=""></span></span>
                                                      <textarea class="form-control" id="descripcionPartida" class="form-control" name="desPartida" required></textarea>
                                                    </div>
                                                  </div>
                                        </div>
                                        <div class="col-md-6">
                                                  <div class="form-group">
                                                    <label>Importe</label>
                                                    <div class="input-group">
                                                    <span class="input-group-addon"><span class=""></span></span>
                                                      <input type="text" id="" name="importeSalida" class="form-control salidaFac" required>
                                                      <input type="hidden" name="idFac">
                                                    </div>
                                                  </div>
                                        </div>


                                          <center>
                                                    <button type="button" class="btn btn-default" id="salidaCancelar">Cancelar</button>
                                                    <input type="submit" class="btn btn-primary" value="Guardar">
                                                    <!-- <button type="submit" class="btn btn-primary">Guardar</button> -->
                                            </center> 
                                        </form>
                                   </div>
                                   <div class="panel panel-body">
                                       <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Folio</th>
                                                        <th>Serie</th>
                                                        <th>Proveedor</th>
                                                        <th>Subtotal</th>
                                                        <th>Total</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pagoFac">
                                                              <!--el contendio se muestra por ajax-->
                                                </tbody>
                                            </table>
                                   </div>
                                </div>
                                <div class="tab-pane fade " id="facPagadas">
                                	 <div class="panel panel-body"><!--contenedor de la tabla Facturas-->
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
                                                        <th>Detalles</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                              <!--el contendio se muestra por ajax-->
                                                </tbody>
                                            </table>
                                    </div><!--fin de la tabla facturas-->
                                </div>
                          </div>
          </div>
          <div id="partidas">
              <?php  include 'import/partidas.php'; ?>
          </div>
        </div><!--fin workspace-->
    </div>
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
    </body>
</html>
