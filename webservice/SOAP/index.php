<?php
require_once(getcwd() . '/Client.php');
$client = new Client();
// $data_access=($client->_soapClient->requestHeaders[0]->data->enc_value);
// print_r($data_access);

if (isset($_POST) && !empty($_POST)) {
	// print_r($_POST);
	$numerop = count($_POST);
	$tagsp = array_keys($_POST);// obtiene los nombres de las varibles
	$valoresp = array_values($_POST);// obtiene los valores de las varibles
	for($i=0;$i<$numerop;$i++){
		$$tagsp[$i]=$valoresp[$i];
	}

	switch ($_POST['type']) {
		case 'suma':
			$suma=$client->sum($num1,$num2);
			// print_r($suma);
			break;
		case 'saludo':
			$saludo = $client->getName($nombre);
			// print_r($saludo);
			break;
		case 'usuarios':
			$usuarios = $client->users();
			// print_r($usuarios);
			break;
		default:
			return 'Cool';
			break;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SOAP Webservice</title>
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
	<form action="" method="POST">
		<label for="num1">Numero1</label>
		<input type="number" name="num1">
		<label for="num2">Numero2</label>
		<input type="number" name="num2">
		<input type="text" hidden="true" name="type" value="suma">
		<input type="submit" value="SUMA">
	</form>
	<br>
	<form action="" method="POST">
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre">
		<input type="text" hidden="true" name="type" value="saludo">
		<input type="submit" value="SALUDO">
	</form>
	<br>
	<form action="" method="POST">
		<input type="text" hidden="true" name="type" value="usuarios">
		<input type="submit" value="Mostrar Usuarios">
	</form>
	<!-- <button id="getUsers">Mostrar Usuarios</button> -->
	<div class="main"></div>
	<script>
		$('#getUsers').click(function(){
			console.log('click');
			var datasend =  new FormData();
			// datasend.append('type','usuarios');
			datasend = {
				'type':'usuarios'
			}
			$.ajax({
				url: 'index.php',
				type: 'POST',
				data:datasend,
				success: function(data){
					// Printamos la vista en el div
					$(".main").html(data);
					console.log(data);
				},
				error: function(error) {
					console.log("Error");
				}
			});
		});
	</script>

</body>
</html>

