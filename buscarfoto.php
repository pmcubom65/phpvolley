<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'login.php';
	buscarfoto();
}


function buscarfoto(){
	global $connect;

	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

	$id = $_POST["ID"];


	$query=" Select RUTA from ARCHIVOS where USUARIOID='$id' and MENSAJEID IS NULL ORDER BY id DESC LIMIT 1;";
	$miruta="";

    $result=mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
  
  while($row = mysqli_fetch_assoc($result)) {
    $miruta=$row["RUTA"];
  }
}

	mysqli_close($connect);



		$salida = array('RUTA' => $miruta);


	header('Content-Type: application/json');
	echo json_encode($salida);

}


?>