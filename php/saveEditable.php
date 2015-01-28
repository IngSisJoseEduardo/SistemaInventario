<?php
include_once 'clases/CSlogan.php';

$valor=$_POST['valor'];
$newSlogan=new CSlogan($valor);

$modificarSlogan=$newSlogan->modificarSlogan();
echo stripslashes($valor);




?>