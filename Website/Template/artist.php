<?php
session_start();
include("../mysql/mysqlQuery.php");
include("../java/socketSend.php");
include("../java/socketReceive.php");
include '../functions/calender/calendar.php';

$random_connect = new mysqlQuery();
$random_connect->getRandom($_GET["name"]);
$random_result = $random_connect->getResult();

$java_connect = new socketSend("GET,ARTIST," . $random_result["festival_id"]);
$java_connect->sendSocket();

$java_connect = new SocketReceive();
$java_result = $java_connect->getResponse();

$calendar = new Calendar();
echo'
<html>
	<head>
		<title>Strata by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body id="top">
		<!-- Header -->
			<header id="header">
			<img src="'.$random_result['afbeelding_url'].'" height="300" width="400"">>  </br>
		
			</header>

		<!-- Main -->
			<div id="main">

				<!-- One -->
					<section id="one">
						<header class="major">
							<h2>'. $random_result['naam'] . '</h2>
						</header>
						<p>'.$java_result .' </p>
						<ul class="actions">
							<li><button onclick="window.open(\'http://127.0.0.1/2_4/functions/calender/vieuw.php?year='.substr($random_result['datum_start'],0,4).'&month='. substr($random_result['datum_start'],5,2).'&day='. substr($random_result['datum_start'],8,2).'&artist='. $_GET["name"].'\',\'name\',\'width=650,height=650\');" class="button">Order Ticket</button> </li>
						</ul>
					</section>
				<!-- Two -->
					<section id="two">
						<h2>Friends</h2>
						<div class="row">
							<article class="6u 12u$(xsmall) work-item">
								<a href="images/fulls/01.jpg" class="image fit thumb"><img src="images/thumbs/01.jpg" alt="" /></a>
								<h3></h3>
								<p>echo </p>
							</article>
							
							<article class="6u$ 12u$(xsmall) work-item">
								<a href="images/fulls/02.jpg" class="image fit thumb"><img src="images/thumbs/02.jpg" alt="" /></a>
								<h3></h3>
								<p></p>
							</article>
						</div>
						<ul class="actions">
							<li><a href="#" class="button">Comment</a></li>
						</ul>
					</section>

			
			</div>

		<!-- Footer -->
			<footer id="footer">
				<ul class="icons">

				</ul>
				<ul class="copyright">
				</ul>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html> 
';
?>