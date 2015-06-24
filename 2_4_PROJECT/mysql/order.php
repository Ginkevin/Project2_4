<?php
include("mysqlQuery.php");
session_start();
$connect = new mysqlQuery();
$bool = $connect->orderticket($_GET["artist"], $_SESSION["userid"]);
if ($bool){
	echo "<center> Order successful, closing page.. </center>";
	echo '<script>window.close();</script>';
}
else{
	var_dump($bool);
}
?>
