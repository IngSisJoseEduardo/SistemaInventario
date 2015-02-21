	$(document).ready(function(e) 
	{
		$('#partidas').hide();
		$('#contenedorModificarPar').hide();
		$('#idSalidas').click(function(){
			$('#contenedorSalidas').show();
			$('#partidas').hide();
		});
		$('#idPartidasSal').click(function(){
			$('#contenedorSalidas').hide();
			$('#partidas').show();
		});

		//COMPROBANDO EL NICK DE NUEVO USUARIO
		$('#uNickname').blur(function(){
			var nik=$(this).val();
			//alert(nik);
			$.ajax({
				type:"POST",
				data:{nik:nik},
				url:"comprobarUser.php",
				beforeSend: function(){
					$('#comprobandoNick').html('Evaluadno Disponibilidad...<img src="../img/cargando.gif" width="20" height="20">');
				},
				success:function(respuesta){
					if(respuesta==0)
					{
						$('#comprobandoNick').html('<label style="color:#f00;">No Disponíble.</label>');
						$('#uNickname').val("");
					}
					else if(respuesta==1)
					{
						$('#comprobandoNick').html('<label style="color:#0f0;">Disponíble.</label>');
					}
				}
			});
		});
		//END COMPROBANDO EL NICK DE NUEVO USUARIO
		
		$('#usuarios').click(function(){
			
			$('#content').load("usuarios.php");
		});
		$('#asignaciones').click(function(){
			
			$('#content').load("asignar");
		});
		$('#inventariogeneral').click(function(){
			
			$('#content').load("inventariogeneral.php");
		});
		$('#inventariodetalle').click(function(){
			
			$('#content').load("inventariodetalle.php");
		});
		$('form').keypress(function(e){   
    		if(e == 13){
      		return false;
    	}
  		});

  		$('input').keypress(function(e){
    		if(e.which == 13){
      		return false;
    	}
  		});
		
		
		$('.aenter').keypress(function(e){
    		if(e.which == 13)
			{
				//alert("Preisono Enter");
				agregarArticulos();
				$('#agregarProducto').val("");
      			//return false;
    		}
  		});
		
		$('#agregar').keypress(function(e){
    		if(e.which == 13)
			{
      			return false;
    		}
  		});
		
		$('#agregarProductoBaja').keypress(function(e){
    		if(e.which == 13)
			{
				//alert("bajas");
				agregarArticulosBajas();
				$('#agregarProductoBaja').val("");
      			//return false;
    		}
  		});
		
		
		$(" .generar").each(function(i){
       			var titulo = $(this).attr("title");
       			$(this).barcode(titulo, "codabar",{barWidth:1.5, barHeight:30});
				//alert("Atributo title del enlace " + i + ": " + titulo);
    	});
		
		//comprobar los chekbox de sistemas operativos
		$('[name="so"].chekboxSO').click(function() {
			
			$('.chekboxSO').each(function(){
				var checkbox = $(this);
				var idSoftware=checkbox.val();
				if(checkbox.is(':checked'))
				{
					$('#campo'+idSoftware).append('<label></label><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-qrcode"></span></span><input type="text" class="form-control" name="serial'+idSoftware+'" /></div>');
				}
				else
				{
					$('#campo'+idSoftware).empty();
				}
			});

		});
		//termina comprobacion de chekbox de sistema operativo

		 //comprobar los chekbox de programas
		 $('.chekboxP').click(function() {
			 var idSoftware=$(this).val();
  			if($(this).is(':checked'))
			{
				$('#campo'+idSoftware).append('<label></label><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-qrcode"></span></span><input class="form-control" type="text" name="serial'+idSoftware+'"/></div>');
    			//alert('Se hizo check en el checkbox.'+idSoftware);
  			}
			else
			{
				$('#campo'+idSoftware).empty();
    			//alert('Se destildo el checkbox'+idSoftware);
  			}
		});
		//validadndo lista de programs a quitar
		$(".validar_Lista").submit( function(){
    		
			//alert("hola");
			var check = $("input[type='checkbox']:checked").length;
			if(check==" ")
			{
				alert("Seleccione almenos un programa");
				return (false);
			}
		});

		 //termina chekeo de chekbox
		 
		 $('#hola').hide();//ocultando div de software
		 
		 //cambiar imagen del formato pdf
		 $('#bMostrar').on("click",function(){
			 var opcion=$("input[name='imagen']:checked").val();
			 if(opcion==0)
			 {
				 $('#encabezado').html('<center><img src="temp/encabezado.jpg" width="100%" height="20%" id="eNuevo" /></center>');
			 }
			 else if(opcion==1)
			 {
				 $('#formato').css('background-image','url(../php/temp/marcaAgua.jpg)');
				  $('#formato').css('background-repeat','no-repeat');
			 }
			$('#bGuardar').removeAttr('disabled');
			$('#bCancelar').removeAttr('disabled');
		 });
		
		 $('#bCancelar').on("click",function(){
			var opcion=$("input[name='imagen']:checked").val();
			if(opcion==0)
			{
				$('#encabezado').html('<center><img src="../img/encabezadopdf2.jpg" width="100%" height="20%" id="eActual"></center>');
			}
			else if(opcion==1)
			{
				$('#formato').css('background-image','url(../img/fondopdf.jpg)');
				$('#formato').css('background-repeat','no-repeat');
			}
		 	$('#bGuardar').attr('disabled','true');
			$('#bCancelar').attr('disabled','true');
		 });
		 
		 $('#bGuardar').on('click',function(){
			var tipo=$("input[name='imagen']:checked").val();

			$.ajax({
				type:'post',
				data:{opcion:tipo},
				url:"imgFormato.php",
				success: function(respuesta)
				{
					if(respuesta==0)
					{
						alert("Encabezado,Modificado Con Exito");
					}
					else if(respuesta==1)
					{
						alert("Marca de Agua,Modificada Con Exito");
					}
				}
			 });
			 $('#bMostrar').attr('disabled','true');
			 $('#bCancelar').attr('disabled','true');
			 $('#bGuardar').attr('disabled','true');

		 });
		//aqui termina formato pdf

		//funciones para proveedores y factura
			$('#contenedor1').hide();//OCULTANDO CONTENEDOR1 DE PROVEEDOR
			$('#btnActualizar').hide();//OCULTANDO BOTN DE ACTUALIZAR
			$('#contenedorPar').hide();//OCULTANDO DIV DE PARTIDAS
			
			//OCULTANDO CONTENEDOR1 DE PROVEEDOR  y MOSTRAR FACTURA
			$('#btnFactura').click(function(){
				$('#contenedor1').hide();
				$('#contenedorPar').hide();
				$('#contenedorModificarPar').hide();
				$('#contenedorF').show();

				$('#slPro').empty();
				$('#slPartidaFac').empty();
				$.ajax({
					type:"POST",
					data:{opcion:1},
					dataType:"json",
					url:"FacPeticiones/tablaProveedores.php",
					success:function(respuesta){
						$('#slPro').append("<option value=''>Seleccione un Proveedor...</option>");
						for(y=0;y<=respuesta.length;y++)
						{
							$('#slPro').append("<option value='"+respuesta[y][4]+"'>"+respuesta[y][0]+"</option>");
						}
					}
				});
				// $.ajax({
				// 	type:"POST",
				// 	dataType:"json",
				// 	url:"FacPeticiones/partidas.php",
				// 	success:function(respuesta){
				// 		$('#slPartidaFac').append("<option value=''>Seleccione una Partida...</option>");
				// 		for(i=0;i<respuesta.length;i++)
				// 		{
				// 			$('#slPartidaFac').append('<option value="'+respuesta[i].pkPartida+'" data-indice="'+i+'">'+respuesta[i].numeroPartida+'</option>');
				// 		}
				// 	}
				// });
			});
			//mostrando modificar factura
			$('#btnModificarFac').click(function(){
				$('#contenedor1').hide();
				$('#contenedorF').hide();
				$('#contenedorPar').hide();
				$('#contenedorModificarPar').show();
				listarproveedores();
			});
			//mostrando contenedor 1 de proveedor AL DAR CLCICK EN PROVEEDOR	
			$('#btnProveedor').click(function(){
				$('#contenedor1').show();
				$('#contenedorF').hide();
				$('#contenedorPar').hide();
				$('#contenedorModificarPar').hide();
				
			});

			// MOSTRANDO PARTIDAS
			$('#btnPartida').click(function(){
				// alert('partidas');
				$('#contenedor1').hide();
				$('#contenedorF').hide();
				$('#contenedorModificarPar').hide();
				$('#contenedorPar').show();
			});

			//MOSTRANDO LOS PROVEEDORES EN FACTURA
			$('#slPro').ready(function(){
				$.ajax({
					type:"POST",
					data:{opcion:1},
					dataType:"json",
					url:"FacPeticiones/tablaProveedores.php",
					success:function(respuesta){
						$('#slPro').append("<option value=''>Seleccione un Proveedor...</option>");
						for(y=0;y<=respuesta.length;y++)
						{
							$('#slPro').append("<option value='"+respuesta[y][4]+"'>"+respuesta[y][0]+"</option>");
						}
						//alert(respuesta);
					}
				});
			});
			//END RPOVEEDORES EN FACTURA
			// MOSTRANDO LAS PARTIDAS EN LA FACTURA
			// $('#slPartidaFac').ready(function(){
			// 	$('#slPartidaFac').append("<option value=''>Seleccione una Partida...</option>");
			// 	$.ajax({
			// 		type:"POST",
			// 		dataType:"json",
			// 		url:"FacPeticiones/partidas.php",
			// 		success:function(respuesta){
			// 			for(i=0;i<respuesta.length;i++)
			// 			{
			// 				$('#slPartidaFac').append('<option value="'+respuesta[i].pkPartida+'" data-indice="'+i+'">'+respuesta[i].numeroPartida+'</option>');
			// 			}
			// 		}
			// 	});
			// });
			//EN PARTIDAS EN FACTURA
			//AGREGANDO DATATABLE A TABLA
				$('#tablaProveedores').ready(function(){
					table=$('#tablaProveedores').dataTable( {
								"processing": true,
						        "serverSide": false,
						        "ajax": "FacPeticiones/tablaProveedores.php",
						        "language": {
						            "url": "../php/FacPeticiones/español.json"
						        }
					});
				});
				
				//ACTUALIZANDO LOS DATOS DE LA TABLA AL DAR CLIC EN TAB ADMINISTRAR PROVEEDORES
				$('#idAdministrarP').click(function(){
						$('#btnGuardarPro').show();
						$('#btnActualizar').hide();
						$('.provedor').each(function() {
	                    		$(this).val("");
	                	});
			           table.fnReloadAjax(); 
				});

			//EN DATATABLE

			//GUARDANDO DATOS DEL PROVEEDOR
			$('#prove').submit(function(e) {
				var datos=$('#prove').serialize();
				//alert(datos);
				$.ajax({
					type:"POST",
					data:datos,
					url:"FacPeticiones/regProveedorees.php",
					beforeSend: function(){
						$('#alertProveedor').html('<div class="alert alert-info alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  '<strong>¡Mensaje!</strong>Guardando...'+
														'</div>');
					},
					success: function(respuesta)
					{
						//alert(respuesta);
						$('#alertProveedor').html('<div class="alert alert-success alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  '<strong>¡Mensaje!</strong>Proveedor Registrado.'+
														'</div>');
						$('.provedor').each(function() {
                    		$(this).val("");
                		});
					},
					error: function(){
						$('#alertProveedor').html('<div class="alert alert-danger alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  '<strong>¡Mensaje!</strong>Operacion Fallida.'+
														'</div>');
					}
					
				});
            });
			 //END DATOS PROVEEDOR

            //CANCELANDO REGISTRO DE PROVEEDOR
            $('#btnCancelar').click(function(){
            	
           		if(confirm("¿Desea Cancelar El registro de Prveedor?"))
	            	{
	            		$('.provedor').each(function() {
	                    		$(this).val("");
	                	});
	                	$('#btnGuardarPro').show();
						$('#btnActualizar').hide();
						$('#alertProveedor').html('<div class="alert alert-warning alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  '<strong>¡Mensaje!</strong>Operacion Cancelada.'+
														'</div>');

	                }
            });
           ///END CACELAR REGISTRO PROVEEDOR
           //ACTUALIZANDO DATOS DE PROVEEDOR
           $('#btnActualizar').click(function(){
           		var datosP=$('#prove').serialize();
           		//alert(datosP);
           		$.ajax({
           			type:"POST",
           			data:datosP,
           			url:"FacPeticiones/actualizarDatos.php",
					beforeSend: function(){
						$('#alertProveedor').html('<div class="alert alert-success alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  '<strong>¡Mensaje!</strong>Actualizando datos !Por Favor Espere.¡.'+
														'</div>');

					},
           			success:function(respuesta){
           					
           				if(respuesta=="MENSAJE:")
           				{
							$('#alertProveedor').html('<div class="alert alert-success alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  '<strong>¡'+respuesta+'!</strong>Los datos se actualizaron con éxito.'+
														'</div>');
           					//alert(respuesta+'DATOS ACTUALIZADOS');
           					$('.provedor').each(function() {
								$(this).val("");
							});

           				}
           				else{
           					alert(respuesta);
           				}	

           			}
           		});

           });
           //END ACTUALIZAR DATOS PROVEEDOR
           //AGREGANDO DETALLE A FACTURA
           contador=0;//variable global para identificar a cada formulario
           $('#btnDetalle').click(function(){
           		var rowsD=$('#cantRow').val();
           		if(rowsD!="")
           		{
           			$('#cantRow').val("");
           			for(x=1;x<=rowsD;x++)
	           		{
	           			var rowDetalle="";
	           			contador+=1;
		           		rowDetalle+='<tr id="dRow'+contador+'"><td><input type="text" name="cantidad'+contador+'"  min="1" class="form-control number" placeholder="Cantidad" size="5"   required></td>';
		           		rowDetalle+='<td><input type="text" name="unidad'+contador+'" class="form-control" required></td>';
		           		rowDetalle+='<td><textarea name="descripcion'+contador+'" class="form-control" cols="40" rows="3" placeholder="Descripción" required></textarea></td>';
		           		rowDetalle+='<td><input type="text" name="pUnitario'+contador+'" min="1" class="form-control number2" placeholder="P.Unitario" size="5"  required></td>';
		           		rowDetalle+='<td><input type="text" name="ivaB'+contador+'" min="1" value="0.00" class="form-control number2" placeholder="IVA" size="5" required></td>';
		           		rowDetalle+='<td><input type="text" name="importe'+contador+'" min="1" value="0.00" class="form-control subtotal number2" placeholder="Importe" size="5" required></td>';
		           		rowDetalle+='<td><input type="text" name="ivaD'+contador+'" min="1" value="0.00" class="form-control total number2" placeholder="+IVA" size="5"></td>';
		           		rowDetalle+='<td><input type="button" value="-" class="btn btn-danger"  onclick="eliminarDetalleFac('+contador+');"></td></tr>';
		           		$('#tbDetalle').append(rowDetalle);
		           		
           			}
           			$('.number').number( true, 0);
           			// $('.number2').number( true, 2);


           		}
           		else
           		{
           			alert('Indique El Numero De Detalles');
           			$('#cantRow').focus();
           		}
           });
           //END DETALLE FACTURA
           
           //CANCELANDO FACTURA
           $('#btnCancelarFac').click(function(){
           		if(confirm("Desea Cancelar Esta Factura"))
           		{
           			$('#tbDetalle').empty();
	           		contador=0;
	           		$('#slPro option')[0].selected = true;//SELECCIOANDNO AL INDICE CERO DEL SELECT PROVEEDORES
	           		$('#slPartidaFac option')[0].selected = true;
	           		//LIMPIANDO ELEMENTOS DEL FORM
	           		$('#folioFac').val("");
	           		$('#serieFac').val("");
	           		$('#fechaFac').val("");
	           		$('#proyectoFac').val("");
	           		$('#total').html('<h3>Subtotal:$0.00 m/n </h3><h3>Total:$0.00 m/n</h3>');
	           		totalI=0.0;//guardara importe din iva
					totalFN=0.0;//guardara importe con iva
					$('#alertSaveFac').html('<div class="alert alert-warning alert-dismissable">'+
										  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
										  '<strong>!La factura ha sido cancelada¡</strong></div>');

           		}

	           		
           })
           //END CANCELADNO FACTURA
           //GUARDANDO FACTURA
           $('#nFactura').submit(function(e){
           		if($('.total').length==0)
           		{
					$('#alertSaveFac').html('<div class="alert alert-warning alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  '!La Factura No Tiene Detalles¡</div>');
					
           			//alert('no hay detalles en factura');
           		}
           		else
           		{
           			$('input[name=subT]').val($.number(totalI,2));
           			$('input[name=total]').val($.number(totalFN,2));
           			//var nuevaFac=$('#nFactura').serialize();
           			//alert(nuevaFac);
					var formData = new FormData($("#nFactura")[0]);
           			
           			$.ajax({
						url:"FacPeticiones/registroFac.php",
						type:"POST",
						data: formData,
						//necesario para enviarFormulario
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function()
						{
							$('#alertSaveFac').html('<div class="alert alert-info">Guardando !! Por Favor Espere.</div>');
						},
						success: function(respuesta)
						{
							// alert(respuesta);
							if(respuesta=="MENSAJE.")
							{
								$('#alertSaveFac').html('<div class="alert alert-success alert-dismissable">'+
														  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
														  'Guardado Éxito</div>');
								$('#tbDetalle').empty();
								contador=0;
								$('#slPro option')[0].selected = true;//SELECCIOANDNO AL INDICE CERO DEL SELECT PROVEEDORES
								$('#slPartidaFac').empty();
								//LIMPIANDO ELEMENTOS DEL FORM
								$('#folioFac').val("");
								$('#serieFac').val("");
								$('#fechaFac').val("");
								$('#proyectoFac').val("");
								$('#total').html('<h3>Subtotal:$0.00 m/n </h3><h3>Total:$0.00 m/n</h3>');
								totalI=0.0;//guardara importe din iva
								totalFN=0.0;//guardara importe con iva
								$('#notPen').html('12');
								$('#busquedaPartidaFac').val("");
							}
						}
					});
           			
           		}
           		//alert(totalFN);
           });
           //END GUARDANDO FACTURA
         
		//end proveedores y facturas

		//DAR SALIDA FINANCIEROS
			//CARGADNO PARTIDAS 
				$("#idPartida").ready(function(){
					$.ajax({
						type:"POST",
						dataType:"json",
						url:"FacPeticiones/partidas.php",
						success:function(respuesta){

							for(i=0;i<respuesta.length;i++)
							{
								$('#idPartida').append('<option value="'+respuesta[i].pkPartida+'" data-indice="'+i+'">'+respuesta[i].numeroPartida+'</option>');

							}
							$('#idPartida').change(function(){
								var indicePartida=$('#idPartida option:selected').attr('data-indice');
								$('#descripcionPartida').val(respuesta[indicePartida].Partida);
							});
						}
					})
				});
			//FIN CARGA DE PARTIDAS
			//CANCELANDO PAGO DE FACTURA
			$('#salidaCancelar').click(function(){
				if(confirm("Desea borrar los datos de este pago"))
				{
					$('#idPartida option')[0].selected = true;
					$('#descripcionPartida').val("");
					$('.salidaFac').each(function(){
						$(this).val("");
					});
					$('#pagoFac').empty();
					$('#alertFinancieros').html('<div class="alert alert-warning alert-dismissable">'+
												  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
												  '<strong>¡Factura Cancelada!</strong>.'+
												'</div>');
		
					}
							//alert('Pago Cancelado');
			});
			// FIN CANCELADO DE FACTURA
			// GUARDADNDO DATOS DE PAGO
			$('#formPago').submit(function(){
				if($('.tablaPago').length==0)
				{
					$('#alertFinancieros').html('<div class="alert alert-warning alert-dismissable">'+
												  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
												  '<strong>¡Por Favor Elija Una Factura!</strong>.'+
												'</div>');
				}
				else
				{

					datos=$("#formPago").serialize();
					alert(datos);	

					var formData = new FormData($("#formPago")[0]);
					$.ajax({
						url:"FacPeticiones/registroPago.php",
						type:"POST",
						data: formData,
						//necesario para enviarFormulario
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function(){
							$('#alertFinancieros').html('<div class="alert alert-info alert-dismissable">'+
												  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
												  '<strong>¡Por Favor Espere!</strong>Guardando...'+
												'</div>');
						},
						success: function(respuesta)
						{
							alert(respuesta);
							$('#idPartida option')[0].selected = true;
							$('#descripcionPartida').val("");
							$('.salidaFac').each(function(){
								$(this).val("");
							});
							$('#pagoFac').empty();
							$('#alertFinancieros').html('<div class="alert alert-success alert-dismissable">'+
												  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
												  '<strong>¡Operacion Exitosa!</strong>.'+
												'</div>');
							//alert(respuesta);
						},
						error: function(){
							$('#alertFinancieros').html('<div class="alert alert-danger alert-dismissable">'+
												  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
												  '<strong>¡Operacion Fallida!</strong>.'+
												'</div>');
						}
					
					});
				}
			});
			// FIN GUARDADO PAGO DE FACTURA
		//BOTON DE EXPORTAR A EXCEL
		$('#btnExcel').click(function(){
			$("#datos_a_enviar").val( $("<div>").append( $("#tbAdminFac").eq(0).clone()).html());
     		$("#FormularioExportacion").submit();
		});
		//FIN BOTON DE EXPORTAR A EXCEL



		//cancleadno la partida
		$('#cancelarPartida').click(function(){
			if(confirm('¿Desea cancelar la partida?')){
				$('#idNumPar').val("");
				$('#idDescripcionPar').val("");
				}
		});

});

function darSalida(id)
{
	$('#idPartida option')[0].selected = true;
				$('#descripcionPartida').val("");
				$('.salidaFac').each(function(){
					$(this).val("");
				});
				$('#pagoFac').empty();
	$.ajax({
			type:"POST",
			dataType:"json",
			data:{opcion:4,id:id},
			url:"FacPeticiones/tbFac.php",
			success:function(respuesta){
				// alert(respuesta);
				$('input[name=idFac]').attr('value',id)
				$('#pagoFac').html("<tr class='tablaPago'><td>"+respuesta['folio']+"</td><td>"+respuesta.serie+"</td><td>"+respuesta.proveedor+"</td><td>"+respuesta.subtotal+"</td><td>"+respuesta.total+"</td><td>"+respuesta.fecha+"</td></tr>");
				//ACTIVANDO EL TAB DE FORMULARIO PROVEEDOR
				$('#idDarSalida').tab('show');
				$('#idProyecto').val(respuesta['proyecto']);
				$('#idPartida > option[value="'+respuesta['partida']+'"]').attr('selected', 'selected');
				$('#descripcionPartida').val(respuesta['descripcion']);			
			}

		});
}
//CALCULANDO IMPORTE DEL DETALLE	
function importe(id,tipo)
{
	
	//REALIZANDO CALCULOS DE IMPORTE,IVA,IMPORTE MAS IVA

	cantidad=$('input[name=cantidad'+id+']').val();//obteniendo valor de cantidad
	pUnitario=$('input[name=pUnitario'+id+']').val();//obteniendo valor de Precio Unitario

	iva=pUnitario*0.16;//obteninedo el iva a 16%
	iva=iva.toFixed(2);//REDONDENADO IVA A DOS DECIMALES

	cImporte=(cantidad*pUnitario);//calculando importe sin iva
	masIva=cImporte+(cantidad*iva);//calculando importe mas iva
	//REDONDENADO IMPORTE E IMPORTE(+)IVA
	cImporte=cImporte.toFixed(2);
	masIva=masIva.toFixed(2);

	//COLOCANDO CALCULOS EN CAMPOS IVA, IMPORTE, IMPORTE+IVA

	cantidad=parseFloat($('input[name=cantidad'+id+']').val());
	pUnitario=parseFloat($('input[name=pUnitario'+id+']').val());
	iva=pUnitario*0.16;

	cantidad=cantidad.toFixed(2);
	pUnitario=pUnitario.toFixed(2);
	iva=iva.toFixed(2);
	
	cImporte=(cantidad*pUnitario);
	masIva=(cImporte+(cantidad*iva));
	masIva=masIva.toFixed(2);

	//COLOCANDO CALCULOS EN CAMPOS IVA, IMPORTE, +IVA

	$('input[name=ivaB'+id+']').val(iva);
	$('input[name=importe'+id+']').val(cImporte);
	$('input[name=ivaD'+id+']').val(masIva);

	//CALCULANDO Y MOSTRNADO TOTALES

	totalImporte=0.0;//guardara importe din iva
	totalFinal=0.0;//guardara importe con iva
	
	//OBTENIENDO TODOS LOS IMPORTES
	$('.subtotal').each(function(){
		var sub=parseFloat($(this).val());//OBTENIENDO EL VALOR DE TODOS LOS IMPORTES
		totalImporte=totalImporte+sub;//SUMANDO TODOS LOS IMPORTES
		totalI=totalImporte.toFixed(2);
		//totalImporte=totalImporte.toFixed(2)//REDONDENDO A DOS DECIMALES EL TOTAL
	});
	//OBTENIENDO TODOS LOS IMPORTES +IVA
	$('.total').each(function(){
		var totalF=parseFloat($(this).val());//OBTENIENDO TODOS LOS IMPORTES
		totalFinal=totalFinal+totalF;//SUMANDO TODOS LOS IMPORTES
		totalFN=totalFinal.toFixed(2);
		//totalFinal=totalFinal.toFixed(2);//REDONDEANDO A DOS DECIMALES EL TOTAL
	});
	//AL AGREGAR LAS CANTIDADES Y PRECIOS UNITARIOS SE MOSTRARA AUTOMATICAMENTE EL TOTEL DE A PAGAR
	if(tipo==1)
	{
		$('#total').html('<div style="margin-top:-1.5%;"><h3>Subtotal:$'+$.number(totalI,2)+' m/n</h3><h3>Total:$'+$.number(totalFN,2)+' m/n</h3></div>');
	}
	else if(tipo==2)
	{
		$('#modTotal').html('<div style="margin-top:-1.5%;"><h3>Subtotal:$'+$.number(totalI,2)+' m/n</h3><h3>Total:$'+$.number(totalFN,2)+' m/n</h3></div>');	
	}
	           
}
//fin IMPORTE DEL DETALLE	

//ELIMINANDO DETALLE FACTURA
function eliminarDetalleFac(id)
{
	//alert('eliminar');
		var menosSubtotal=0.0;
		var menosTotal=0.0;
		menosSubtotal=$('input[name=importe'+id+']').val();
		menosTotal=$('input[name=ivaD'+id+']').val();

		totalI-=menosSubtotal;
		totalFN-=menosTotal;

		totalI=totalI.toFixed(2);
		totalFN=totalFN.toFixed(2);
		//ACTUALIZANDO TOTAL
		$('#total').html('<h3>Subtotal: $'+$.number(totalI,2)+' m/n</h3><h3>Total:$'+$.number(totalFN,2)+' m/n</h3>');
		$('#dRow'+id).remove();
}
//END ELIMINADNO EL DETALLE DE LA FACTURA

//funcion que edita los datos del proveedor
function modificarRow(id,tabla,columna,url)
{
	$.ajax({
			type:"POST",
			dataType:"json",
			data:{id:id,tabla:tabla,columna:columna},
			url:"FacPeticiones/"+url,
			success:function(respuesta){
				//BORRANDO VALORES DE FORMULARI PROVEEDOR
				$('.provedor').each(function() {
					$(this).val("");
				});
				//ACTIVANDO EL TAB DE FORMULARIO PROVEEDOR
				$('#nuevoPro').tab('show');
				//OCUTANDO BTN GUARDAR Y MOSTRANDO ACTUALIZAR
				$('#btnGuardarPro').hide();
				$('#btnActualizar').show();
				//COLOCANDO DATOS EN FORMULARIO
				$('input[name=nombrePro]').val(respuesta[1]);
				$('input[name=rfcPro]').val(respuesta[2]);
				$('input[name=dirPro]').val(respuesta[3]);
				$('input[name=telPro]').val(respuesta[4]);
				$('input[name=idPro]').val(respuesta[0]);

			}

		});
	
}

//funcion borrarPro. esta funcin elimina al proveedor espesificado, de la tabla de proveedores
function borrarRow(id,tabla,columna,url)
{
	if(confirm('Confirme que desea eliminar este dato'))
	{
		$.ajax({
			type:"POST",
			data:{id:id,tabla:tabla,columna:columna},
			url:"FacPeticiones/"+url,
			success:function(respuesta){
				table.fnReloadAjax(); 
			}

		});
	}
	else
	{
		alert('operacion cancelda');
	}
}		

function editar(id,archivo)
{
	if(archivo=='usuario')
	{
		$('#content').load('EditUsuarios.php?id='+id);
	}
	else if(archivo=='cargo')
	{
		$('#content').load('EditCargos.php?id='+id);
	}
	else if(archivo=='categoria')
	{
		$('#content').load('EditCategorias.php?id='+id);
	}
	else if(archivo=='marca')
	{
		$('#content').load('EditMarcas.php?id='+id);
	}
	else if(archivo=='departamento')
	{
		$('#content').load('EditDepartamentos.php?id='+id);
	}
	else if(archivo=='empleado')
	{
		$('#content').load('EditEmpleados.php?id='+id);
	}
	else if(archivo=='categoriaSoftware')
	{
		$('#content').load('EditSCategorias.php?id='+id);
	}
	else if(archivo=='inventariogeneral')
	{
		$('#content').load('EditInvGeneral.php?id='+id);
	}
	else if(archivo=='inventariodetalle')
	{
		$('#content').load('EditInvDetalle.php?id='+id);
	}
	else if(archivo=='inventariosoftware')
	{
		$('#content').load('EditSoftware.php?id='+id);
	}
	else if(archivo=='autoriza')
	{
		$('#content').load('EditAutoriza.php?id='+id);
	}
	else if(archivo=='ubicacion')
	{
		$('#content').load('EditUbicaciones.php?id='+id);
	}
}
function Cargos()
{
	//alert("hola");
	$('#content').load('cargos.php');
}
function Categorias()
{
	//alert("hola");
	$('#content').load('categorias.php');
}
function Marcas()
{
	//alert("hola");
	$('#content').load('marcas.php');
}
function RegArticulos()
{
	//alert("hola");
	$('#content').load('RegistarArticulos.php');
}
function Invgeneral()
{
	//alert("hola");
	$('#content').load('inventariogeneral.php');
}
function Usuarios()
{
	//alert("hola");
	$('#content').load("usuarios.php");
}
function Departamentos()
{
	//alert("hola");
	$('#content').load('departamentos.php');
}
function Empleados()
{
	//alert("hola");
	$('#content').load('empleados.php');
}
function Ubicaciones()
{
	//alert("hola");
	$('#content').load('ubicaciones.php');
}

function Asignaciones()
{
	//alert("hola");
	$('#content').load('asignaciones.php');
}
function sCategorias()
{
	//alert("hola");
	$('#content').load('scategorias.php');
}
function inventarioDetalles()
{
	//alert("hola");
	$('#content').load('inventariodetalle.php');
	
}
function inventarioBajas()
{
	//alert("hola");
	$('#content').load('inventariobajas.php');
	
}
function bajas()
{
	$('#content').load('crearBajas.php');
	
}
function bajasConsumible()
{
	$('#content').load('bajasConsumibles.php');
}
function autoriza()
{
	//alert("hola");
	$('#content').load('autoriza.php');
}
function eliminar(id,valor,tabla,campo,archivo)
{
	if(confirm('Esta Apunto de Eliminar a:'+valor+'.\n¿Desea Continuar?'))
	{
		$('#content').load('eliminar.php?id='+id+'&tabla='+tabla+'&campo='+campo+'&archivo='+archivo);
	}
	else
	{
		alert('Usted ha Cancelado Esta Operacion.');
	}

}
function confirmarpass()
{
	var pass=document.getElementById('uPass').value;
	var passr=document.getElementById('uPassR').value;
	if (passr!=pass){alert('Su contraseña no coincide');
		document.getElementById('uPassR').value='';
	}	
}
function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which; 
  return (tecla!=13); 
}
function articulos(datos)
{
	alert (datos);
}

