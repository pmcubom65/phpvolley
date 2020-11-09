<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'login.php';
	anadiragrupo();
}


function anadiragrupo(){
	global $connect;

	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

	$grupo = $_POST["grupo"];
	$id=$_POST["id"];
	


	$query=" Insert into gruposchat_usuario(grupoid, usuarioid) values ((Select id from gruposchat where nombre='$grupo'),
				'$id');";

	mysqli_query($connect, $query) or die (mysqli_error($connect));
	$id = mysqli_insert_id($connect);
	mysqli_close($connect);



		$salida = array('grupo' => $grupo);


	header('Content-Type: application/json');
	echo json_encode($salida);


}




?>