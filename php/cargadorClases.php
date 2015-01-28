<?PHP
	function mi_autocargador($class_name) 
	{
    	//Definimos el directorio de nuestra clase y el sufijo
		$file='clases/'.$class_name.'.php';
		
		//limpiamos la cahce para asegurarnos de incluir la ultima version de la clase
		clearstatcache();
		
		//verificamos si existe el archivo y si se puede acceder a el, y lo incluimos
		if(file_exists($file))
		{
			require_once $file;
		}
	}

	spl_autoload_register('mi_autocargador');
?>