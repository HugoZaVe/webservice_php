<?php

include "config.php";
include "utils.php";

$dbConn = connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    echo json_encode("Conexion POST establecida");

    $sql = "SELECT * FROM web_service WHERE editorial = :editorial LIMIT 1";
    $statement = $dbConn->prepare($sql);
    $statement->execute();
    $result = $statement->fetch();

    echo json_encode("Editorial ya existe");
    
    //$passwd = $_POST[2];
    //$postEditorial = $input['editorial'];
    
	 
}

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT * FROM web_service where id=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }
}

header("HTTP/1.1 400 Bad Request");

?>