function generarCodigos()
{
	$(document).ready(function(e)
		{
        	$(" .generar").each(function(i){
       			var titulo = $(this).attr("title");
       			$(this).barcode(titulo, "codabar",{barWidth:1.5, barHeight:30});
				//alert("Atributo title del enlace " + i + ": " + titulo);
    		});
		});
}
function agregarArticulos()
{
	//creando variables paa asgnar los equipos
	var codigo=$('#agregarProducto').val();
	
	
	//var arreglo=new Array();
	//alert(codigo);
	
	//consultando y obteniendo los datos del equipo
	$.ajax({
		type:'post',
		dataType:"json",
		data:{opcion:codigo},
		url:'codigoAsignado.php',
		cache:false,
		success: function(respuesta)
		{	
			if(respuesta[0]=="asignado")
			{
				$('#agregarProducto').val("");
				alert("Este Equipo No Esta Disponible :(");
			}
			else if(respuesta[0]=="inexistente")
			{
				$('#agregarProducto').val("");
				alert("Este Codigo No Esta Registrado");
			}
			else
			{
				if($('#codigo'+respuesta[0]).length==0)
				{
					$('#agregarProducto').val("");
					$('#articulos').append('<tr id="codigo'+respuesta[0]+'" class="impreso"><td><input type="hidden" name="equipo'+respuesta[0]+'" value="'+respuesta[0]+'"/>'+respuesta[1]+'</td><td style="width:150px;"><div style="overflow-x:scroll; width:150px">'+respuesta[2]+'</div></td><td>'+respuesta[3]+'</td><td>'+respuesta[4]+'</td><td>'+respuesta[5]+'</td><td><select class="ubicacion form-control" name="ubicacion'+respuesta[0]+'" id="ubicacion'+respuesta[0]+'" required><option></option></select></td><td><button class="btn btn-danger" type="button" onClick="eliminarArticulo(\'codigo'+respuesta[0]+'\');">&nbsp;<span class="glyphicon glyphicon-minus"></span>&nbsp;</boton></td></tr>');
					agregarUbicaciones(respuesta[0]);
				}
				else
				{
					$('#agregarProducto').val("");
					alert('Este Equipo Ya Esta En  Su Lista.');
				}
			}
		}
		});
		
}

