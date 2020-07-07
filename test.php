<?php 

if(file_exists('9786073187336.xml')){
    $xml = simplexml_load_file('9786073187336.xml');
    print_r($xml);
}else{
    exit('No existe el archivo.');
}

/* Penguin*/
echo $xml->Header->Sender->SenderName . '<br>'; /* Editorial que realiza el envío*/
echo $xml->Header->SentDateTime . '<br>'; /* Fecha del envío */
echo $xml->Header->DefaultLanguageofText . '<br>'; /* Idioma */
echo $xml->Product->RecordReference . '<br>';/* ISBN del libro*/
echo $xml->Product->NotificationType . '<br>'; /* Código de tipo de notificación o actualización (Lista 1)*/

echo rand(5, 15)

?>
