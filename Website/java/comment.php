<?php
session_start();
include("../java/socketSend.php");
include("../java/socketReceive.php");
	
	//send comment to java socket
	$query = "SET,COMMENT," . $_POST["message"]. ",". $_GET["user"] . "," . $_SESSION["userid"];
		//var_dump($query);
	$java_connect = new socketSend($query);
	$java_connect->sendSocket();
	$java_connect = new SocketReceive();
	$java_result = $java_connect->getResponse();
	header("Location: http://127.0.0.1/2_4/Template/person.php?name=" . $_GET["user"]);
	die();
?>