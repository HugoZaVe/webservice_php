<?php

header('Content-Type: application/json');
include "config.php";
include "utils.php";

$body = json_decode(file_get_contents("php://input"), true);

$dbConn = connect($db);
$response = array();
//echo var_dump($_SERVER['REQUEST_METHOD'] == 'POST');
//echo var_dump($_POST);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    //echo json_encode(var_dump($_POST));

    if(isset($body['usuario']) && isset($body['passwd'])){
        $postUser = $body['usuario'];
        $postPasswd = $body['passwd'];
    }
    
    $res=$dbConn->query("SELECT * FROM editoriales WHERE usuario = '$postUser' AND passwd = '$postPasswd'");
    
    if($res->rowCount()<1){
        $response["success"] = false;
        $response['msg_code'] = "999999";
        $response["message"] = "El usuario no esta registrado";
    }else{
        echo json_encode($response);
    }

    echo json_encode($response);
       
    

    
    

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

header("HTTP/1.1 400 Bad Request");

?>