

<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	require 'login.php';
	buscargrupo();
}


function buscargrupo(){
	global $connect;

	$json=file_get_contents('php://input');
	$_POST=json_decode($json, true);

	$id = $_POST["ID"];


	$query=" Select * from GRUPOSCHAT where ID='$id';";
	$miid="";
	$minombre="";


    $result=mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
  
  while($row = mysqli_fetch_assoc($result)) {
    $miid=$row["ID"];
    $minombre=$row["NOMBRE"];
  }
}


	$querymiembros=" Select u.NOMBRE, u.TOKEN, u.TELEFONO, u.ID As 'USUARIOID' from usuarios u, gruposchat_usuario g where g.usuarioid=u.id 
	and g.GRUPOID='$id';";


    $result2=mysqli_query($connect, $querymiembros);
 	$temp_array=array();
 	 	$number_of_rows=mysqli_num_rows($result2);

 	if($number_of_rows>0){
 		while ($row=mysqli_fetch_assoc($result2)){
 			$temp_array[]=$row;
 		}
 	}


	mysqli_close($connect);

	if ($miid!='' && $minombre!=''){
			
	$salida = array('ID' => $miid, 'NOMBRE'=> $minombre, 'MIEMBROS'=>$temp_array);


			header('Content-Type: application/json');
			echo json_encode($salida);
	}





}


?>