function agregarUbicaciones(id)
{
	$.ajax({
		type:'post',
		dataType:"json",
		data:{opcion:'llenar_form'},
		url:'ubicacionesBD.php',
		cache:false,
		success: function(respuesta)
		{	
			var ubicaciones="";
			for(x=0;x<respuesta.length;x++)
			{
				ubicaciones+='<option value=\''+respuesta[x].pk_ubicacion+'\'>'+respuesta[x].nomubicacion+'</option>';
			}
			$('#ubicacion'+id).append(ubicaciones);
		}
		});

}

//funcion para agregar equipos a la lista de baja
function agregarArticulosBajas()
{
	//creando variables paa asgnar los equipos
	var codigo=$('#agregarProductoBaja').val();
	//var arreglo=new Array();
	//alert(codigo);
	
	//consultando y obteniendo los datos del equipo
	$.ajax({
		type:'post',
		dataType:"json",
		data:{opcion:codigo},
		url:'codigoAsignado.php',
		cache:false,
		success: function(respuesta)
		{	
			if(respuesta[0]=="asignado")
			{
				$('#agregarProductoBaja').val("");
				alert("Este Equipo No Esta Disponible :(");
			}
			else if(respuesta[0]=="inexistente")
			{
				$('#agregarProductoBaja').val("");
				alert("Este Codigo No Esta Registrado");
			}
			else
			{
				if($('#codigo'+respuesta[0]).length==0)
				{
					$('#agregarProductoBaja').val("");
					$('#articulos').append('<tr id="codigo'+respuesta[0]+'" class="impreso"><td><input type="hidden" name="equipo'+respuesta[0]+'" value="'+respuesta[0]+'"/>'+respuesta[1]+'</td><td style="width:150px;"><div style="overflow-x:scroll; width:150px">'+respuesta[2]+'</div></td><td>'+respuesta[3]+'</td><td>'+respuesta[4]+'</td><td>'+respuesta[5]+'</td><td><textarea class="motivo form-control" name="motivo'+respuesta[0]+'" cols="50" rows="3" required="required"></textarea></td><td><button class="btn btn-danger" type="button" onClick="eliminarArticulo(\'codigo'+respuesta[0]+'\');">&nbsp;<span class="glyphicon glyphicon-minus"></span>&nbsp;</boton></td></tr>');
				}
				else
				{
					$('#agregarProductoBaja').val("");
					alert('Este Equipo Ya Esta En  Su Lista.');
				}
			}
		}
		});
		
}

