<?php
include('crearConexion.php');
//$codigoB=$_GET['getClientId'];
$codigoB=$_GET['getClientId'];
$sql="select modelo, detalle,pk_marca,pk_categoria,cat_marca.marca ,cat_categoria.categoria from invgeneral
inner join cat_marca on fk_marca=pk_marca
inner join cat_categoria on fk_categoria=pk_categoria
 where codigoBarra=".$codigoB;
$rs=$mysql->consultas($sql);


if(isset($rs))
{  
  
  if($inf = mysqli_fetch_array($rs)){
	echo "formObj.categoria.value = '".$inf["pk_categoria"]."';\n";    
    echo "formObj.marca.value = '".$inf["pk_marca"]."';\n";  
	echo "formObj.modelo.value = '".$inf["modelo"]."';\n";  
    echo "formObj.detalle.value = '".$inf["detalle"]."';\n";
    
  }
  /*else{
    echo "formObj.categoria.value = ' ';\n";    
    echo "formObj.marca.value = ' ';\n";    
    echo "formObj.modelo.value = ' ';\n";    
    echo "formObj.detalle.value = ' ';\n";
  } */   
}
?>