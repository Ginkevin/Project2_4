<?php 
include("java/socketCommunication.php");
$connection = new socketCommunication();
echo $connection->getResponse();
?>