function eliminarArticulo(id)
{
	$('#'+id).remove();
}

function evalaListaArticulos()
{
	
   		if($('.impreso').length)
		{	
			
		}
		else
		{
			alert("lista vacia");
			return false;
		}
}
function asignacionDetalle(idAsignacion)
{
	//$('#asignacionDetalle').append(idAsignacion);
	$.ajax({
		type:'post',
		dataType:"json",
		data:{opcion:idAsignacion},
		url:'asignacionDetalle.php',
		cache:false,
		success: function(respuesta)
		{	
			var tabla='<thead><tr class="active"><th>Codigo</th><th>Categoria</th><th>Marca</th><th>Modelo</th><th>Ubicacion</th><th>Asigno</th><th>Fecha de asignacion</th><th><center><span class="glyphicon glyphicon-hdd"></span></center></th><th><center><span class="glyphicon glyphicon glyphicon-check"></span><input type="checkbox" onclick="marcar(this);" /></center></th></tr></thead>';
			var cuerpoTabla;
			var i=0;
			while(i<respuesta.length-1)
			{
				var categoria = respuesta[i][1];
				res1=categoria.replace(/\s/g,'');
				res2=res1.toLowerCase();
				//alert(res2);
				if(res2=="pc" | res2=="cpu" | res2=="c.p.u." | res2=="laptop" | res2=="computadora" | res2=="netbook"  | res2=="notebook" | res2=="p.c")
				{
					cuerpoTabla+="<tr><td>"+respuesta[i][0]+"</td><td>"+respuesta[i][1]+"</td><td>"+respuesta[i][2]+"</td><td>"+respuesta[i][3]+"</td><td>"+respuesta[i][6]+"<td>"+respuesta[i][7]+"</td><td>"+respuesta[i][4]+"</td></td><td><button class='btn btn-link' type='button'  value='S' OnClick=\"detalleSoftware('"+respuesta[i][5]+"');\"><span class='glyphicon glyphicon-eye-open'></span></button></td><td><center><input type='checkbox' name='equipos[]' value='"+respuesta[i][5]+"'/></center></td></tr>";
				}
				else
				{
					cuerpoTabla+="<tr><td>"+respuesta[i][0]+"</td><td>"+respuesta[i][1]+"</td><td>"+respuesta[i][2]+"</td><td>"+respuesta[i][3]+"</td><td>"+respuesta[i][6]+"</td><td>"+respuesta[i][7]+"</td><td>"+respuesta[i][4]+"</td><td></td><td><center><input type='checkbox' name='equipos[]' value='"+respuesta[i][5]+"'/></center></td></tr>";
				}
				i++;
			}
			var label1="<label>Departamento:</label>";
			var label2="<label>Empleado:</label>";
			label1+=respuesta[i][0]+"<br>";
			label2+=respuesta[i][1]+"<br>";
			var pkAsignacion=respuesta[i][2];
			
			$('#infoEmpleado').append(label1);
			$('#infoEmpleado').append(label2);
			$('#infoEmpleado').append("<input type='hidden' name='pkAsignacion' value='"+pkAsignacion+"'/>");
			$('#infoEmpleado').append("<a type='button' class='btn btn-info' id='rEquipos' onClick='todosEquipos("+pkAsignacion+")'>Reporte Equipos</a>");
			tabla+=cuerpoTabla;
			$('#equiposAsignados').append(tabla);

			//alert(respuesta.length);
		}
		});
}

