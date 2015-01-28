<div class="col-md12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4>Modificar Factura</h4>
    </div>
    <div class="panel-body">
      <div id="busquedaFac">
        <form action="" onsubmit="return false">
          <div class="row">
            <div class="input-group col-md-6">
              <span class="input-group-addon">Buscar:</span>
              <input type="text" id="campoBus" placeholder="Serie/Folio" class="form-control">
            </div>
            <button id="btnBuscarFac" onclick="buscarFactura();" class="btn btn-info input-group">Buscar</button>

          </div>
          <!-- <label for="factura">Factura:</label><input type="text" id="campoBus" placeholder="Serie/Folio" ><button id="btnBuscarFac" onclick="buscarFactura();">Buscar</button> -->
        </form>
      </div>
      <div id="FacturaMod">
          <div>
                                <div id="alertModFac"></div>
                                   <div class="col-md-12" style="margin-top:1em;">
                                      <div class="panel panel-default">
                                        <div class="panel-body"><!--CUERPO FACTURA-->
                                          <form  role="form" action="" id="editFactura" onsubmit="return false">
                                          <div class="row">  
                                            <div class="input-group col-md-6">
                                                <span class="input-group-addon">Tipo</span>
                                                <select name="tipo" id="modSlTipo" class="form-control" required>
                                                <option value="">Seleccione un tipo de factura..</option>
                                                <option value="Factura">Factura</option>
                                                <option value="Remision">Remision</option>
                                              </select>
                                            </div>
                                          </div>
                                          <!-- <label for="tipo">Tipo</label> -->

                                          <!-- <input type="radio" name="tipo"  value="Factura" id="radio_1">Factura
                                          <input type="radio" name="tipo"  value="Remision" id="radio_2">Nota Remision -->
                                          <input type="hidden" name="UsuarioFac" value="<?php echo $_SESSION['id'] ?>">
                                            <div class="panel-body"><!--PANEL DEL SELECT-->
                                              <div class="form-group col-md-6"><!--SELECT PROVEEDOR-->
                                              <div class="form-group input-group">
                                                  <span class="input-group-addon"> &nbsp; N. Folio: &nbsp;</span>
                                                      <input class="form-control" name="folioFac" placeholder="Folio" type="text" id="modFolioFac" required>
                                              </div>
                                                   <div class="form-group input-group">
                                                       <span class="input-group-addon">&nbsp; N. Serie: &nbsp;</span>
                                                       <input class="form-control" name="serieFac" placeholder="Serie" type="text" id="modSerieFac">
                                                   </div>
                                                <div class="form-group">
                                                  <div class="input-group input-group">
                                                    <span class="input-group-addon">Proveedor:</span>
                                                    <select name="proFac" class="form-control" id="modSlPro" required>
                                                        <!--opciones cargadas con ajax-->
                                                    </select>
                                                  </div>
                                                </div>
                                                   <div class="form-group input-group">
                                                       <span class="input-group-addon">&nbsp;Proyecto&nbsp;</span>
                                                       <input class="form-control" name="proyectoFac" placeholder="Proyecto" type="text" id="modProyectoFac" >
                                                   </div>
                                                <div class="form-group">
                                                  <div class="input-group input-group">
                                                    <span class="input-group-addon">&nbsp;  Partida  &nbsp;</span>
                                                    <select name="partidaFac" class="form-control" id="modSlPartidaFac" >
                                                        <!--opciones cargadas con ajax-->
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="form-group input-group">
                                                       <span class="input-group-addon">&nbsp; &nbsp; Fecha: &nbsp; </span>
                                                       <input class="form-control" placeholder="AAAA/MM/DD" type="date" name="fechaFac" id="modFechaFac" required>
                                                </div>
                                              </div><!--END SELECT PROVEEDOR-->

                                            <div class="panel panel-default col-md-6">
                                                  <div class="panel-body" id="modTotal">
                                                    <div style="margin-top:-1.5%;">
                                                            <h3>Subtotal:$0.00 m/n</h3>
                                                            <h3>Total:$0.00 m/n</h3>
                                                    </div>
                                                  </div>
                                                  <input type="hidden" name="modSubT" id="modSubT">
                                                  <input type="hidden" name="modTotal" id="modT">
                                                  <input type="hidden" name="modPkFac" id="modPkFac">
                                                </div>
                                                <!-- <div class="col-md-2" ><input type="number" class="form-control" id="detalleNum" min="1"></div> -->
                                                <!-- <input type="button" class="btn btn-info "   value="Agregar Detalle" onclick="detalleModFac();"> -->
                                                <!--<input type="button" class="btn btn-warning" style="margin-top:5%;" value="Calcular Total" id="btnCalcularTotal">-->
                                                <!-- <input type="button" class="btn btn-default" value="Recalcular" onclick=""> -->
                                                <input type="button" class="btn btn-danger"  value="Cancelar" onclick="cancelarModFac();">
                                                <input type="submit" class="btn btn-success"  value="Guardar" id="btnModificarFac" onSubmit="return False" >
                                            </div><!--END PANEL DEL SELECT-->
                                            <div class="panel-body" style="height:300px;overflow-y:scroll;"><!--TABLA DETALLE FACTURA-->
                                                <table class="table table-striped table-bordered table-hover" >
                                                    <thead>
                                                      <tr>
                                                          <th>Cantidad</th>
                                                          <th>Unidad</th>
                                                          <th>Descripción</th>
                                                          <th>Precio Unitario</th>
                                                          <th>IVA</th>
                                                          <th>Importe</th>
                                                          <th>Importe(+IVA)</th>
                                                          <!-- <th>Remover</th> -->
                                                            <!--<th>Operaciones</th>-->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="modDetalle">
                                                      <!--contendio cargado via jqery-->
                                                    </tbody>
                                                </table>
                                            </div><!--END TABLA DETALLE FACTURA-->
                                          </form>
                                        </div><!--END CUERPO FACTURA-->
                                      </div>
                                  </div>
                                </div>
</div>