<script src="file:///C|/wamp/www/js/cargarForm.js"></script>
<script type="text/javascript">
	var ajax = new sack();
	var currentClientID=false;
	function getClientData()
	{
		var clientId = document.getElementById('codigoB').value.replace(/[^0-9]/g,'');
		if(clientId.length==4 && clientId!=currentClientID){
			currentClientID = clientId
			ajax.requestFile = 'getDatos.php?getClientId='+clientId;	// Specifying which file to get
			ajax.onCompletion = showClientData;	// Specify function that will be executed after file has been found
			ajax.runAJAX();		// Execute AJAX function			
		}
		
	}
	
	function showClientData()
	{
		var formObj = document.forms['datosForm'];	
		eval(ajax.response);
	}
	
	
	function initFormEvents()
	{
		
		document.getElementById('codigoB').onblur = alert('hola');
		document.getElementById('codigoB').onblur = getClientData;
		document.getElementById('codigoB').focus();
	}
	
	
	window.onload = initFormEvents;
	</script>

<form name="datosForm">
<input type="text" name="codigoB" id="codigoB"/>
<input type="text" name="modelo" id="modelo"/>

</form>