<?php
 

 if($_SERVER["REQUEST_METHOD"]=="POST"){
 	include 'login.php';
 	contarChats();
 }

 function contarChats(){
 	global $connect;

 	$telefono = strval($_POST["telefono"]); 
 	

 	$query=" Select c.chat_id FROM chats c, mensajes m where c.chat_id=m.chat_id and telefono='$telefono' group by c.chat_id; ";

 	$result = mysqli_query($connect, $query);
 	$number_of_rows=mysqli_num_rows($result);
 	$temp_array=array();

 	if($number_of_rows>0){
 		while ($row=mysqli_fetch_assoc($result)){
 			$temp_array[]=$row;
 		}
 	}

 	header('Content-Type: application/json');
 	echo json_encode(array("chats_abiertos"=>sizeof($temp_array)));
 	mysqli_close($connect);
 }

?>