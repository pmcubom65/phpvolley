<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'login.php';
	creargrupo();
}


function creargrupo(){
	global $connect;

	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

	$nombre = $_POST["nombre"];
	


	$query=" Insert into gruposchat(nombre) values ('$nombre');";

	mysqli_query($connect, $query) or die (mysqli_error($connect));
	$id = mysqli_insert_id($connect);
	mysqli_close($connect);



		$salida = array('NOMBRE' => $nombre, 'ID'=>$id);


	header('Content-Type: application/json');
	echo json_encode($salida);


}




?>