<?php 
	include_once 'cargadorClases.php';
	include_once 'clases/CEncriptacion.php';
	
	/*echo "<pre>";
	echo print_r($_REQUEST);
	echo "</pre>";*/
	$form=$_REQUEST['form'];
	//echo $form;
	$encrip=new encriptacion();

	if($form=='usuario')
	{
		$datos['nom_usuario']=$_REQUEST['nombre'];
		$datos['ap_patusuario']=$_REQUEST['apellidoP'];
		$datos['ap_matusuario']=$_REQUEST['apellidoM'];
		$datos['fk_cargo']=$_REQUEST['cargo'];
		$datos['telefono']=$_REQUEST['telefono'];
		$datos['correo']=$_REQUEST['email'];
		$datos['nickname']=$_REQUEST['nickname'];
		$datos['pass']=$encrip->encriptar($_REQUEST['passR'],'whirlpool');
		$datos['fk_tipoUsuario']=$_REQUEST['tipoUsuario'];
		$datos['pk_usuarios']=$_REQUEST['pk'];
		
		$registro=new CUpdate($datos,'usuario');
		header("Location:../php/usuarioA");
	}
	else if($form=='cargo')
	{
		$datos['cargo']=$_REQUEST['nCargo'];
		$datos['pk_cargo']=$_REQUEST['pk_cargo'];
		$registro=new CUpdate($datos,'cat_cargo');
		header("Location:../php/usuarioA");
	}
	else if($form=='categoria')
	{
		$datos['categoria']=$_REQUEST['nCategoria'];
		$datos['pk_categoria']=$_REQUEST['pk_categoria'];
		$registro=new CUpdate($datos,'cat_categoria');
		header("Location:../php/inventG");
	}
	else if($form=='marca')
	{
		$datos['marca']=$_REQUEST['nMarca'];
		$datos['pk_marca']=$_REQUEST['pk_marca'];
		$registro=new CUpdate($datos,'cat_marca');
		header("Location:../php/inventG");
	}
	else if($form=='departamento')
	{
		$datos['departamento']=$_REQUEST['nDepartamento'];
		$datos['pk_departamento']=$_REQUEST['pk_departamento'];
		$registro=new CUpdate($datos,'cat_departamento');
		header("Location:../php/asignarE");
	}
	else if($form=='empleado')
	{
		$datos['nombre_empleado']=$_REQUEST['nEmpleado'];
		$datos['fk_depto']=$_REQUEST['nDepartamento'];
		$datos['pk_empleado']=$_REQUEST['pk_empleado'];
		$registro=new CUpdate($datos,'cat_empleado');
		header("Location:../php/asignarE");
	}
	else if($form=='categoriaSoftware')
	{
		$datos['categoriaSoftware']=$_REQUEST['nCategoria'];
		$datos['pk_categoriaSoftware']=$_REQUEST['pk_categoriaSoftware'];
		$registro=new CUpdate($datos,'categoriasoftware');
		header("Location:../php/inventS");
	}
	else if($form=='inventariogeneral')
	{
		$datos['modelo']=$_REQUEST['gModelo'];
		$datos['detalle']=$_REQUEST['gDetalle'];
		$datos['fk_marca']=$_REQUEST['gMarca'];
		$datos['fk_categoria']=$_REQUEST['gCategoria'];
		$datos['pk_inventario']=$_REQUEST['pk_invgeneral'];
		$registro=new CUpdate($datos,'invgeneral');
		header("Location:../php/inventG");
	}
	else if($form=='NoSerie')
	{
		$datos['no_Serie']=$_REQUEST['nSerie'];
		$datos['fk_estado']=$_REQUEST['nEstado'];
		$datos['pk_invDetalle']=$_REQUEST['pk_invDetalle'];
		$registro=new CUpdate($datos,'invdetalle');
		header("Location:../php/inventD");
	}
	else if($form=='inventariosoftware')
	{
		$datos['nombreSoftware']=$_REQUEST['eSoftware'];
		$datos['fk_categoriaSoftware']=$_REQUEST['eCategoria'];
		$datos['pk_software']=$_REQUEST['pk_software'];
		$registro=new CUpdate($datos,'software');
		header("Location:../php/inventS");
	}
	else if($form=='autoriza')
	{
		$datos['autoriza']=$_REQUEST['nAutoriza'];
		$datos['pk_autoriza']=$_REQUEST['pk_autoriza'];
		$registro=new CUpdate($datos,'cat_autoriza');
		header("Location:../php/inventB");
	}
	else if($form=='ubicacion')
	{
		$datos['ubicacion']=$_REQUEST['nUbicacion'];
		$datos['pk_ubicacion']=$_REQUEST['pk_ubicacion'];
		$registro=new CUpdate($datos,'cat_ubicaciones');
		header("Location:../php/asignarE");
	}
?>