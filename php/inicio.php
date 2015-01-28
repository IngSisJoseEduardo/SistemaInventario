<?php
	session_start();
	if (!$_SESSION)
	{
		echo 
			'<script language="javascript">
				self.location="../index.php"
			</script>';
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
  <title>Sistema Inventario</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css">
<script src="../js/jquery.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="../js/bootstrap.min.js"></script>
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
            <li><a href="asignaciones.php"><span class="glyphicon glyphicon-hand-right"></span>  Asignaciones</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span>  Invientario<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="inventariogeneral.php">Inventario General</a></li>
                <li><a href="inventariodetalle.php">Inventario Detalle</a></li>
                <li><a href="inventariosoftware.php">Inventario Software</a></li>
                <li><a href="inventariobajas.php">Inventario Bajas</a></li>
              </ul>
            </li>
           <li><a href="usuarios.php"><span class="glyphicon glyphicon-user"></span>  Usuarios</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="salir.php"><?php echo $_SESSION['user'];?>   Salir   <span class="glyphicon glyphicon-off"></span></a></li>
          </ul>
        </div>
    </nav>
    <br><br><br><br>
    <div id="content">
    </div>
    </body>
</html>
