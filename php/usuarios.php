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
		if($_SESSION['tipoU']=="FINANCIEROS")
		{
			echo 
		  '<script language="javascript">
			self.location="SalidaFac"
		  </script>';
		}
	  }
 
	include_once 'crearConexion.php';
	$sql1="SELECT * FROM cat_cargo";
	$cargo=$mysql->consultas($sql1);
	$sql2="SELECT * FROM cat_tipoUsuario";
	$tiposU=$mysql->consultas($sql2);
	$mysql->insUpdDel("SET lc_time_names = 'es_MX';");

	$sql3="SELECT  pk_usuarios,nom_usuario,ap_patusuario,ap_matusuario,cat_cargo.cargo,telefono,correo,date_format(fecha_alta, '%d/%M/%Y </br>%r') AS Fecha,nickname,cat_tipoUsuario.tipo FROM usuario
			INNER JOIN cat_cargo on fk_cargo=pk_cargo
			INNER  JOIN cat_tipoUsuario on fk_tipoUsuario=pk_tipoUsuario";
	$Usuarios=$mysql->consultas($sql3);
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
<script src="../js/jqueryT.js" type="text/javascript"></script>
<script src="../js/jquery.dataTablesT.js" type="text/javascript"></script>
        
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
  <nav class="navbar navbar-inverse	 navbar-fixed-top" role="navigation" >
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
			<li class="active"><a href="usuarioA"><span class="glyphicon glyphicon-user"></span>  Usuarios</a></li>
			<li><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>
	        <li><a href="Factura"><span class="glyphicon glyphicon-file"></span>Materiáles</a></li>
			<li><a href="SalidaFac"><span class="glyphicon glyphicon glyphicon-file"></span>Financiéros</a></li>
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
<div usuarios>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#modalcrearusuario" class="list-group-item" data-toggle="modal">Nuevo Usuario</a>
            <a href="#modalcrearcargo" class="list-group-item" data-toggle="modal">Crear Cargo</a>
            <a href="#" class="list-group-item" OnClick="Cargos();">Administrar Cargos</a>
          </div>
          </div>
</div>
<div tableusuarios id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Nickname</th>
                      <th>Tipo</th>
                      <th>Nombre</th>
                      <th>Apellido Pat.</th>
                      <th>Apellido Mat.</th>
                      <th>Cargo</th>
                      <th>Telefono</th>
                      <th>Correo</th>
                      <th>Fecha de Alta</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rUsuarios=mysqli_fetch_array($Usuarios))
				  {
                    $id=$rUsuarios['pk_usuarios'];
					$valor=$rUsuarios['nickname'];
					
					echo "<tr>
                      <td>".$rUsuarios['nickname']."</td>
					  <td>".$rUsuarios['tipo']."</td>
                      <td>".$rUsuarios['nom_usuario']."</td>
                      <td>".$rUsuarios['ap_patusuario']."</td>
                      <td>".$rUsuarios['ap_matusuario']."</td>
					  <td>".$rUsuarios['cargo']."</td>
					  <td>".$rUsuarios['telefono']."</td>
                      <td>".$rUsuarios['correo']."</td>
					  <td>".$rUsuarios['Fecha']."</td>
					  <td><button type='button' class='btn btn-link'  OnClick='editar($id,\"usuario\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>";
						if($rUsuarios['nickname']==$_SESSION['user'])
						{
						}
						else
						{
							echo"  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"usuario\",\"pk_usuarios\",\"usuario\");'>
					  		<span class='glyphicon glyphicon-trash'></span>
						  </button>";
						}
					  "</td>
                    </tr>";
				  }
				  ?>
                  </tbody>
  			</table>
	</div>
</div>
</div>
<div class="modal fade" id="modalcrearusuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <form class="form-horizontal" role="form" action="registraDatos.php" method="post">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Crear Usuario</h4>
    </div>
    <div class="modal-body">
    	<div class="col-md-12">
              <div class="form-group">
                <label>Grado Academico Y Nombre</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" id="uNombre" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Apellido Paterno</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" id="uApellidoP" name="apellidoP" class="form-control" placeholder="Apellido Paterno" required>
                </div>
                </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">

                <label>Apellido Materno</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" id="uApellidoM" name="apellidoM" class="form-control" placeholder="Apellido Materno" required>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Cargo</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
                  <select class="form-control input-sm" id="uCargo" name="cargo" Required>
                    <option> </option>
                    <?php 
                        while($rCargos=mysqli_fetch_array($cargo))
                        {
                            echo "<option value=".$rCargos['pk_cargo'].">".$rCargos['cargo']."</option>";
                        }
                    ?>
                  </select>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Telefono</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
                  <input type="text" id="uTelefono" name="telefono" class="form-control" placeholder="Telefono" required>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Correo</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                  <input type="email" id="uEmail" name="email" class="form-control" placeholder="Correo" required>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Nickname</label><span id="comprobandoNick"></span>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" id="uNickname" name="nickname" class="form-control" placeholder="Nickname" required><span id="comprobandoNick"></span>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Tipo usuario</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
                  <select class="form-control input-sm" id="uTipoUsuario" name="tipoUsuario" Required>
                    <option> </option>
                    <?php 
                        while($rTiposU=mysqli_fetch_array($tiposU))
                        {
                            echo "<option value=".$rTiposU['pk_tipoUsuario'].">".$rTiposU['tipo']."</option>";
                        }
                    ?>
                  </select>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Contraseña</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" id="uPass" name="pass" class="form-control" placeholder="Contraseña" required>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Confirmar Contraseña</label>
                <div class="input-group">
               <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" id="uPassR" name="passR" class="form-control" placeholder="Introduzca Contraseña" onblur="confirmarpass();" required>
                  <input type="hidden" name="form" value="usuario">
    
                </div>
              </div>
              </div>      
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" id="UCancelar" onclick="Ucancelar()">Cancelar</button>
    <button type="submit" class="btn btn-primary">Registrar</button>
    </div>
    </form>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
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
    </div>
    </body>
</html>
