<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<!-- <h1>HOLA MUNDO</h1> -->
	<form action="" method="post">
		<label for="name">Search</label>
		<input type="text" name="name">
		<input type="submit" value="Get">
	</form>
</body>
</html>
<?php
//simple get request
if (isset($_POST['name'])) {

	$name = $_POST['name'];
	//Resoirce Address
	$client=curl_init();

	$url="http://localhost:8000/webservice/rest/?name=$name";
	curl_setopt($client, CURLOPT_URL, $url);
	//Send request to Resourse
	curl_setopt($client, CURLOPT_RETURNTRANSFER,1);

	// curl_setopt($client, CURLOPT_POST, $data);
	//get response to Resourse
	$response=curl_exec($client);
	curl_close($client);
	//decode
	$result=json_decode($response);

	echo $result->data;
}
 ?>