//funcion que me muestra los programs que tien la PC
function detalleSoftware(pc)
{
	
	$('#ocultar').hide('slow');//oculta el div conid ocultar
	$('#hola').show('slow');//muestra el div con id hola
	
	//obteneindo los programs de esta pc
	$.ajax({
		type:'post',
		dataType:"json",
		data:{opcion:pc},
		url:'pcProgramas.php',
		cache:false,
		success: function(respuesta)
		{	
			var tabla='<thead><tr class="active"><th>Software</th><th>Codigo Activacion</th><th>Quitar</th></tr></thead>';
			var cuerpoTabla;
			var i=0;
			while(i<respuesta.length-1)
			{
				cuerpoTabla+="<tr><td>"+respuesta[i][0]+"</td><td>"+respuesta[i][1]+"</td><td><center><input type='checkbox' name='software[]' value='"+respuesta[i][2]+"'/></center></td></tr>";
				i++;
			}
			
			var label1="<label>Informacion Equipo:</label>";
			/*label1+=respuesta[i][0]+"<br>";
			label2+=respuesta[i][1]+"<br>";
			var pkAsignacion=respuesta[i][2];*/
			
			$('#infoPC').append(label1);
			tEquipo="<table class='table'><tr class='active'><th>Codigo</th><th>No. Serie</th><th>Modelo</th><th>Marca</th><th>Categoria</th></tr><tr class='warning'><td>"+respuesta[i][0]+"</td><td>"+respuesta[i][1]+"</td><td>"+respuesta[i][2]+"</td><td>"+respuesta[i][3]+"</td><td>"+respuesta[i][4]+"</td></tr></table>";
			//tEquipo="<table><tr><th>"+respuesta[i][0]+"</th><th>No. Serie</th><th>Modelo</th><th>Marca</th><th>Categoria</th></tr>";
			$('#infoPC').append(tEquipo);
			$('#infoPC').append("<center><button type='button' class='btn btn-info' id='rSoftware' onClick='softwarePdf("+respuesta[i][5]+")'>Reporte Software</button>&nbsp; &nbsp;<a type='button' class='btn btn-success' href='asignarSoftware.php?pc="+respuesta[i][5]+"'>Asignar Software</a></center>");
			
			tabla+=cuerpoTabla;
			$('#softwarePC').append(tabla);
		}
		});
	
}

