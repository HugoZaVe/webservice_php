<?php

include "config.php";
include "utils.php";

$dbConn = connect($db);
/*

*/

$sql =('SELECT nombre_archivo, archivo FROM archivos_editoriales WHERE id = "12"');

foreach ($dbConn->query($sql) as $row) {
    $nameFile = $row['nombre_archivo'];
    $contentFile = ($row['archivo']);
}

$addFile = fopen("filesXML/" . $nameFile, 'w');
fwrite($addFile, utf8_decode($contentFile));
fclose($addFile);

$pathFile = 'filesXML/' . $nameFile;
//echo $readFile;
if(file_exists($pathFile)){
    echo 'Leyendo el archivo ...' . '<br />';
    $xml = simplexml_load_string($contentFile);

    // TIPO DE PRODUCTO
    //Product Form -> e2_libros -> tipo_producto

    $productForm = $xml->Product->DescriptiveDetail->ProductForm;
    $statement = $dbConn->prepare('SELECT id FROM e2_tipo_productos WHERE onix = :onix LIMIT 1');
    $statement->execute(array(':onix' => $productForm));
    $result = $statement->fetch();
    $resultOnix = $result['id'];

    echo $resultOnix . '<br />';
    echo $productForm . '<br />';
    /*
    $statement = $dbConn->prepare('INSERT INTO e2_libros (id, tipo_producto) VALUES (null, :tipo_producto)');
    $statement->execute(array(
        'tipo_producto' => $resultOnix
    ));*/

    // Referencia (Pendiente)

    //isbn
    //RecordReference -> e2_libros -> isbn, codigo_barras
    $isbn = $xml->Product->RecordReference;
    echo $isbn . '<br />';
    /*$statement = $dbConn->prepare('INSERT INTO e2_libros (id, isbn, codigo_barras) VALUES (null, :isbn, :codigo_barras)');
    $statement->execute(array(
        'isbn' => $isbn
        'codigo_barras' => $isbn
    ));*/

    //TitleText-> e2_libros -> titulo
    $mainTitle = $xml->Product->DescriptiveDetail->TitleDetail->TitleElement->TitleText;
    echo  'Titulo: ' . $mainTitle . '<br />';

    /*
    $statement = $dbConn->prepare('INSERT INTO e2_libros (id, titulo) VALUES (null, :titulo)');
    $statement->execute(array(
        'titulo' => $mainTitle
    ));
    */

    // Subtitle -> e2_libros -> subtitulo
    $subtitle = $xml->Product->DescriptiveDetail->TitleDetail->TitleElement->Subtitle;
    echo 'Subtítulo: ' . $subtitle . '<br />';
    
    /*
    $statement = $dbConn->prepare('INSERT INTO e2_libros (id, subtitulo) values (null, :subtitulo)');
    $statement->execute(array(
        'subtitulo' => $subtitle
    ));
    */

    //Text -> e2_libros -> sinopsis_txt
    foreach($xml->Product->CollateralDetail as $sinopsis){
        foreach ($sinopsis->TextContent as $key) {
            # code...
            if($key->TextType == 03){
                $a = $key->Text;
                echo 'Sinopsis: '. utf8_decode(htmlspecialchars($a)); //e2_libros-> sinopsis
                echo 'Sinopsis: '. utf8_decode($a);
            }
        }
        
    }









    /*
    echo $xml->Header->Sender->SenderName . '<br>'; /* Editorial que realiza el envío
    echo $xml->Header->SentDateTime . '<br>'; /* Fecha del envío 
    echo $xml->Header->DefaultLanguageofText . '<br>'; /* Idioma 
    echo $xml->Product->RecordReference . '<br>';/* ISBN del libro
    echo $xml->Product->NotificationType . '<br>'; /* Código de tipo de notificación o actualización (Lista 1)
    */
    
}else{
    exit('No existe el archivo.');
}

?>  