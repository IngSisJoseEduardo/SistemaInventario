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
	$sql1="SELECT  pk_software,nombreSoftware,categoriasoftware.categoriaSoftware FROM software
			INNER  JOIN categoriasoftware on fk_categoriaSoftware=pk_categoriaSoftware";
	$software=$mysql->consultas($sql1);
	$sql2="SELECT * FROM categoriasoftware";
	$categoriasoftware=$mysql->consultas($sql2);
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
									<li><a href="inventG">Inventario General</a></li>
									<li><a href="inventD">Inventario Detalle</a></li>
									<li class="active"><a href="inventS">Inventario Software</a></li>
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
						echo '<li ><a href="asignarE"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
								<li class="dropdown active">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
								  <ul class="dropdown-menu">
									<li><a href="inventG">Inventario General</a></li>
									<li><a href="inventD">Inventario Detalle</a></li>
									<li class="active"><a href="inventS">Inventario Software</a></li>
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
                    "aaSorting":[[1, "desc"]],
                    "bJQueryUI":true
                });
            })
            
        </script>
<div invsoftware>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#modalregistrosorftware" class="list-group-item" data-toggle="modal">Registrar Software</a>
            <a href="#modalnuevacategoria" class="list-group-item" data-toggle="modal">Nueva Categoria</a>
            <a href="#" class="list-group-item" data-toggle="modal" OnClick="sCategorias();">Administrar Categorias</a>
          </div>
</div>
<div tableinventarios id="resultado">
	<div class="col-sm-4 col-md-10">
    	<div class="table-responsive">
  			<table id="datatables" class="display">
            	<thead>
                    <tr>
                      <th>Software</th>
                      <th>Categoria</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  while($rSoftware=mysqli_fetch_array($software))
				  {
                    $id=$rSoftware['pk_software'];
					$valor=$rSoftware['nombreSoftware'];
					
					echo "<tr>
                      <td>".$rSoftware['nombreSoftware']."</td>
					  <td>".$rSoftware['categoriaSoftware']."</td>
					  <td><button type='button' class='btn btn-link'  OnClick='editar($id,\"inventariosoftware\")' >
					  		<span class='glyphicon glyphicon-pencil'></span>
						  </button>
						  <button type='button' class='btn btn-link' OnClick='eliminar($id,\"$valor\",\"software\",\"pk_software\",\"software\");'>
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
<div class="modal fade" id="modalregistrosorftware" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <form class="form-horizontal" role="form" action="registraDatos.php" method="post">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Registrar Software</h4>
    </div>
     <div class="modal-body">
              <div class="col-md-12">
              <div class="form-group">
                <label>Software</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-hdd"></span></span>
                  <input type="text" id="iSoftware" name="nSoftware" class="form-control" placeholder="Nombre del Software" required>
                </div>
              </div>
              </div>
              <div class="col-md-12">
              <div class="form-group">
                <label>Categoria</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                  <select class="form-control input-sm" id="iCategoria" name="nCategoria" Required>
                    <option> </option>
                    <?php 
                        while($rCategoriasoftware=mysqli_fetch_array($categoriasoftware))
                        {
                            echo "<option value=".$rCategoriasoftware['pk_categoriaSoftware'].">".$rCategoriasoftware['categoriaSoftware']."</option>";
                        }
                    ?>
                  </select>
                </div>
              </div> 
    </div>     
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" id="UCancelar" onclick="Ucancelar()">Cancelar</button>
    <button type="submit" class="btn btn-primary">Registrar</button>
    <input type="hidden" name="form" value="software"/>
    </div>
    </form>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
    </div>
    </div>
    </body>
</html>