<?php 
include_once 'crearConexion.php';
$q=$_POST['q'];
$sqlC="SELECT * FROM cat_empleado where fk_depto=".$q;
$empleados=$mysql->consultas($sqlC);
?>
<div class="col-md-12">
<label>Empleado</label>
 <div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
   <select name="empleado" class="form-control input-sm" required>
    <option> </option>
     <?php 
      while($rEmpleados=mysqli_fetch_array($empleados))
       {
        echo "<option value=".$rEmpleados['pk_empleado'].">".$rEmpleados['nombre_empleado']."</option>";
       }
    ?>
  </select>
 </div>
</div>