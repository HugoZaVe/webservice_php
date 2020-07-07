<?php

header('Content-Type: application/json');
include "config.php";
include "utils.php";

$body = json_decode(file_get_contents("php://input"), true);

$dbConn = connect($db);
$response = array();



function validateUser($dbConn, $postUser, $postPasswd, $postNameFile, $postFile){
    /* Primer caso: Verifico que las credenciales existen y la contraseña sea correcta*/

    $postPasswd = hash('gost-crypto', $postPasswd);
    


    #$postFileA = pack('Q', $postFile);
    #$postFileB = base64_decode($postFileA);
    #$postFileD = utf8_decode($postFileB);
    
    $createFile = fopen("files/". $postNameFile, 'w');
    fwrite($createFile, utf8_encode($postFile));
    fclose($createFile);

    $statement = $dbConn->prepare('SELECT * FROM editoriales WHERE usuario = :usuario AND passwd = :passwd LIMIT 1');
    $statement->execute(array(':usuario' => $postUser, ':passwd' => $postPasswd));
    $result = $statement->fetch();

    if($result == true){

        $statement = $dbConn->prepare('SELECT id_editorial FROM editoriales WHERE usuario = :usuario LIMIT 1');
        $statement->execute(array(':usuario' => $postUser));
        $result = $statement->fetch();
        $resultIdEd = $result['id_editorial'];

        $statement = $dbConn->prepare('INSERT INTO archivos_editoriales (id, id_editorial, nombre_archivo, archivo) VALUES (null, :id_editorial, :nombre_archivo, :archivo)');
        $statement->execute(array(
            'id_editorial' => $resultIdEd,
            'nombre_archivo' => $postNameFile, 
            'archivo' => $postFile
        ));

        $response["message"] = "Archivo enviado correctamente";
        echo json_encode($response);
    }else{
        $response["message"] = "Las credenciales son incorrectas";
        echo json_encode($response);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($body['usuario']) && isset($body['passwd']) && isset($body['nombre_archivo']) && isset($body['archivo'])){
        $postUser = $body['usuario'];
        $postPasswd = $body['passwd'];
        $postNameFile = $body['nombre_archivo'];
        $postFile = $body['archivo'];

        validateUser($dbConn, $postUser, $postPasswd, $postNameFile, $postFile);
    }else{
        $response["message"] = "Debes ingresar tu usario y contraseña";
        echo json_encode($response);
    }

        
    /* 
    $statement = $dbConn->prepare('SELECT * FROM editoriales WHERE usuario = :usuario LIMIT 1');
    $statement->execute(array(':usuario' => $postUser));
    $result = $statement->fetch();

    if($result == false){
        $response["message"] = "El usuario no ha sido registrado, debe de enviar sus datos para registrarlo.";
        echo json_encode($response);
    }
    */
    	 
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