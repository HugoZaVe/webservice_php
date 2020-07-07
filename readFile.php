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
    echo $xml->Header->Sender->SenderName . '<br>'; /* Editorial que realiza el envío*/
    echo $xml->Header->SentDateTime . '<br>'; /* Fecha del envío */
    echo $xml->Header->DefaultLanguageofText . '<br>'; /* Idioma */
    echo $xml->Product->RecordReference . '<br>';/* ISBN del libro*/
    echo $xml->Product->NotificationType . '<br>'; /* Código de tipo de notificación o actualización (Lista 1)*/

    
}else{
    exit('No existe el archivo.');
}

?>  