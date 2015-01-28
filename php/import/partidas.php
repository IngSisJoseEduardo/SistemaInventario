<div class="col-md-12"><!--con1-->
	<div class="panel panel-default"><!--panel1-->
		<div class="panel-heading"><!--encabezado paenl-->
			<h4>Partidas</h4>
		</div><!--end encabezado paenl-->
		<div class="panel-body"><!-- cuerpo del panel -->
			<ul class="nav nav-tabs"><!-- menu de navegacion -->
				<li class="active"><a href="#nuevaPartida" data-toggle="tab">Crear</a></li>
				<li><a href="#modificarPar" data-toggle="tab">Modificar</a></li>
			</ul><!-- fin de menu de navegacion -->

			<div class="tab-content"><!-- contenedor de tabs -->
				<div class="tab-pane fade in active" id="nuevaPartida"><!-- contendor de la nueva partida -->
					<div id="alertPartida"></div>
					<div id="formPartidas">
						<form action=""  onsubmit="return false" id="formPartidas">
							
								<div class="form-group input-group col-md-6 col-md-offset-1">
	                               <span class="input-group-addon">&nbsp;Numero Partida&nbsp;</span>
	                               <input class="form-control"  placeholder="Numero Partida" type="text" id="idNumPar">
	                            </div>
								<div class="form-group input-group col-md-6 col-md-offset-1">
	                               <span class="input-group-addon glyphicon glyphicon-edit"></span>
	                               <textarea  id="idDescripcionPar" class="form-control" cols="50" rows="5" placeholder="Descripción" required></textarea>
	                            </div>

							<div class="col-md-6 col-md-offset-1">
								<input type="submit" class="btn btn-success" value="Guardar" onclick="guardarPartidas();">
								<input type="button" class="btn btn-danger" id="cancelarPartida" onclick="cancelPartida();" value="Cancelar">
							</div>
						</form>
					</div>
				</div><!-- fin de contendor de nueva partida -->
				<div class="tab-pane fade in" id="modificarPar">
					<div id="alertModificarPar"></div>
					<div id="buesquedaPArtida">						
						<form id="busquedaP" onsubmit="return false">
							<div class="form-group input-group col-md-6 col-md-offset-1">
                               <span class="input-group-addon">&nbsp;Numero Partida&nbsp;</span>
                               <input class="form-control"  placeholder="Numero Partida" type="text" id="campoBusqueda" required>
                            </div>
                            <input type="button" class="btn btn-info" id="btnBusqueda" onclick="busquedaPartida();" value="Buscar">
							<!-- <label for="partida">Numero De Partida: </label><input type="text" id="campoBusqueda" required><button id="btnBusqueda" onclick="busquedaPartida();">Buscar</button> -->
						</form>

						<div id="edicionPartida">
							
						</div>
					</div>
				</div>
			</div><!-- fin de contendor de tabs -->
		</div><!-- fin del cuerpo del panel -->
	</div><!--end panel1-->	
</div><!--end con1-->