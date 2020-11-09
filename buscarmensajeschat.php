<?php
 

 if($_SERVER["REQUEST_METHOD"]=="POST"){
 	include 'login.php';
 	mostrarMensajesChats();
 }

 function mostrarMensajesChats(){
 	global $connect;


	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

 	$chat_id = $_POST['codigo'];

 

 	$query=" Select m.contenido, m.dia, u.telefono, u.nombre, a.ruta FROM mensajes m left join chatschat c on  m.chatid=c.id join usuarios u on u.id=m.usuarioid left join archivos a on a.mensajeid=m.id
 	 WHERE  m.CHATID='$chat_id'; ";

 

 	$result = mysqli_query($connect, $query);
 	$number_of_rows=mysqli_num_rows($result);
 	$temp_array=array();

 	if($number_of_rows>0){
 		while ($row=mysqli_fetch_assoc($result)){
 			$temp_array[]=$row;
 		}
 	}



 	header('Content-Type: application/json');
 	echo json_encode(array("mensajes"=>$temp_array) );
 	mysqli_close($connect);
 }

?>