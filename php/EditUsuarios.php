<?php
	/*session_start();
	if (!$_SESSION)
	{
		echo 
			'<script language="javascript">
				self.location="../index.php"
			</script>';
	}*/
	
	include('crearConexion.php');
	$id=$_REQUEST['id'];
		
	$sql1="SELECT * FROM cat_cargo";
	$cargo=$mysql->consultas($sql1);

	$sql2="SELECT * FROM cat_tipoUsuario";
	$tiposU=$mysql->consultas($sql2);
	
	$sql3="SELECT * FROM usuario WHERE pk_usuarios=".$id;
	$usuarios=$mysql->consultas($sql3);
	
	$user=mysqli_fetch_array($usuarios);
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#uCargo > option[value="<?php echo $user['fk_cargo']?>"]').attr('selected', 'selected');
	$('#uTipoUsuario > option[value="<?php echo $user['fk_tipoUsuario']?>"]').attr('selected', 'selected');
	
});

function Cancelar()
{
  document.location.href="usuarioA";
}
</script>
<div usuarios>
    	  <div class="col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="usuarioA" class="list-group-item">Administrar Usuarios</a>
            <a href="#" class="list-group-item" OnClick="Cargos();">Administrar Cargos</a>
          </div>
          </div>
</div>
<div editusuarios>
<div class="col-md-9">
    <div class="panel panel-primary">
    <div class="panel-heading">
    <h4 class="panel-title">Editar Usuario</h4>
    </div>
    <form role="form" action="actualizaDatos.php" method="post">
    <div class="panel-body">
  	<div class="col-md-6">
              <div class="form-group">
                <label>Nombre</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" id="uNombre" name="nombre" class="form-control" placeholder="Nombre" value="<?php echo $user['nom_usuario']; ?>" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">
              <div class="form-group">
                <label>Apellido Paterno</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" id="uApellidoP" name="apellidoP" class="form-control" placeholder="Apellido Paterno" value="<?php echo $user['ap_patusuario']; ?>" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">
              <div class="form-group">
                <label>Apellido Materno</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" id="uApellidoM" name="apellidoM" class="form-control" placeholder="Apellido Materno" value="<?php echo $user['ap_matusuario']; ?>" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">
              <div class="form-group">
                <label>Telefono</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
                  <input type="text" id="uTelefono" name="telefono" class="form-control" placeholder="Telefono" value="<?php echo $user['telefono']; ?>" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">
              <div class="form-group">
                <label>Correo</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                  <input type="email" id="uEmail" name="email" class="form-control" placeholder="Correo" value="<?php echo $user['correo']; ?>" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">          
              <div class="form-group">
                <label>Nickname</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" id="uNickname" name="nickname" class="form-control" placeholder="Nickname" value="<?php echo $user['nickname']; ?>" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">          
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
        <div class="col-md-6">
              <div class="form-group">
                <label>Cargo</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></span>
                  <select class="form-control input-sm" id="uCargo" name="cargo"  Required>
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
    <div class="col-md-6">
              <div class="form-group">
                <label>Contraseña</label>
                <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" id="uPass" name="pass" class="form-control" placeholder="Contraseña" required>
                </div>
              </div>
    </div>
    <div class="col-md-6">
                <label>Confirmar Contraseña</label>
                <div class="input-group">
               <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" id="uPassR" name="passR" class="form-control" placeholder="Confirmar Contraseña" onblur="confirmarpass();" required/>
                  <input type="hidden" name="form" value="usuario">
                  <input type="hidden" name="pk" value="<?php echo $id?>">
                </div>     
    </div>
    </div>		
            <div class="panel-footer"><center>
    			<button type="button" class="btn btn-default" id="UCancelar" OnClick="Cancelar();">Cancelar</button>
    		    <button type="submit" class="btn btn-primary">Guardar</button></center>	
            </div>
    </form>
    </div>
    </div>
</div>
