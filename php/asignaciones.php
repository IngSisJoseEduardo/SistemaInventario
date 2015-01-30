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
?>
<script src="../js/jquery.js"></script>
            <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('#datatables').dataTable({
                    "sPaginationType":"full_numbers",
                    "aaSorting":[[2, "desc"]],
                    "bJQueryUI":true
                });
            })
            
        </script>
<!-- Latest compiled and minified JavaScript -->
<script src="../js/bootstrap.min.js"></script>
<script src="../js/misfunciones.js"></script>
<script src="../js/jqueryT.js" type="text/javascript"></script>
<script src="../js/jquery.dataTablesT.js" type="text/javascript"></script>
<script>
    $('#modaldetalleasignacion').modal(opciones)
    $('#modaldetalleasignacion').modal({
    keyboard: false
    })
</script>
<script type="text/javascript" src="../js/ajax.js"></script>
<?php

	include_once 'crearConexion.php';
	$sqlA="SELECT * FROM cat_departamento";
	$departamentos=$mysql->consultas($sqlA);
	$sql1="SELECT pk_asigancion,codigoAsignacion,cantidadEquipos,cat_departamento.departamento,cat_empleado.nombre_empleado FROM asignacion 
			INNER JOIN cat_departamento ON fk_departamento=pk_departamento
			INNER JOIN cat_empleado ON fk_empleadoAsignado=pk_empleado";
	$asignaciones=$mysql->consultas($sql1);	
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
						echo '<li class="active"><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
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
							  <li><a href="SalidaFac"><span class="glyphicon glyphicon glyphicon-file"></span>Financiéros</a></li>';
					}
					else if($regPrivilegios['tipo']=="INVENTARIOS")
					{
						echo '<li class="active"><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
								<li class="dropdown">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
								  <ul class="dropdown-menu">
									<li><a href="inventG">Inventario General</a></li>
									<li><a href="inventD">Inventario Detalle</a></li>
									<li><a href="inventS">Inventario Software</a></li>
									<li><a href="inventB">Inventario Bajas</a></li>
								  </ul>
								</li>
							 <li><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>';
					}
          else if($regPrivilegios['tipo']=="MATERIALES")
          {
            echo '<li class="active"><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
                <li class="dropdown">
                  <a href="#" class="active dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                  <li><a href="inventG">Inventario General</a></li>
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
			?><!--AQUI TERMINA LOS NAVS IMPORTANTES-->
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="salir.php"><?php echo $_SESSION['user'];?>   Salir   <span class="glyphicon glyphicon-off"></span></a></li>
          </ul>
        </div>
    </nav>

    <div id="content" style="margin-top:60px;">

<div asignaciones>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#modalnuevaasignacion" class="list-group-item" data-toggle="modal">Asignar Equipos</a>
            <a href="#modalnuevodepartamento" class="list-group-item" data-toggle="modal">Nuevo Derpartamento</a>
            <a href="#" class="list-group-item" OnClick="Departamentos();">Administrar Derpartamentos</a>
            <a href="#modalnuevoempleado" class="list-group-item" data-toggle="modal">Nuevo Empleado</a>
            <a href="#" class="list-group-item" OnClick="Empleados();">Administrar Empleados</a>
            <a href="#modalnuevaubicacion" class="list-group-item" data-toggle="modal">Nueva Ubicacion</a>
            <a href="#" class="list-group-item" OnClick="Ubicaciones();">Administrar Ubicaciones</a>
          </div>
          </div>
</div>
<div tableasignaciones id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Codigo Asignacion</th>
                      <th>Empleado</th>
                      <th>Departamento</th>
                      <th>Cantidad De Equipos</th>
                      <th>Detalle</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($regAsignaciones=mysqli_fetch_array($asignaciones))
				  {
					$id=$regAsignaciones['pk_asigancion'];
					$valor=$regAsignaciones['asignacion'];
					echo "<tr>
                      <td>".$regAsignaciones['codigoAsignacion']."</td>
					  <td>".$regAsignaciones['nombre_empleado']."</td>
					  <td>".$regAsignaciones['departamento']."</td>
					  <td>".$regAsignaciones['cantidadEquipos']."</td>
					  <td>
						  <button type='button' class='btn btn-link' href='#modaldetalleasignacion' data-toggle='modal' onClick='asignacionDetalle(\"".$regAsignaciones['pk_asigancion']."\");'><span class='glyphicon glyphicon-eye-open'></span></button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"asignacion\",\"pk_asigancion\",\"asignacion\");'>
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
<div class="modal fade" id="modalnuevodepartamento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nuevo Departamento</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Departamento</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <input type="text" id="nDepto" name="nDepartamento" class="form-control" placeholder="Departamento" required>
              <input type="hidden" name="form" value="departamento"/>
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

<div class="modal fade" id="modalnuevoempleado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nuevo Empleado</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Departamento</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <select class="form-control input-sm" name="eDepto" Required>
              <option value=" "> </option>
              <?php 
              while($rDeptos=mysqli_fetch_array($departamentos))
              {
                  echo "<option value=".$rDeptos['pk_departamento'].">".$rDeptos['departamento']."</option>";
              }
              ?>
              </select>
            </div>
            </div>
          </div>
          <div class="col-md-12">
          <div class="form-group">
            <label>Empleado</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text"  name="eNombre" class="form-control" placeholder="Empleado" required>
            </div>
            </div>
          </div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="submit" id="idNuevoEmpleado" name="nuevoEmpleado" class="btn btn-primary">Guardar</button>
<input type="hidden" name="form" value="nuevoempleado"/>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modalnuevaubicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form class="form-horizontal" role="form" action="registraDatos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nueva Ubicacion</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Ubicacion</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
              <input type="text" id="nUbicacion" name="nUbicacion" class="form-control" placeholder="Ubicacion" required>
              <input type="hidden" name="form" value="Ubicacion"/>
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

<div class="modal fade" id="modalnuevaasignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content" id="contenedorM" >
	<form class="form-horizontal" role="form" action="creasig" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nuneva Asignacion</h4>
</div>
<div class="modal-body">
		<div class="col-md-12">
          <div class="form-group">
            <label>Departamento</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
              <select name="depto" class="form-control input-sm" onchange="load(this.value)" required>
              <option> </option>
              <?php 
			  	  mysqli_data_seek($departamentos, 0);
				  while($rDeptos=mysqli_fetch_array($departamentos))
				  {
					  echo "<option value=".$rDeptos['pk_departamento'].">".$rDeptos['departamento']."</option>";
				  }
              ?>
              </select>
            </div>
            </div>
          </div>
          <div class="form-group" id="myDiv">
            
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
<!--
	Prueba uno de modal detalle de la asignacion
-->
<div class="modal fade" id="modaldetalleasignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-backdrop" style="overflow:auto;">
<div class="modal-dialog" style="width:70%;">

<div  class="modal-content"> 
	<div id="ocultar">
    <form class="form-horizontal" role="form" action="quitarEquipos.php" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" OnClick="vaciarDiv();">&times;</button>
<h4 class="modal-title">Equipos Asignados</h4>
    <div id="infoEmpleado">
    	
    </div>
</div>
<div class="modal-body" >
	<div id="asignacionDetalle" style="overflow:auto; height:400px">
    	<table class="table table-striped table-bordered" id="equiposAsignados">
        		
        </table>
    </div>
<div class="modal-footer">
<button type="button" class="btn btn-info" onClick="devoluciones();" >Reporte Devolucion</button>
<button type="button" class="btn btn-default" data-dismiss="modal" onClick="vaciarDiv();">Cancelar</button>
<button type="submit" class="btn btn-danger" id="quitar" disabled >Quitar</button>
</div>
</div>
</form>
	</div>
    
<!--Aqui empieza el  div que muestra los programas-->
<div id="hola">
        
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" OnClick="vaciarDiv();">&times;</button>
		<button type="button" class="btn btn-info" value="equipos" id="equipos" onClick="equipos();">&nbsp;<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;</button><h4 class="modal-title">Software Asignado</h4>
    	<div id="infoPC">
    	
    	</div>
	</div>
	<div class="modal-body">
    <form class="validar_Lista form-horizontal"  role="form" action="quitarProgramas.php" method="post">
		<div id="asignacionDetalle">
    		<table class="table table-striped table-bordered" id="softwarePC">
        		
       		</table>
    	</div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onClick="vaciarDiv();">Cancelar</button>
        <button type="submit" class="btn btn-danger" >Quitar</button>
    </div>
</form>
</div>

<!--Aqui termina el  div que muestra los programas-->

</div><!-- /.modal-content -->


</div><!-- /.modal-dialog -->
</div>
</div><!-- /.modal -->
    </body>
</html>