<?php

header('Content-Type: application/json');
include "config.php";
include "utils.php";

$body = json_decode(file_get_contents("php://input"), true);

$dbConn = connect($db);
$response = array();


$routeFile = "files/9786070757976.onix";
$contentFile = file_get_contents($routeFile);
$content64 = base64_encode($contentFile);

#echo $content64;

echo "\n";
echo "\n";
echo "\n";

$pasw = "hola123";

$pasw = hash('gost-crypto', $pasw);

echo $pasw;

#echo 'Archivo decodificado';
#echo base64_decode($content64);





//$str = 'El paco me la pela en LOL';
//$str_64 = base64_encode($str);

//echo $str_64 . "<br />";


//echo base64_decode($str_64);

//echo var_dump($_SERVER['REQUEST_METHOD'] == 'POST');
//echo var_dump($_POST);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    //echo json_encode(var_dump($_POST));

    if(isset($body['usuario']) && isset($body['passwd'])){
        $postUser = $body['usuario'];
        $postPasswd = $body['passwd'];
        
    }else{
        $response["message"] = "Debes ingresar tu usario y contraseña";
        echo json_encode($response);
    }

    $statement = $dbConn->prepare('SELECT * FROM editoriales WHERE usuario = :usuario LIMIT 1');
    $statement->execute(array(':usuario' => $postUser));
    $result = $statement->fetch();

    if($result == true){
        $response["message"] = "Archivo enviado correctamente";
        echo json_encode($response);
    }else{
        $response["message"] = "El usuario no existe, debe de enviar un json indicando usuario y contraseña para registrarlo";
        echo json_encode($response);
    }
    
    $postPasswd = hash('gost-crypto', $postPasswd);
     
    
    //$res=$dbConn->query("SELECT * FROM editoriales WHERE usuario = '$postUser' AND passwd = '$postPasswd'");
    /*
    if($res->rowCount()<1){
        //$response["success"] = false;
        //$response['msg_code'] = "999999";
        $response["message"] = "El usuario no esta registrado";
    }else{
        echo json_encode($response);
    }
    */
    //echo json_encode($response);
       
    

    
    

    //echo json_encode("Conexion POST establecida");

   // $sql = "SELECT * FROM web_service WHERE editorial = :editorial LIMIT 1";
   // $statement = $dbConn->prepare($sql);
   // $statement->execute();
   // $result = $statement->fetch();

    //echo json_encode("Editorial ya existe");
    
    //$passwd = $_POST[2];
    //$postEditorial = $input['editorial'];
    	 
}

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * FROM editoriales where id=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }
}

//header("HTTP/1.1 400 Bad Request");

?>