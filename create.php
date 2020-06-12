<?php

header('Content-Type: application/json');
include "config.php";
include "utils.php";

$body = json_decode(file_get_contents("php://input"), true);
$dbConn = connect($db);
$response = array();

function createUser($dbConn, $postUser, $postPasswd, $postEditorial){
    $statement = $dbConn->prepare('SELECT * FROM editoriales WHERE usuario = :usuario LIMIT 1');
    $statement->execute(array(':usuario' => $postUser));
    $result = $statement->fetch();

    if($result == true){
        $response["message"] = "El usuario ya ha sido registrado";
        echo json_encode($response);
    }else{
        $postPasswd = hash('gost-crypto', $postPasswd);
        $statement = $dbConn->prepare('INSERT INTO editoriales (id_editorial, usuario, passwd, editorial) VALUES (null, :usuario, :passwd, :editorial)');
        $statement->execute(array(
            ':usuario' => $postUser,
            ':passwd' => $postPasswd,
            ':editorial' => $postEditorial
        ));

        $response["message"] = "Usuario registrado exitosamente";
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($body['usuario']) && isset($body['passwd']) && isset($body['editorial'])){

        $postUser = $body['usuario'];
        $postPasswd = $body['passwd'];
        $postEditorial = $body['editorial'];
        createUser($dbConn, $postUser, $postPasswd, $postEditorial);
    }
}
