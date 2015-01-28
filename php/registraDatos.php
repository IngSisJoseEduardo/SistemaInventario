<?php
/*En este script se tine que recibir los datos de todos los formularios, utilizando un 
campo oculto en cada formulario, este script identifica que formulario lo esta solicitando
, y de esta manera ejecutara la accion correpondiente.*/

/*En cada caso los datos seran guardadoas en arrays asociatvos, en los indices seran nombrados 
de acuerdo al nombre del campo, de la tabla correspondiente en la BD.Enseguida se crea un ojeto
de la clase CInsert, mandandole como parametro, el array y el nombre de la tabla donde se guardaran los datos*/
	include_once 'cargadorClases.php';
	include_once 'clases/CEncriptacion.php';
	
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
		
		$registro=new CInsert($datos,'usuario');
		header("Location:../php/usuarioA");

	}
	else if($form=='cargo')
	{
		$datos['cargo']=$_REQUEST['nCargo'];
		$registro=new CInsert($datos,'cat_cargo');
		header("Location:../php/usuarioA");
	}
	else if($form=='departamento')
	{
		$datos['departamento']=$_REQUEST['nDepartamento'];
		$registro=new CInsert($datos,'cat_departamento');
		header("Location:../php/asignarE");
	}
	else if($form=='nuevoempleado')
	{
		$datos['nombre_empleado']=$_REQUEST['eNombre'];
		$datos['fk_depto']=$_REQUEST['eDepto'];
		$registro=new CInsert($datos,'cat_empleado');
		header("Location:../php/asignarE");
	}
	else if($form=='categoria')
	{
		$datos['categoria']=$_REQUEST['nCategoria'];
		$registro=new CInsert($datos,'cat_categoria');
		header("Location:../php/inventG");

	}
	else if($form=='marca')
	{
		$datos['marca']=$_REQUEST['nMarca'];
		$registro=new CInsert($datos,'cat_marca');
		header("Location:../php/inventG");
	}
	else if($form=='software')
	{
		$datos['nombreSoftware']=$_REQUEST['nSoftware'];
		$datos['fk_categoriaSoftware']=$_REQUEST['nCategoria'];
		$registro=new CInsert($datos,'software');
		header("Location:../php/inventS");
	}
	else if($form=='Csoftware')
	{
		$datos['categoriaSoftware']=$_REQUEST['nCategoria'];
		$registro=new CInsert($datos,'categoriasoftware');
		header("Location:../php/inventS");
	}
	else if($form=='autoriza')
	{
		$datos['autoriza']=$_REQUEST['nAutorizador'];
		$registro=new CInsert($datos,'cat_autoriza');
		header("Location:../php/inventB");
	}
	else if($form=='Ubicacion')
	{
		$datos['ubicacion']=$_REQUEST['nUbicacion'];
		$registro=new CInsert($datos,'cat_ubicaciones');
		header("Location:../php/asignarE");
	}
?>