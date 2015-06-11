<?php
include("/mysql/RandomQuery.php");
include("/java/socketCommunication.php");
include("/java/socketReceive.php");
$object3 = new RandomQuery();
$object3->getRandom();
$result = $object3->getResult();

$object = new socketCommunication($result["festival_id"]);
$object->sendSocket();
sleep(500);
$object2 = new SocketReceive();
echo $object2->getResponse();
?>