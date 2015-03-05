
jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}
var centinelaConta=0;
modtotalIMod  = 0.0;
modtotalFNMod = 0.0;


//LLENANDO LOS COMBOS DE PARTIDA Y PROVEEDOR

$('#FacturaMod').ready(function(){
	$.ajax({
		type:"POST",
		data:{opcion:1},
		dataType:"json",
		url:"FacPeticiones/tablaProveedores.php",
		success:function(respuesta){
			$('#modSlPro').append("<option value=''>Seleccione un Proveedor...</option>");
			for(y=0;y<=respuesta.length;y++)
			{
				$('#modSlPro').append("<option value='"+respuesta[y][4]+"'>"+respuesta[y][0]+"</option>");
			}
		}
	});
	// $.ajax({
	// 	type:"POST",
	// 	dataType:"json",
	// 	url:"FacPeticiones/partidas.php",
	// 	success:function(respuesta){
	// 		$('#modSlPartidaFac').append("<option value=''>Seleccione una Partida...</option>");
	// 		for(i=0;i<respuesta.length;i++)
	// 		{
	// 			$('#modSlPartidaFac').append('<option value="'+respuesta[i].pkPartida+'" data-indice="'+i+'">'+respuesta[i].numeroPartida+'</option>');
	// 		}
	// 	}
	// });

	 $('#editFactura').submit(function(e){
           		if($('.totalMod').length==0)
           		{
					$('#alertModFac').html('<div class="alert alert-warning alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  '!La Factura No Tiene Detalles¡</div>');
					$('#cantRow').focus();
           			//alert('no hay detalles en factura');
           		}
           		else
           		{
           			// alert(modtotalFNMod);
           			if(modtotalFNMod!=0 && modtotalIMod!=0){
           			$('input[name=modSubT]').val(modtotalIMod);
           			$('input[name=modTotal]').val(modtotalFNMod);           				
           			}
           			
					var formData = new FormData($("#editFactura")[0]);
					// var datosSer=$("#editFactura").serialize();
					// alert(datosSer);
           			
           			$.ajax({
						url:"FacPeticiones/modFac.php",
						type:"POST",
						data: formData,
						//necesario para enviarFormulario
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function()
						{
							$('#alertModFac').html('<div class="alert alert-info">Guardando Cambios!! Por Favor Espere.</div>');
						},
						success: function(respuesta)
						{
							// alert(respuesta);
							if(respuesta=="MENSAJE.")
							{
								$('#alertModFac').html('<div class="alert alert-success alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  'Cambios Guardados Con Éxito</div>');
								formModEnviado();
							}
						}
					});
           			
           		}
           		//alert(totalFN);
           });
           //END GUARDANDO FACTURA
         
});

//METODO QUE BUSCA Y ENCUNETRA LOS DATOS DE LA FACTURA
function buscarFactura()
{
	 // alert('front');
	datoBusqueda=$('#campoBus').val();
	
	$.ajax({
		type:"POST",
		url:"FacPeticiones/searchFac.php",
		data:{id:datoBusqueda},
		dataType:'json',
		success:function(respuesta){
			// $('#btnModificarFac').attr('disabled',false);
			$('#modDetalle').empty();
			$('#modFolioFac').val(respuesta[3]);
			$('#modSerieFac').val(respuesta[2]);
			$('#modSlPro > option[value="'+respuesta[4]+'"]').attr('selected', 'selected');
			$('#modProyectoFac').val(respuesta[5]);

			for (var i = 0; i < respuesta[6].length; i++) {
			$('#modSlPartidaFac').append('<option value="'+respuesta[6][i].partida+'" selected>'+respuesta[6][i].numero+'</option>')
				// respuesta[6][i]
			};

			$('#modFechaFac').val(respuesta[7]);
			$('#modTotal').html('<div style="margin-top:-1.5%;"><h3>Subtotal:$'+respuesta[8]+' m/n </h3><h3>Total:$'+respuesta[9]+' m/n</h3></div>');
			$('#modSubT').val(respuesta[8]);
			$('#modT').val(respuesta[9]);
			modtotalIMod  = respuesta[8];
			modtotalFNMod = respuesta[9];


			$('#modPkFac').val(respuesta[1]);

			if(respuesta[10]=="Factura")
			{
					$('#modSlTipo > option[value="'+respuesta[10]+'"]').attr('selected', 'selected');
			}
			else if(respuesta[10]=="Remision")
			{
				$('#modSlTipo > option[value="'+respuesta[10]+'"]').attr('selected', 'selected');	
			}
			centinelaConta=0;
			for(x=1;x<=respuesta[11];x++)
			{
				var rowDetalle="";
				centinelaConta+=1;
		   		rowDetalle+='<tr id="dRowmod'+centinelaConta+'"><td><input type="hidden" name="pkModDetalle'+x+'"  value="'+respuesta[12][x].pkDetalleFactura+'"><input type="text" name="cantidadMod'+centinelaConta+'"  min="1" class="form-control number" placeholder="Cantidad" size="5"  value="'+respuesta[12][x].cantidad+'" required></td>';
		   		rowDetalle+='<td><input type="text" name="unidadMod'+centinelaConta+'" class="form-control" value="'+respuesta[12][x].unidad+'" required></td>';
		   		rowDetalle+='<td><textarea name="descripcionMod'+centinelaConta+'" class="form-control" cols="40" rows="3" placeholder="Descripción"  required>'+respuesta[12][x].descripcion+'</textarea></td>';
		   		rowDetalle+='<td><input type="text" name="pUnitarioMod'+centinelaConta+'" min="1" class="form-control number2" placeholder="P.Unitario" size="5"  value="'+respuesta[12][x].precioUnitario+'" required></td>';
		   		rowDetalle+='<td><input type="text" name="ivaBMod'+centinelaConta+'" min="1"  class="form-control number2" placeholder="IVA" size="5" value="'+respuesta[12][x].iva+'" required></td>';
		   		rowDetalle+='<td><input type="text" name="importeMod'+centinelaConta+'" min="1"  class="form-control subtotalMod number2" onblur="recalcularTotal(1);" placeholder="Importe" size="5" value="'+respuesta[12][x].importe+'" required></td>';
		   		rowDetalle+='<td><input type="text" name="ivaDMod'+centinelaConta+'" min="1"  class="form-control totalMod number2" placeholder="+IVA" onblur="recalcularTotal(2);" size="5" value="'+respuesta[12][x].masIva+'"></td>';
		   		rowDetalle+='<td><input type="button" value="-" class="btn btn-danger"  onclick="modeliminardetalle('+centinelaConta+');"></td></tr>';
		   		$('#modDetalle').append(rowDetalle);
		   		
			}
			$('#campoBus').val("");	
		}
	});
}
//BOTON DE CANCELAR LA MODIFICACION DE LA FACTU>RA
function cancelarModFac()
{
	if(confirm('¿Desea Cancelar Modificacion?'))
	{
		$('#modSlTipo option')[0].selected=true;
		$('#modFolioFac').val("");
		$('#modSerieFac').val("");
		$('#modProyectoFac').val("");
		$('#modFechaFac').val("");
		$('#modDetalle').empty();
		$('#modSlPro option')[0].selected = true;
		$('#modSlPartidaFac').empty();
		$('#modTotal').html('<div style="margin-top:-1.5%;"><h3>Subtotal:$0.0 m/n </h3><h3>Total:$0.0 m/n</h3></div>');	
	}
}
function formModEnviado()
{
	$('#modSlTipo option')[0].selected=true;
	$('#modFolioFac').val("");
	$('#modSerieFac').val("");
	$('#modProyectoFac').val("");
	$('#modFechaFac').val("");
	$('#modDetalle').empty();
	$('#modSlPro option')[0].selected = true;
	$('#modSlPartidaFac').empty();
	$('#modTotal').html('<div style="margin-top:-1.5%;"><h3>Subtotal:$0.0 m/n </h3><h3>Total:$0.0 m/n</h3></div>');	
}
function detalleModFac()
{
	
	detalles=$('#detalleNum').val();
	if(detalles!="")
	{
		$('#detalleNum').val("");
		agregandoDetallesMod(detalles);
		$('.number').number( true, 0);
		// $('.number2').number( true, 2);
	}
	else
	{
		alert('Indique El Numero De Detalles');
		$('#cantRow').focus();
	}
}
function agregandoDetallesMod(num)
{

	for(x=1;x<=num;x++)
		{
			var rowDetalle="";
			centinelaConta+=1;
	   		rowDetalle+='<tr id="dRowmod'+centinelaConta+'"><td><input type="text" name="cantidadMod'+centinelaConta+'"  min="1" class="form-control number" placeholder="Cantidad" size="5"  required></td>';
	   		rowDetalle+='<td><input type="text" name="unidadMod'+centinelaConta+'" class="form-control" required></td>';
	   		rowDetalle+='<td><textarea name="descripcionMod'+centinelaConta+'" class="form-control" cols="40" rows="3" placeholder="Descripción" required></textarea></td>';
	   		rowDetalle+='<td><input type="text" name="pUnitarioMod'+centinelaConta+'" min="1" class="form-control number2" placeholder="P.Unitario" size="5"  required></td>';
	   		rowDetalle+='<td><input type="text" name="ivaBMod'+centinelaConta+'" min="1" class="form-control number2" placeholder="IVA" size="5" required></td>';
	   		rowDetalle+='<td><input type="text" name="importeMod'+centinelaConta+'" min="1" value="0" class="form-control subtotalMod number2" placeholder="Importe" size="5" onblur="recalcularTotal(1);" required></td>';
	   		rowDetalle+='<td><input type="text" name="ivaDMod'+centinelaConta+'" min="1" value="0" class="form-control totalMod number2" placeholder="+IVA" size="5" onblur="recalcularTotal(2);"></td>';
	   		rowDetalle+='<td><input type="button" value="-" class="btn btn-danger"  onclick="modeliminardetalle('+centinelaConta+');"></td></tr>';
	   		$('#modDetalle').append(rowDetalle);
	   		
		}
}
function recalcularTotal(opcion)
{
	if(opcion == 1){
		// alert('hola1');
		modtotalIMod  = 0.0;
		$('.subtotalMod').each(function(){
			var submod=parseFloat($(this).val());//OBTENIENDO EL VALOR DE TODOS LOS IMPORTES
			// alert(sub+"-"+totalI+"-");
			$.ajax({
				url: 'FacPeticiones/opermat.php',
				type: 'POST',
				dataType:'json',
				data: {operacion:2,detallesb:submod,subtotal:modtotalIMod},
			})
			.done(function(respuesta) {
				 	modtotalIMod += respuesta[0];

				 	$('#modTotal').html('<h3>Subtotal:  $'+modtotalIMod+' m/n</h3><h3>Total:$'+modtotalFNMod+' m/n</h3>');
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});
		// // totalImporte =	parseFloat($('input[name=importe'+id+']').val());
	}
	else if(opcion == 2){
		// alert('hola2');
		modtotalFNMod = 0.0;
		$('.totalMod').each(function(){
			var submod=parseFloat($(this).val());//OBTENIENDO EL VALOR DE TODOS LOS IMPORTES
			// alert(sub+"-"+totalFN+"-");
			$.ajax({
				url: 'FacPeticiones/opermat.php',
				type: 'POST',
				dataType:'json',
				data: {operacion:2,detallesb:submod,subtotal:modtotalFNMod},
			})
			.done(function(respuesta) {
				 	modtotalFNMod  += respuesta[0];
				 	$('#modTotal').html('<h3>Subtotal:  $'+modtotalIMod+' m/n</h3><h3>Total:$'+modtotalFNMod+' m/n</h3>');
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});
	}		
	// $('#modTotal').html('<div style="margin-top:-1.5%;"><h3>Subtotal:$'+modtotalIMod+' m/n</h3><h3>Total:$'+modtotalFNMod+' m/n</h3></div>');
}
function cancelPartida()
{
	if(confirm("la creacion de la partida se cancelara.¿Desea Continuar?"))
	{
		resetearPartida();
		//alert("cancelando la partidas");
	}
}
function resetearPartida()
{
	$('#idNumPar').val("");
	$('#idDescripcionPar').val("");
}
function modagregandoPartidaFac()
{
	valor = $('#modbusquedaPartidaFac').val();
	$.ajax({
		type:"POST",
		dataType:"json",
		url:"FacPeticiones/agregandoPartida.php",
		data:{param1:valor},
		success:function(respuesta){
			if (respuesta=="error") {
				alert("¡La partida no existe!");
			} else{
				$('#modSlPartidaFac').append('<option value="'+respuesta[0]+'" selected>'+respuesta[1]+'</option>');
				$('#modbusquedaPartidaFac').val("");
			};
		},
		error:function()
		{
			alert('¡La partida no existe!');
		}
	});
}
function removerPartidas(){
	if(confirm("Las partidas seran eliminadas.¿Desea Continuar?.")){
		$('#modSlPartidaFac').empty();
	}
}
function modeliminardetalle(id){
	var menosmodSubtotal=0.0;
	var menosmodTotal=0.0;
// alert(modtotalIMod+"-"+modtotalFNMod);
	

	if(confirm("Este detalle sera eliminado.¿Desea continuar?")){

		menosmodSubtotal = parseFloat($('input[name=importeMod'+id+']').val());
		menosmodTotal    = parseFloat($('input[name=ivaDMod'+id+']').val());
		// alert(menosmodSubtotal+"-"+menosmodTotal);
		$.ajax({
			url: 'FacPeticiones/opermat.php',
			type: 'POST',
			dataType:'json',
			data: {operacion:1,sus1:menosmodSubtotal,sus2:menosmodTotal,sbtotal:modtotalIMod,total:modtotalFNMod},
		})
		.done(function(respuesta) {
			// console.log(respuesta[0]);
			// alert(respuesta[0]);
				modtotalIMod  = respuesta[0];
				modtotalFNMod = respuesta[1];

				// alert(modtotalIMod+"-"+modtotalFNMod);

			 	$('#modTotal').html('<h3>Subtotal: $'+modtotalIMod+' m/n</h3><h3>Total:$'+modtotalFNMod+' m/n</h3>');
				$('#dRowmod'+id).remove();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
		// ACTUALIZANDO TOTAL
	}
}