<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'login.php';
	nuevomensaje();
}


function nuevomensaje(){
	global $connect;

	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

	$chat_id = $_POST["chatid"];
	$contenido=$_POST["contenido"];
	$dia=$_POST["dia"];

	$usuarioid= $_POST["usuarioid"];
	$idusuariorecepcion= $_POST["idusuariorecepcion"];


	$query=" Insert into mensajes(chatid, contenido, dia, idusuariorecepcion, usuarioid) values 
	('$chat_id', '$contenido', '$dia','$idusuariorecepcion','$usuarioid');";


	mysqli_query($connect, $query) or die (mysqli_error($connect));

	mysqli_close($connect);

	$salida = array('contenido' => $contenido);


	header('Content-Type: application/json');
	echo json_encode($salida);
}








?>