<?php
session_start()
?>
<?PHP 
	include_once 'crearConexion.php';
	$sql1="SELECT * FROM cat_autoriza";
	$autoriza=$mysql->consultas($sql1);
?>
<div id="content" style="margin-top:60px;">
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('#datatables').dataTable({
                    "sPaginationType":"full_numbers",
                    "aaSorting":[[2, "desc"]],
                    "bJQueryUI":true
                });
            })
            function cancelar()
			{
				self.location="inventB";
			}
        </script>
		<script type="text/javascript" src="../js/misfunciones.js"></script>
	<div invbajas>
       <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#" onClick="bajas();" class="list-group-item">Nueva Baja</a>
            <a href="#" onClick="bajasConsumible();" class="list-group-item">Bajas de Consumibles</a>
            <a href="#modalnuevoautorizador" class="list-group-item" data-toggle="modal">Nuevo Autorizador</a>
            <a href="#" onClick="autoriza();" class="list-group-item">Administrar Autorizadores</a>
          </div>
		</div>
     </div>
    <div id="workspace" class="col-md-10"><!--inicio div workspace-->
       <div class="panel panel-default" id="container" style="box-shadow: 0 0 5px 5px #888;">
        <div class="panel-heading">
        <form action="regBaja.php" method="post" onSubmit="return evalaListaArticulos();" id="reporteBaja">
            <div id="agregarArticulos">
            		<div class="col-md-6"><label>USUARIO:<?php echo $_SESSION['user']; ?></label></div>
                	<div class="col-md-6"><label>FECHA:<?php  date_default_timezone_set('UTC'); $fecha=date("d-m-Y "); echo $fecha ?></label></div>
                	<div class="form-group col-md-6"><label>Folio:</label><div class="input-group"><span class="input-group-addon"><span>N.</span></span><input class="form-control" type="text" name="foliobaja" id="foliobaja" /></div></div>
                    <div class="form-group col-md-6"><label>Autoriza:</label><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-ok"></span></span><select class="form-control" name="autoriza" id="autoriza" required>
                    	<option> </option>
                    		<?php 
                        		while($rAutoriza=mysqli_fetch_array($autoriza))
                        			{
                            			echo "<option value=".$rAutoriza['pk_autoriza'].">".$rAutoriza['autoriza']."</option>";
                        			}
                    		?>
                    	</select>
                    </div></div>
                    
                    <div class="col-md-2"><label>Codigo Del Articulo:</label></div><div class="col-md-6"><input class="form-control" type="text" id="agregarProductoBaja" /></div><div class="col-md-4"><button class="btn btn-success" type="button" id="agregar" name="Agregar" onclick="agregarArticulosBajas();">&nbsp;<span class="glyphicon glyphicon-plus"></span></button></div>
            </div>
                <br>
                <div class="panel-body col-md-12" id="containerArticulo" style="overflow:auto;">
                    <table class="table table-striped table-bordered" id="articulos">
                    <thead>
                        <tr class="active">
                          <th>Codigo</th>
                          <th>Nom. Serie</th>
                          <th>Modelo</th>
                          <th>Marca</th>
                          <th>Articulo</th>
                          <th>Motivo</th>
                          <th>Quitar</th>
                        </tr>
                      </thead>
                    </table>
                </div>
               <center> <input  class="btn btn-info" type="button" value="Generar Reporte" OnClick="reporteBaja();"/></center> <br >
               
        <div  class="panel-footer">
        <center>
        <input class="btn btn-default" type="button" value="Cancelar" OnClick="cancelar();"/>
        <input class="btn btn-primary" type="submit" value="Guardar" disabled="disabled" />
        </center>
        </div>
        </form>
        </div>
    </div><!--fin div workspace-->
</div>