
jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}
var centinelaConta=0;
var totalFNMod=0;
var totalIMod=0;
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
           			if(totalIMod!=0 || totalFNMod!=0){
           			$('input[name=modSubT]').val($.number(totalIMod,2));
           			$('input[name=modTotal]').val($.number(totalFNMod,2));           				
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
								// $('#tbDetalle').empty();
								// contador=0;
								// $('#slPro option')[0].selected = true;//SELECCIOANDNO AL INDICE CERO DEL SELECT PROVEEDORES
								// $('#slPartidaFac option')[0].selected = true;
								// //LIMPIANDO ELEMENTOS DEL FORM
								// $('#folioFac').val("");
								// $('#serieFac').val("");
								// $('#fechaFac').val("");
								// $('#proyectoFac').val("");
								// $('#total').html('<h3>Subtotal:$0.00 m/n </h3><h3>Total:$0.00 m/n</h3>');
								// totalI=0.0;//guardara importe din iva
								// totalFN=0.0;//guardara importe con iva
								// $('#notPen').html('12');
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
		data:{serieFolio:datoBusqueda},
		dataType:'json',
		success:function(respuesta){
			// $('#btnModificarFac').attr('disabled',false);
			$('#modDetalle').empty();
			$('#modFolioFac').val(respuesta[3]);
			$('#modSerieFac').val(respuesta[2]);
			$('#modSlPro > option[value="'+respuesta[4]+'"]').attr('selected', 'selected');
			$('#modProyectoFac').val(respuesta[5]);

			for (var i = 0; i < respuesta[6].length; i++) {
			$('#modSlPartidaFac').append('<option  value="'+respuesta[6][i].partida+'" selected>'+respuesta[6][i].numero+'</option>')
			};
						
			$('#modFechaFac').val(respuesta[7]);
			$('#modTotal').html('<div style="margin-top:-1.5%;"><h3>Subtotal:$'+respuesta[8]+' m/n </h3><h3>Total:$'+respuesta[9]+' m/n</h3></div>');
			$('#modSubT').val(respuesta[8]);
			$('#modT').val(respuesta[9]);
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
		   		rowDetalle+='<tr id="dRow'+centinelaConta+'"><td><input type="hidden" name="pkModDetalle'+x+'"  value="'+respuesta[12][x].pkDetalleFactura+'"><input type="text" name="cantidadMod'+centinelaConta+'"  min="1" class="form-control number" placeholder="Cantidad" size="5" onblur="recalcularTotal('+centinelaConta+');" value="'+respuesta[12][x].cantidad+'" required></td>';
		   		rowDetalle+='<td><input type="text" name="unidad'+centinelaConta+'" class="form-control" value="'+respuesta[12][x].unidad+'" required></td>';
		   		rowDetalle+='<td><textarea name="descripcion'+centinelaConta+'" class="form-control" cols="40" rows="3" placeholder="Descripción"  required>'+respuesta[12][x].descripcion+'</textarea></td>';
		   		rowDetalle+='<td><input type="text" name="pUnitarioMod'+centinelaConta+'" min="1" class="form-control number2" placeholder="P.Unitario" size="5" onblur="recalcularTotal('+centinelaConta+');" value="'+respuesta[12][x].precioUnitario+'" required></td>';
		   		rowDetalle+='<td><input type="text" name="ivaBMod'+centinelaConta+'" min="1"  class="form-control number2" placeholder="IVA" size="5" value="'+respuesta[12][x].iva+'" required></td>';
		   		rowDetalle+='<td><input type="text" name="importeMod'+centinelaConta+'" min="1"  class="form-control subtotalMod number2" placeholder="Importe" size="5" value="'+respuesta[12][x].importe+'" required></td>';
		   		rowDetalle+='<td><input type="text" name="ivaDMod'+centinelaConta+'" min="1"  class="form-control totalMod number2" placeholder="+IVA" size="5" value="'+respuesta[12][x].masIva+'"></td>';
		   		// rowDetalle+='<td><input type="button" value="-" class="btn btn-danger"  onclick="eliminarDetalleFac('+centinelaConta+');"></td></tr>';
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
		$('#modSlPartidaFac option')[0].selected = true;
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
	$('#modSlPartidaFac option')[0].selected = true;
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
		$('.number2').number( true, 2);
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
	   		rowDetalle+='<tr id="dRow'+centinelaConta+'"><td><input type="text" name="cantidadMod'+centinelaConta+'"  min="1" class="form-control number" placeholder="Cantidad" size="5" onblur="importe('+centinelaConta+',2);"  required></td>';
	   		rowDetalle+='<td><input type="text" name="unidad'+centinelaConta+'" class="form-control" required></td>';
	   		rowDetalle+='<td><textarea name="descripcion'+centinelaConta+'" class="form-control" cols="40" rows="3" placeholder="Descripción" required></textarea></td>';
	   		rowDetalle+='<td><input type="text" name="pUnitarioMod'+centinelaConta+'" min="1" class="form-control number2" placeholder="P.Unitario" size="5" onblur="importe('+centinelaConta+',2);" required></td>';
	   		rowDetalle+='<td><input type="text" name="ivaB'+centinelaConta+'" min="1" value="0.00" class="form-control number2" placeholder="IVA" size="5" required></td>';
	   		rowDetalle+='<td><input type="text" name="importe'+centinelaConta+'" min="1" value="0.00" class="form-control subtotal number2" placeholder="Importe" size="5" required></td>';
	   		rowDetalle+='<td><input type="text" name="ivaD'+centinelaConta+'" min="1" value="0.00" class="form-control total number2" placeholder="+IVA" size="5"></td>';
	   		rowDetalle+='<td><input type="button" value="-" class="btn btn-danger"  onclick="eliminarDetalleFac('+centinelaConta+');"></td></tr>';
	   		$('#modDetalle').append(rowDetalle);
	   		
		}
}
function recalcularTotal(id)
{
		//REALIZANDO CALCULOS DE IMPORTE,IVA,IMPORTE MAS IVA
		// alert(id);
	// cantidad=$('input[name=cantidadMod'+id+']').val();//obteniendo valor de cantidad
	// pUnitario=$('input[name=pUnitarioMod'+id+']').val();//obteniendo valor de Precio Unitario

	// iva=pUnitario*0.16;//obteninedo el iva a 16%
	// iva=iva.toFixed(2);//REDONDENADO IVA A DOS DECIMALES

	// cImporte=(cantidad*pUnitario);//calculando importe sin iva
	// masIva=cImporte+(cantidad*iva);//calculando importe mas iva
	// //REDONDENADO IMPORTE E IMPORTE(+)IVA
	// cImporte=cImporte.toFixed(2);
	// masIva=masIva.toFixed(2);

	//COLOCANDO CALCULOS EN CAMPOS IVA, IMPORTE, IMPORTE+IVA

	cantidad=parseFloat($('input[name=cantidadMod'+id+']').val());
	pUnitario=parseFloat($('input[name=pUnitarioMod'+id+']').val());
	iva=pUnitario*0.16;

	cantidad=cantidad.toFixed(2);
	pUnitario=pUnitario.toFixed(2);
	iva=iva.toFixed(2);
	
	cImporte=(cantidad*pUnitario);
	masIva=(cImporte+(cantidad*iva));
	masIva=masIva.toFixed(2);

	//COLOCANDO CALCULOS EN CAMPOS IVA, IMPORTE, +IVA

	$('input[name=ivaBMod'+id+']').val(iva);
	$('input[name=importeMod'+id+']').val(cImporte);
	$('input[name=ivaDMod'+id+']').val(masIva);

	//CALCULANDO Y MOSTRNADO TOTALES

	totalImporte=0.0;//guardara importe din iva
	totalFinal=0.0;//guardara importe con iva
	
	//OBTENIENDO TODOS LOS IMPORTES
	$('.subtotalMod').each(function(){
		var sub=parseFloat($(this).val());//OBTENIENDO EL VALOR DE TODOS LOS IMPORTES
		totalImporte=totalImporte+sub;//SUMANDO TODOS LOS IMPORTES
		totalIMod=totalImporte.toFixed(2);
		//totalImporte=totalImporte.toFixed(2)//REDONDENDO A DOS DECIMALES EL TOTAL
	});
	//OBTENIENDO TODOS LOS IMPORTES +IVA
	$('.totalMod').each(function(){
		var totalF=parseFloat($(this).val());//OBTENIENDO TODOS LOS IMPORTES
		totalFinal=totalFinal+totalF;//SUMANDO TODOS LOS IMPORTES
		totalFNMod=totalFinal.toFixed(2);
		//totalFinal=totalFinal.toFixed(2);//REDONDEANDO A DOS DECIMALES EL TOTAL
	});
	
	$('#modTotal').html('<div style="margin-top:-1.5%;"><h3>Subtotal:$'+$.number(totalIMod,2)+' m/n</h3><h3>Total:$'+$.number(totalFNMod,2)+' m/n</h3></div>');
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