function softwarePdf(pc)
{
	window.open('../pdf/todosSoftwarePdf.php?equipo='+pc,'_blank');
}
//aqui termina la funcion detallesoftware

// En esta funcion se debera regresar a los equipos y borrar el conteido de la tabla e informaion de la PC
function equipos()
{
	$('#ocultar').show('slow');
	$('#hola').hide('slow');
	$('#infoPC').empty();
	$('#softwarePC').empty();
}
//aqui termina la funcion equipo
function vaciarDiv()
{
	$('#infoEmpleado').empty();
	$('#infoPC').empty();
	$('#equiposAsignados').empty();
	$('#ocultar').show();
	$('#hola').hide();
	$('#softwarePC').empty();
}
function marcar(source) 
    {
        checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
        for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
        {
            if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
            {
                checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
            }
        }
    }
	
	//generarpdf de codigos
function mostrar()
{
	var doc = new jsPDF();
	doc.text(20, 20, 'Hola Mundo');
	
// Save the PDF
		doc.save("hola.pdf")
		//var texto=$('#codigos').html();
		//alert("hola");	
}

function ventanaSecundaria(url)
{
	window.open(url,"ventana1","width=120,height=300,scrollbars=NO");
}
//mandando codigos y numeros de serie al pdf
function valoresPDF()
{	

	$('input[type=submit]').removeAttr('disabled');
	codigos=$("input[name*='codigo']").serialize();
	series=$("input[name*='serie']").serialize();
	
	window.open('../pdf/nuevosCodigos.php?'+codigos+'&'+series,'_blank');
}
function reporteBaja()
{

	if($('.impreso').length==0 )
	{
		alert('Aún no hay equipos en la lista.');
	}
	else if($('#foliobaja').val()=="")
	{
		alert('Lléne el campo folio.');
	}
	else if($('#autoriza').val()=="")
	{
		alert('Lléne el campo autoriza.');
	}
	else
	{
		centinela=0;
		$('.motivo').each(function() {
            if($(this).val()=="")
			{
				centinela++;
			}	
        });
		
		if(centinela!=0)
		{
			alert('Te Hace Falta Por Llenar:'+centinela+'-motivo(s)');
		}
		else
		{
			formBaja=$('form').serialize();
			window.open('../pdf/bajaPdf.php?'+formBaja,'_blank');
			$('input[type=submit]').removeAttr('disabled');
		}
	}
}
//funcion para genrar el reporte de nuevas asignaciones
function nuevaAsignacion()
{
	if($('.impreso').length==0 )
	{
		alert('Aún no hay equipos en la lista.');
	}
	else if($('#folioasignacion').val()=="")
	{
		alert('Lléne el campo folio.');
	}
	else
	{
		centinela=0;
		$('.ubicacion').each(function() {
            if($(this).val()=="")
			{
				centinela++;
			}	
        });
		
		if(centinela!=0)
		{
			alert('Te Hace Falta Por Llenar:'+centinela+'-ubicacion(s)');
		}
		else
		{
			formBaja=$('form').serialize();
			window.open('../pdf/asignacionPdf.php?'+formBaja,'_blank');
			$('input[type=submit]').removeAttr('disabled');
		}
	}
}
//funcion para generar reporte de devoluciones
function devoluciones()
{
	//formBaja=$('form').serialize();
	asignacion=$('input[name=pkAsignacion]').val();
	equipoCH=$('input[name="equipos[]"]').serialize();
	if(equipoCH)
	{
		window.open('../pdf/devolucionPdf.php?pkasignacion='+asignacion+'&'+equipoCH,'_blank');
		$('#quitar').removeAttr('disabled');
	}
	else
	{
		alert("No selecciono ningun equipo");
	}
	//alert(equipoCH);
}

