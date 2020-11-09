<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'login.php';
	empezarChat();
}


function empezarChat(){
	global $connect;

	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

	$chat_id = $_POST["codigo"];
	$inicio=$_POST["inicio"];

	$query=" Insert into chatschat(codigo, inicio) values ('$chat_id', '$inicio');";

	mysqli_query($connect, $query) or die (mysqli_error($connect));
	$idchat = mysqli_insert_id($connect);
	mysqli_close($connect);

	$salida = array('codigo' => $chat_id, 'inicio' => $inicio, 'idchat'=>$idchat);


	header('Content-Type: application/json');
	echo json_encode($salida);
}




?>