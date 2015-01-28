<div invgeneral>
    	  <div class="col-sm-4 col-md-2">
          <div class="list-group">
            <a class="list-group-item active">
              Opciones
            </a>
            <a href="#" class="list-group-item" data-toggle="modal" OnClick="RegArticulos();">Registrar Articulos</a>
            <a href="#" class="list-group-item">Administrar Articulos</a>
            <a href="#modalnuevacategoria" class="list-group-item" data-toggle="modal">Nueva Categoria</a>
            <a href="#" class="list-group-item" OnClick="Categorias();">Administrar Categorias</a>
            <a href="#modalnuevamarca" class="list-group-item" data-toggle="modal">Nuevo Marca</a>
            <a href="#" class="list-group-item" OnClick="Marcas();">Administrar Marcas</a>
          </div>
</div>
<div editusuarios>
    <div class="col-md-10">
    <form role="form" action="" method="post">
    <div class="header">
    <h4 class="title">Registrar Articulos</h4>
    </div>

    <div class="col-md-4">
               <div class="form-group">
                <label>Codigo</label>
            	<div class="input-group">
          			<span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span>
              		<input type="text"  class="form-control" placeholder="Codigo"  required>
                </div>
              </div>
    </div>
    <div class="col-md-4 col-md-offset-1">
    		<div class="form-group">
            <label>Modelo</label>
            	<div class="input-group">
            		<span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
            		<input type="text"  class="form-control" placeholder="Modelo" required>
                </div>
              </div>
    </div>
      	<div class="col-md-4">
    		<div class="form-group">
                    <label>Categoria</label>
                    <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
                      <select class="form-control input-sm" Required>
                        <option></option>
                      </select>
            	</div>
            </div>
    </div>
    <div class="col-md-4 col-md-offset-1">
             <div class="form-group">
               <label>Marca</label>
                <div class="input-group">
                	<span class="input-group-addon"><span class="glyphicon glyphicon-registration-mark"></span></span>
                  <select class="form-control input-sm" Required>
                    <option></option>
                  </select>              
                </div>
              </div>
    </div>
    <div class="col-md-4">
              <div class="form-group">
            		<label>Cantidad</label>
            	<div class="input-group">
            		<span class="input-group-addon">N.</span>
              		<input type="number"  class="form-control" onkeypress="return pulsar(event)" required>
                </div>
              </div>
    </div>
    <div class="col-md-4 col-md-offset-1">          
               <div class="form-group">
            		<label>Detalle</label>
            	<div class="input-group">
            		<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span></span>
              		<textarea class="form-control" placeholder="Detalles"></textarea>
                </div>
              </div>
    </div>		
    <div class="col-md-10 col-md-offset-5">
            <div class="footer">
    			<button type="button" class="btn btn-default" id="UCancelar" OnClick="Usuarios();">Cancelar</button>
    		    <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
            </div>
    </form>
    </div>
    </div>
</div>