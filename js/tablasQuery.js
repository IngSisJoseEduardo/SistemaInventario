/*
EN ESTE SCRIPT ESTARAN DISPONOBLES TODAS LAS FUNCIONES RELACIANDAS A 
LAS TABLAS,EXCEPTUADNO LA TABLA DE PROVEEDORES. MAS ESPESIFICAMENTE TODOS LOS DATATABLES
Y SUS CORREPONDIENTES FUNCIONES ADICIONALES
*/
//TABLA DE admiFactura
/* Formatting function for row details - modify as you need */
$('#tbAdminFac').ready(function() {//INICIO DE TABLA PENDINETES DE MATERIALES

    matpen=$('#tbAdminFac').dataTable( {
                      "columns": [
		            { "data": "folio" },
		            { "data": "serie" },
		            { "data": "proveedor" },
		            { "data": "subtotal" },
					{ "data": "total" },
					{ "data": "tipo" },
					{ "data": "fecha" },
					{ "data": "detalle" }
		        ],
				"ajax": "FacPeticiones/tbFac.php?opcion=1",
				"language": {
					"url": "../php/FacPeticiones/español.json"
				}
    } );
	$('#tabAdminFac').on('click',function(){
		matpen.fnReloadAjax(); 
	});

} );//FIN DE TABLA PENDINETES DE MATERIALES
$('#facPenFin').ready(function() {//INICIO DE TABLA PENDINETES DE FINANCIEROS
    finPen = $('#facPenFin').dataTable( {
                "columns": [
		            { "data": "folio" },
		            { "data": "serie" },
		            { "data": "proveedor" },
		            { "data": "subtotal" },
					{ "data": "total" },
					{ "data": "fecha" },
					{ "data": "pkFac"}
		        ],
				"ajax": "FacPeticiones/tbFac.php?opcion=2",
				"language": {
					"url": "../php/FacPeticiones/español.json"
				}
    } );
     $('#idFinPen').on('click',function(){
		finPen.fnReloadAjax();
	});

} );//FIN TABLA PENDIENTES FINANCIEROS

$('#facPagFin').ready(function() {//INICIO TABLA DE PAGOS FIANANCIEROS
    facPagF = $('#facPagFin').dataTable( {
                "columns": [
		            { "data": "folio" },
		            { "data": "serie" },
		            { "data": "proveedor" },
		            { "data": "subtotal" },
					{ "data": "total" },
					{ "data": "fecha" },
					{ "data": "partida" },
					{ "data": "proyecto" },
					{ "data": "clave" },
					{ "data": "descripcion" },
					{ "data": "importe" },
					{ "data": "detalles" }
					
		        ],
				"ajax": "FacPeticiones/tbFac.php?opcion=3",
				"language": {
					"url": "../php/FacPeticiones/español.json"
				}
    } );
	$('.facturasPagadas').on('click',function(){
		facPagF.fnReloadAjax();
	});;
} );
function modalDetalles(facGeneral,detalles,totalDetalles)
{	
	var tabFacGeneral="<table class='table table-bordered'>"+
	"<tr><th>Folio</th><th>Serie</th><th>Proveedor</th><th>Subtotal</th><th>Total</th><th>Fecha</th></tr>"+
	"<tr><th>"+facGeneral[2]+"</th><th>"+facGeneral[1]+"</th><th>"+facGeneral[3]+"</th><th>$"+facGeneral[4]+"</th><th>$"+facGeneral[5]+"</th><th>"+facGeneral[7]+"</th></tr></table>";
	$('.facGral').html(tabFacGeneral);
	var detallesFac="<table class='table table-striped table-hover'><thead><tr><th>Cantidad</th><th>Descripcion</th><th>Precio Unitario</th><th>IVA</th><th>Importe</th><th>Importe +IVA</th></tr></thead><tbody>";
	for(i=0;i<totalDetalles;i++)
	{
		detallesFac+="<tr><td>"+detalles[i][0]+"</td><td>"+detalles[i][1]+"</td><td>"+detalles[i][2]+"</td><td>"+detalles[i][3]+"</td><td>"+detalles[i][4]+"</td><td>"+detalles[i][5]+"</td></tr>";	
	}
	
	detallesFac+="</tbody><tfoot><tr><th>Cantidad</th><th>Descripcion</th><th>Precio Unitario</th><th>IVA</th><th>Importe</th><th>Importe +IVA</th></tr></tfoot></table>";
	$('.tablaDetalles').html(detallesFac);
}
//FUNCION QUE EXPORTA LA FACTURA A PDF
function exportarPDF(idFactura,estado)
{
	//alert(estado);
	window.open('FacPeticiones/facturasPDF.php?factura='+idFactura+'&estado='+estado,'_blank');
}
//FUNCION QUE EXPORTA LA FACTURA A EXCEL
function exportarExcel(idFac,estado)
{
	//alert(estado);
	window.open('FacPeticiones/facturasExcel.php?factura='+idFac+'&estado='+estado,'_blank');
}