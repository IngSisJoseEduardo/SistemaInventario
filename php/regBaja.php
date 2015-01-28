<?php
session_start();
include_once("crearConexion.php");

/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/

//obteneindo datos
foreach($_REQUEST as $indice => $contenido)
	{
		if($indice!="PHPSESSID")
		{
			
			if(substr($indice,0,6)=="equipo")
			{
				//arreglo para todos los equipos
				$equipo[]=$contenido;
			}
			else if(substr($indice,0,6)=="motivo")
			{
				//arreglo para todos los motivos
				$motivo[]=$contenido;
			}
			else if($indice=="autoriza")
			{
				//nombre de autorizacion
				$autoriza=$contenido;
			}
		}
	}
//obteniedo tadot de usuario del sistema
$sqlUser="SELECT pk_usuarios FROM usuario WHERE nickname='".$_SESSION['user']."'";
$rsUser=$mysql->consultas($sqlUser);
$regUser=mysqli_fetch_array($rsUser);
$pkUsuario=$regUser['pk_usuarios'];

//registrando bajas
foreach($equipo as $localidad => $valor)
{
	//obtenidneo cantidad de el inventario general de cada articulo
	$sqlCantidad="SELECT invgeneral.cantidad,invgeneral.pk_inventario FROM invdetalle
					INNER JOIN invgeneral ON fk_inventario=pk_inventario
					where pk_invDetalle=".$valor;
	$rsCantidad=$mysql->consultas($sqlCantidad);
	$regCantidad=mysqli_fetch_array($rsCantidad);
	
	//UPDATE invdetalle SET fk_estado=4 WHERE pk_invDetalle='4';
	//INSERT INTO baja (fk_usuarios,fk_invD,fk_autoriza,motivo) VALUES ('1', '5', '1', 'exploto');
	$sqlB="INSERT INTO baja (fk_usuarios,fk_invD,fk_autoriza,motivo) VALUES (".$pkUsuario.",".$valor.",".$autoriza.", '".$motivo[$localidad]."')";
	$mysql->insUpdDel($sqlB);
	$sqlUB="UPDATE invdetalle SET fk_estado=4 WHERE pk_invDetalle=".$valor;
	$mysql->insUpdDel($sqlUB);
	$sqlUC="UPDATE invgeneral SET cantidad=".($regCantidad['cantidad']-1)." WHERE pk_inventario=".$regCantidad['pk_inventario']."";
	$mysql->insUpddel($sqlUC);
}

//redireccionando despues de guardar y actualizar las bajas
echo 
	'<script language="javascript">
	self.location="inventB"
	</script>';
?>
