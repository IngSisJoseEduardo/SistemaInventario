<?php
session_start();
if($_SESSION)
{
	header("Location:php/asignaciones.php");
}
?>

<!doctype html>
<html>
<head>
	<link rel="shortcut icon" href="img/logomenu.png" >

    <meta charset="utf-8">
    <title>Sistema Inventario</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/required.css">
    <!--<script src="js/librerias/Modernizr/modernizr-latest.js"></script>-->
	<script src="js/jqueryT.js"></script>
	<script src="js/cookie-plugin.js"></script>
    <script>
	function remember_me(){
	   var c = $("#check");
	   if(c.is(":checked")){
		 var u = $("#username").val();
		 var p = $("#password").val();
		 $.cookie("username", u, { expires: 3650 });
		 $.cookie("password", p, { expires: 3650 });
	   }
	}
	function load_em(){
	   var u = $.cookie("username");
	   var p = $.cookie("password");
	
	   $("#username").val(u);
	   $("#password").val(p);
	}
	</script>
</head>

<body onLoad="load_em()" background="img/index.jpg" style="background-position: center; background-attachment: fixed; background-repeat:no-repeat; background-size:100%;">
	<nav>
    </nav>
    <div style="margin-top:8%; margin-left:38%; background-image:url(img/login.png); padding:10px 100px 10px 100px; max-width:700px; border-radius:20px; box-shadow: 0 0 5px 5px #888;">
    <h2>Sistema Inventario</h2>
        <form class="form-horizontal" role="form" action="php/acceso.php" method="post">
          <div class="form-group">
            <label class="col-lg-2 control-label">Usuario</label>
            <div class="col-lg-10">
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input id="username" type="text" name="Usuario" class="form-control" placeholder="Introduzca Usuario" required>
            </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label">Contraseña</label>
            <div class="col-lg-10">
            <div class="input-group">
           <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input id="password" type="password" name="Pass" class="form-control" placeholder="Introduzca Contraseña" required>
            </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
              <div class="checkbox">
                <label>
                  <input id="check" type="checkbox"> Recordar contraseña
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
              <button onClick="remember_me()" type="submit" class="btn btn-default">Entrar</button>
            </div>
          </div>
        </form>
        </div>
</body>
</html>