//imprimiendo todos loa equipos
function todosEquipos(pkAsignacion)
{
	
	//alert('hola');
	window.open('../pdf/todosEquiposPdf.php?pkasignacion='+pkAsignacion,'_blank');
	//alert(pkAsignacion);
}
//genera pdf de los software instaldos al momento
function softwareMomento(pc)
{
	var check = $("input[type='checkbox']:checked").length;
	
	if(check!=" ")
	{
		equipoCH=$('form').serialize();
		window.open('../pdf/programasInstaladosPdf.php?'+equipoCH,'_blank');
		$('input[type=submit]').removeAttr('disabled');
	}
	else
	{
		alert("Al menos seleccione un software de la lista");
	}
	
}
//pdf de equipo individual codigo de barra
function codigoDetalle(codigo,serie)
{
	window.open('../pdf/codigoBarraDetalle.php?codigo='+codigo+'& serie='+serie,'_blank');
}

//FUNCION QUE PERMITE PONER LA CANMTIDAD Y DESCRIPCION DEL ARTICULO AL MOMENTO DE INVENTARIAR
function inventariar(idDetalle,detalleCantidad,detalleDescripcion)
{
	$('#detalle').val(detalleDescripcion);
	$('#cantidadR').val(detalleCantidad);
	$('#xinventariar').val(idDetalle);
}
function actualizarinvgeneral()
{
	//alert(' actualizando');
	location.href="inventariogeneral.php";	
}

