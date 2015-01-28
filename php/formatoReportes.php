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
	include_once 'crearConexion.php';
	include_once 'clases/CSlogan.php';
	
	$oSlogan=new CSlogan();
	$contenidoSlogan=stripslashes($oSlogan->contenidoSlogan());
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
  <title>Sistema Inventario</title>
  <link rel="shortcut icon" href="../img/logomenu.png" >

<script src="../js/jquery.js"></script>
<script src="../js/jquery.jeditable.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="../js/misfunciones.js"></script>
<script src="../js/bootstrap.file-input.js"></script>
<script src="../js/upload.js"></script>
<script type="text/javascript">

	$(document).ready(function(e) {
        $("#slogan").editable("saveEditable.php",
		{
			name		:	'valor',
			type		:	'textarea',
			cancel		:	'Cancelar',
			submit		:	'Guardar',
			indicator	:	'<img src="../img/indicator.gif" width="16" height="16" alt="cargando">',
			tooltip		:	'Haz clic para cambiar el Slogan...'
			
		});
		$('input[type=file]').bootstrapFileInput();

    });
</script>
<style>

	#slogan
	{
		width:100%;
		height:100px;
	}
	#formato
	{
		width:812.598425197px;
		height:1058.267716535px;
		margin:auto;
		border:2px solid #999;
		background-color:#FFF;
		background-image:url(../img/fondopdf.jpg);
		background-position:center;
		background-repeat:no-repeat;
		box-shadow:5px 5px #999999;
	}
	.messages{
		width:100%;
        float: left;
        font-family: Tahoma, Geneva, sans-serif;
        display: none;
    }
    .info{
        padding: 5px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 15px;
        text-align: center;
    }
    .before{
        padding: 5px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 15px;
        text-align: center;
    }
    .success{
        padding: 5px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 15px;
        text-align: center;
    }
    .error{
        padding: 5px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 10px;
        text-align: center;
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
							  <li class="active"><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>
							  <li><a href="Factura"><span class="glyphicon glyphicon-file"></span>Materiáles</a></li>
							  <li><a href="SalidaFac"><span class="glyphicon glyphicon glyphicon-file"></span>Financiéros</a></li>';
					}
					else if($regPrivilegios['tipo']=="INVENTARIOS")
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
							 <li class="active"><a href="reporteE"><span class="glyphicon glyphicon glyphicon-file"></span> Editar Reportes</a></li>';
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

    <div  ><!--inicio div usuario-->
              <div class="col-sm-4 col-md-2">
              <div class="list-group" style="background-color:#FFF;padding:2px;">
                <a class="list-group-item active">
                  Modificar Imagenes
                </a>
                <div class="messages"></div><br /><br />
                <form enctype="multipart/form-data" class="formulario">
                	<div class="col-md-12"><input name="imagen" type="radio" value="0" checked/>&nbsp; Encabezado</div><br>
        			<div class="col-md-12"><input name="imagen" type="radio" value="1" />&nbsp; Marca Agua</div><br>
                    <div class="col-md-12"><input name="archivo" type="file" id="imagen" data-filename-placement="inside" class="btn btn-default col-md-12"  /></div><br />
                    <div class="col-md-12"><input type="button" value="Subir imagen" id="upload"  class="btn btn-success col-md-12" disabled /></div><br>
                </form>
                <div class="col-md-12"><input type="button" value="Mostrar" id="bMostrar" class="btn btn-info col-md-6" disabled/>
                <input type="button" value="Deshacer" id="bCancelar" class="btn btn-warning col-md-6" disabled/></div><br><br>
                <div class="col-md-12"><input type="button" value="Guardar" id="bGuardar" class="btn btn-primary col-md-12" disabled /></div><br>
                <!--<form enctype="multipart/form-data" class="formulario">
                    <input type="radio" name="img" value="0"  checked/>Encabezado
                	<input type="radio" name="img" value="1"/>Marca Agua
                     <center><input type="file" name="archivo" id="archivo" size="15" />
                   			 <input type="submit" value="Subir archivo" class="btn btn-default"></center>
                </form>-->
              </div>
              </div>
    </div><!--fin div usuario-->
    
    <div id="formato">
    	<div id="encabezado" >
        <center><img src="../img/encabezadopdf2.jpg" width="100%" height="20%"></center>
        </div>
        <div id="sloganContainer">
      		<center>
            	<div div style="max-width:80%; max-height:20%;" id="slogan">
                    <?php echo $contenidoSlogan;?>
                </div>
                <!--"2014, Año de la conmemoración del 150 Aniversario de la Gesta Heroica del 27 de febrero de1984"-->
            </center>
        </div>
    </div>
</div>
</body>
</html>
