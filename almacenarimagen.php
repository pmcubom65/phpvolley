<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    require 'login.php';
    save_base64_image();
}


function save_base64_image() {
global $connect;


    $json=file_get_contents('php://input');
    $_POST=json_decode($json, true);

    $id = $_POST["ID"];
    $base64_string=$_POST["IMAGEN"];

    $extension=$_POST["EXTENSION"];
    $dia=$_POST["DIA"];
    $chat_id=$_POST["CHAT_ID"];
    $emisor=$_POST["EMISOR"];
    $receptor=$_POST["RECEPTOR"];

    $path='';
 

    $dir = "usuarios".DIRECTORY_SEPARATOR.$id;
    if( is_dir($dir) === false )
    {
    mkdir($dir);
    }

 



    if($receptor === '' && $chat_id==='') {
            $path = dirname(__FILE__).DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$id.'.'.$extension;

    }else {
            $diamodificado = str_replace(":", "", $dia);
            $path = dirname(__FILE__).DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$id.$chat_id.$diamodificado.'.'.$extension;



    }

    $archivo = fopen($path, "w");

    $data = explode(',', $base64_string);

    fwrite($archivo, base64_decode($data[1]));
    fclose($archivo);

    $tipoid="";

    $querycheck=" Select id from tipos_archivo where TIPO='$extension';";

    $queryinsertarmensaje="";

    $result=mysqli_query($connect, $querycheck);
    if (mysqli_num_rows($result) > 0) {
  
  while($row = mysqli_fetch_assoc($result)) {
    $tipoid=$row["id"];
  }

}else{
    $query=" Insert into tipos_archivo (TIPO) values ('$extension') ON DUPLICATE KEY UPDATE id=id+1;";

    mysqli_query($connect, $query) or die (mysqli_error($connect));
    $tipoid = mysqli_insert_id($connect);
}


$path=mysqli_real_escape_string($connect, $path);
    
    if ($receptor === '' && $chat_id===''){

    $query2=" Insert into ARCHIVOS (TIPOID, MENSAJEID, RUTA, USUARIOID) values ('$tipoid', 
    null, '$path', '$emisor');";
    
    }else if ($receptor === '' && $chat_id!==''){

      $queryinsertarmensaje=" Insert into mensajes(chatid, contenido, dia, idusuariorecepcion, usuarioid) values 
    ('$chat_id', null, '$dia',null,'$emisor');";


   mysqli_query($connect, $queryinsertarmensaje) or die (mysqli_error($connect));
    $idmensaje = mysqli_insert_id($connect);
 

    $query2=" Insert into ARCHIVOS (TIPOID, MENSAJEID, RUTA, USUARIOID) values ('$tipoid', 
    '$idmensaje', '$path', '$emisor');";



 } else {

       $queryinsertarmensaje=" Insert into mensajes(chatid, contenido, dia, idusuariorecepcion, usuarioid) values 
    ('$chat_id', null, '$dia','$receptor','$emisor');";


        
   mysqli_query($connect, $queryinsertarmensaje) or die (mysqli_error($connect));
    $idmensaje = mysqli_insert_id($connect);
 

    $query2=" Insert into ARCHIVOS (TIPOID, MENSAJEID, RUTA, USUARIOID) values ('$tipoid', 
    '$idmensaje', '$path', '$emisor');";

    }




        

    mysqli_query($connect, $query2) or die (mysqli_error($connect));
    mysqli_close($connect);



    $salida = array('GRABADO' => 'Si', 'RUTA' => $path);


    header('Content-Type: application/json');
    echo json_encode($salida);
 
}

?>