<?php
 

 if($_SERVER["REQUEST_METHOD"]=="POST"){
 	include 'login.php';
 	mostrarGrupos();
 }

 function mostrarGrupos(){
 	global $connect;


	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

 	$id= $_POST['ID'];

 

 	$query=" Select g.NOMBRE, g.ID AS ID FROM gruposchat_usuario gu, gruposchat g where g.id=gu.GRUPOID and
 	gu.USUARIOID='$id'; ";

 

 	$result = mysqli_query($connect, $query);
 	$number_of_rows=mysqli_num_rows($result);
 	$temp_array=array();



 	if($number_of_rows>0){
 		while ($row=mysqli_fetch_assoc($result)){
 			$temp_array[]=$row;
			
 		}
 	}


 	for ($i=0; $i<count($temp_array); $i++){
 		$idgrupo=$temp_array[$i]['ID'];

 		$querymiembros=" Select u.NOMBRE, u.TELEFONO, u.TOKEN, u.ID AS USUARIOID FROM usuarios u, gruposchat_usuario gu 
 				where u.id=gu.USUARIOID and gu.GRUPOID='$idgrupo' ;";


 		 				$result2 = mysqli_query($connect, $querymiembros);
						while ($row2=mysqli_fetch_assoc($result2)){

							$temp_array[$i]['MIEMBROS'][]=$row2;


						}




 	}

 	$salida=array('GRUPOS'=>$temp_array);

 	header('Content-Type: application/json');
 	echo json_encode($salida);
 	mysqli_close($connect);
 }

?>