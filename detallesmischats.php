<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'login.php';
	detallesChats();
}


function detallesChats(){
	global $connect;

	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

	$id = $_POST["ID"];

	$resultado = array();
	$query=" Select DISTINCT c.INICIO, c.ID As 'CODIGO', u.NOMBRE, u.TOKEN, u.TELEFONO, u.ID FROM MENSAJES m, CHATSCHAT c, USUARIOS u where m.CHATID=c.ID and u.ID=m.IDUSUARIORECEPCION
			and m.USUARIOID='$id'
			and c.CODIGO not in (Select id from GRUPOSCHAT);";
	 	$temp_array=array();

    $result=mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
  
  while($row = mysqli_fetch_assoc($result)) {


  		$temp_array[]=$row;

  }
}

	mysqli_close($connect);

	header('Content-Type: application/json');
	echo json_encode(array('chats'=>$temp_array));

}



?>