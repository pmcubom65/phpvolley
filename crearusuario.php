<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'login.php';
	nuevousuario();
}


function nuevousuario(){
	global $connect;

	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

	$nombre = $_POST["nombre"];
	$telefono=$_POST["telefono"];
	$token=$_POST["token"];



	$query=" Insert into usuarios(nombre, telefono, token) values ('$nombre', '$telefono', '$token');";

	mysqli_query($connect, $query) or die (mysqli_error($connect));
	$id = mysqli_insert_id($connect);
	mysqli_close($connect);



		$salida = array('nombre' => $nombre, 'telefono' => $telefono, 'token'=>$token, 'id'=>$id);


	header('Content-Type: application/json');
	echo json_encode($salida);


}




?>