//Gguardando las partidas
function guardarPartidas()
{
	//alert('guardando las partidas');
	var numPartida=$('#idNumPar').val();
	var desPar=$('#idDescripcionPar').val();
	if(numPartida!="" && desPar!="")
	{
		$.ajax({
			url:"guardarPartidas.php",
			type:"POST",
			data:{partida:numPartida,descripcion:desPar},
			beforeSend: function()
			{
				$('#alertPartida').html('<div class="alert alert-info">Guardando Factura!! Por Favor Espere.</div>');
			},
			success: function(respuesta)
			{
				//alert(respuesta);
				if(respuesta!=1)
				{
					$('#alertPartida').html('<div class="alert alert-danger alert-dismissable">'+
					  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
					  '<strong>¡Error!</strong> Esta Partida Ya Ha Sido Guardada.'+
					'</div>');
				}
				else 
				{
					$('#alertPartida').html('<div class="alert alert-success alert-dismissable">'+
					  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
					  '<strong>¡Exito!</strong>Partida Guardada.'+
					'</div>');		
				}
				resetearPartida();
			}
		});
	}
}


// FUNCION QUE BUSCA LA PARTIDA PARA MOSTRAR SUS DATOS Y MODIFICARLA
function busquedaPartida()
{
	busqueda=$('#campoBusqueda').val();
	if(busqueda!="")
	{
		$.ajax({
			url	:"FacPeticiones/busquedaPartida.php",
			type:"POST",
			data:{busqueda:busqueda},
			dataType:'json',
			beforeSend:function(){
				$('#edicionPartida').html('procesando...');
			},
			success:function(respuesta){
				if(respuesta==null || respuesta=="")
					$('#edicionPartida').html('No se econtro');
				partida="<form onsubmit='return false'><div class='form-group input-group col-md-6 col-md-offset-1'><span class='input-group-addon'>&nbsp;Numero Partida&nbsp;</span><input type='text' id='edNumPartida' class='form-control' value='"+respuesta[1]+"' required></div>"
				+"<div class='form-group input-group col-md-6 col-md-offset-1'><span class='input-group-addon'>Descripcion</span><textarea id='idDesPartida' class='form-control' required>"+respuesta[2]+"</textarea></div>"
				+"<input type='hidden' id='partidaMod' value='"+respuesta[0]+"'>"
				+"<div class'col-md-6 col-md-offset-1'><input type='submit' value='Guardar' class='btn btn-success' onclick='modificarPartida();'><input type='button' class='btn btn-danger'  onclick='cancelarModPartida();' value='Cancelar'></div></form>";
				$('#edicionPartida').html(partida);

				a="<div class='form-group input-group col-md-6 col-md-offset-1'>"+
				"<span class='input-group-addon'>Descripcion</span>";
				// $('#campoBusqueda').val("");

			},
			error:function(){
				$('#edicionPartida').html('¡La partida no existe!');
			}
		});
		// <div class="form-group input-group col-md-6 col-md-offset-1">
  //                              <span class="input-group-addon">&nbsp;Numero Partida&nbsp;</span>
  //                              <input class="form-control"  placeholder="Numero Partida" type="text" id="campoBusqueda" required>
  //                           </div>
	}
}
function modificarPartida()
{
	numPartida=$('#edNumPartida').val();
	desPartida=$('#idDesPartida').val();
	pkpartida=$('#partidaMod').val();

	if(numPartida!="" && desPartida!="")
	{
		//alert(numPartida+"-"+desPartida);
		$.ajax({
			url:"FacPeticiones/modificarPartida.php",
			type:"POST",
			data:{partida:numPartida,descripcion:desPartida,pk:pkpartida},
			beforeSend:function(){
				$('#alertModificarPar').html('<div class="alert alert-info">Modificando Partida!! Por Favor Espere.</div>');
			},
			success:function(respuesta){

				if(respuesta==1)
				{
					$('#alertModificarPar').html('<div class="alert alert-success alert-dismissable">'+
						  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						  '<strong>¡Exito!</strong> Partida Modificada.'+
						'</div>');				
				}
				else
				{
					$('#alertModificarPar').html('<div class="alert alert-danger alert-dismissable">'+
						  '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						  '<strong>¡Error!</strong> Al Actualizar la Partida.'+
						'</div>');
				}
				editResetPertida();
			}
		});
	}
}
function cancelarModPartida()
{
	if(confirm("Desea Canclar La Modificacion"))
	{
		editResetPertida();
	}
}
function editResetPertida()
{
	$('#edNumPartida').val("");
	$('#idDesPartida').val("");
}

function listarproveedores()
{
	$.ajax({
		type:"POST",
		data:{opcion:1},
		dataType:"json",
		url:"FacPeticiones/tablaProveedores.php",
		success:function(respuesta){
			$('#modSlPro').empty();
			$('#modSlPro').append("<option value=''>Seleccione un Proveedor...</option>");
			for(y=0;y<=respuesta.length;y++)
			{
				$('#modSlPro').append("<option value='"+respuesta[y][4]+"'>"+respuesta[y][0]+"</option>");
			}
		}
	});
}
function agregandoPartidaFac()
{
	valor = $('#busquedaPartidaFac').val();
	$.ajax({
		type:"POST",
		dataType:"json",
		url:"FacPeticiones/agregandoPartida.php",
		data:{param1:valor},
		success:function(respuesta){
			if (respuesta=="error") {
				alert("¡La partida no existe!");
			} else{
				$('#slPartidaFac').append('<option value="'+respuesta[0]+'" selected>'+respuesta[1]+'</option>');
			};
		},
		error:function()
		{
			alert('error');
		}
	});
}