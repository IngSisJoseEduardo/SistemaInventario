<?php 
	class encriptacion
	{
		public function encriptar($str,$modo='md5')
		{
			//generando el salto aleatorio con la longitud definida
			$salt=substr(uniqid(rand(),true),0,$this->longitud_salt);
			
			if(in_array($modo,hash_algos()))
			{
				//generando el hash del pass junto al salt
				$out=hash($modo,$salt.$str);
				
				return $this->longitud_salt.$out.$salt;
			}
			else
			{	//si el algoritmo no se encuntra en la lista de algoritmos mostrar error
				return 'algoritmo no soportado';
			}
		}
		public function desencriptar($str)
		{
			$arrHash['longitud']=substr($str,0,1);
			$arrHash['hash']=substr($str,1,strlen($str)-($arrHash['longitud']+1));
			$arrHash['salt']=str_replace($arrHash['hash'],'',substr($str,1));
			
			return $arrHash;
		}
		
		private $longitud_salt=5;
	}	
?>