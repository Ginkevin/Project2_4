<?php
include("../mysql/LoginQuery.php");
start();
	function start(){
		$connection = new loginQuery($_POST["user"], $_POST["password"]);
		if ($_POST["password"] == $connection->getPassword()){
			session_start();
				$_SESSION["voornaam"] = $connection->getFirstname();
				$_SESSION["achternaam"] = $connection->getLastname();
				$_SESSION["avatar"] = $connection->getAvatar();
				$_SESSION["userid"] = $connection->getID();
				header("Location: ../Template/home.php");
				die();
		}
		else {
			echo "<center> Wrong user name or password. </br> Being redirected";
			header("Location: http://127.0.0.1/2_4/Login/index.html");
			die();
		}
	}
?>