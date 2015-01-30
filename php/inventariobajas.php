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
		$sql1="SELECT * FROM cat_autoriza";
		$autoriza=$mysql->consultas($sql1);
		
		$mysql->insUpdDel("SET lc_time_names = 'es_MX';");
		//obteneindo el nombre del usuario del sistema
		$sqlUser="SELECT usuario.nom_usuario,usuario.ap_patusuario,usuario.ap_matusuario FROM usuario WHERE nickname='".$_SESSION['user']."'";
		$rsUser=$mysql->consultas($sqlUser);
		$regUser=mysqli_fetch_array($rsUser);
		$usuarioSis="";
		$usuarioSis.=$regUser['nom_usuario']." ";
		$usuarioSis.=$regUser['ap_patusuario']." ";
		$usuarioSis.=$regUser['ap_matusuario']." ";
		
		//obteniendo todos los equipos dados de  baja
		$sqlBajas="SELECT invdetalle.codigoBarra,cat_categoria.categoria,no_Serie,cat_marca.marca,invgeneral.modelo,invgeneral.detalle,cat_estado.estado,baja.motivo,date_format(baja.fecha_baja, '%d/%M/%Y </br>%r') AS Fecha,cat_autoriza.autoriza FROM invDetalle 
					INNER JOIN invgeneral on fk_inventario=pk_inventario
					INNER JOIN cat_categoria on fk_categoria=pk_categoria
					INNER JOIN cat_marca on fk_marca=pk_marca
					INNER JOIN cat_estado on fk_estado=pk_estado
					INNER JOIN baja on fk_invD=pk_invDetalle
					INNER JOIN cat_autoriza on fk_autoriza=pk_autoriza
					WHERE fk_estado=4";
		$rsBajas=$mysql->consultas($sqlBajas);
		
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
  <nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation">
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
									<li><a href="inventG">Inventario General</a></li>
									<li><a href="inventD">Inventario Detalle</a></li>
									<li><a href="inventS">Inventario Software</a></li>
									<li class="active"><a href="inventB">Inventario Bajas</a></li>
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
									<li><a href="inventD">Inventario Detalle</a></li>
									<li><a href="inventS">Inventario Software</a></li>
									<li class="active"><a href="inventB">Inventario Bajas</a></li>
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
			                  <li ><a href="inventG">Inventario General</a></li>
			                  <li><a href="inventD">Inventario Detalle</a></li>
			                  <li><a href="inventS">Inventario Software</a></li>
			                  <li class="active"><a href="inventB">Inventario Bajas</a></li>
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
<div invbajas>
              <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#" onClick="bajas();" class="list-group-item">Nueva Baja</a>
            <!--<a href="#" onClick="bajasConsumible();" class="list-group-item">Bajas de Consumibles</a>-->
            <a href="#modalnuevoautorizador" class="list-group-item" data-toggle="modal">Nuevo Autorizador</a>
            <a href="#" onClick="autoriza();" class="list-group-item">Administrar Autorizadores</a>
          </div>
</div>
		<div id="contenido" >
            <div tableinventariob id="resultado" >
                    <div class="col-sm-4 col-md-10" >
                        <div class="table-responsive" >
                                <table id="datatables" class="display" >
                                      <thead>
                                            <tr>
                                              <th>Codigo</th>
                                              <th>Tipo articulo</th>
                                              <th>No Serie</th>
                                              <th>Marca</th>
                                              <th>Modelo</th>
                                              <th>Estado</th>
                                              <th>Usuario que dio de baja</th>
                                              <th>Detalle</th>
                                              <th>Motivo</th>
                                              <th>Autorizo</th>
                                              <th>Fecha de baja</th>
                                            </tr>
                                      </thead>
                                      <tbody>
										<?php
                                        	while($regBajas=mysqli_fetch_array($rsBajas))
											{
												echo "<tr>
													  	<td>".$regBajas['codigoBarra']."</td>
														<td>".$regBajas['categoria']."</td>
														<td><div style='width:120px; overflow-x:scroll;'>".$regBajas['no_Serie']."</div></td>
														<td>".$regBajas['marca']."</td>
														<td>".$regBajas['modelo']."</td>
														<td>".$regBajas['estado']."</td>
														<td>".$usuarioSis."</td>
														<td>".$regBajas['detalle']."</td>
														<td>".$regBajas['motivo']."</td>
														<td>".$regBajas['autoriza']."</td>
														<td>".$regBajas['Fecha']."</td>
													  </tr>";
											}
                                        ?>
                                            
                                      </tbody>
                                </table>
                        </div>
                    </div>
            </div>
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
    </body>
</html>

