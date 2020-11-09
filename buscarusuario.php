<?php
 

 if($_SERVER["REQUEST_METHOD"]=="POST"){
 	include 'login.php';
 	buscarUsuario();
 }

 function buscarUsuario(){
 	global $connect;

 //	$telefono = $_POST['telefono'];

 	$_POST = json_decode(file_get_contents('php://input'), true);

 	//$json=file_get_contents('php://input');
 	//$data=json_decode($json);

 	$telefono=$_POST['telefono'];

 

 	$query=" Select * FROM usuarios WHERE telefono='$telefono'; ";

 	$result = mysqli_query($connect, $query);
 	$number_of_rows=mysqli_num_rows($result);
 	$temp_array=array();

 	if($number_of_rows>0){
 		while ($row=mysqli_fetch_assoc($result)){
 			$temp_array[]=$row;
 		}
 	}

 	header('Content-Type: application/json');
 	echo json_encode(array($temp_array[0])[0]);
 	mysqli_close($connect);
 }

?>