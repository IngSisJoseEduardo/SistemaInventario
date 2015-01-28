<?php
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 
 	//obtenemos el valor de radio que indicara el nombre del archivo 
	$radio=$_POST['imagen'];
    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];
 
    //comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
    if(!is_dir("temp/")) 
        mkdir("temp/", 0777);
     
    //comprobamos si el archivo ha subido
	if($radio==0)//guardar el archivo con el nombre encabezado.jpg
	{
		if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"temp/encabezado.jpg"))
		{
		   sleep(3);//retrasamos la petición 3 segundos
		   echo $file;//devolvemos el nombre del archivo para pintar la imagen
		}
	}
	else if($radio==1)//guardar el archivo con en el nombre marcaAgua.jpg
	{
		if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"temp/marcaAgua.jpg"))
		{
		   sleep(3);//retrasamos la petición 3 segundos
		   echo $file;//devolvemos el nombre del archivo para pintar la imagen
		}
	}
}else{
    throw new Exception("Error Processing Request", 1);    
}
?>