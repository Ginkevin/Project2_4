<?php
include("../mysql/mysqlQuery.php");
session_start();
	//initialise
		$random_connect = new mysqlQuery();


	//personalise
		$random_connect->getPersonalBands($_GET["name"]);
		$bandlist = $random_connect->getResult();
echo '
	<head>
		<title>Strata by HTML5 UP</title>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	
	<!-- Main -->
			<div id="main">
					
				<!-- One -->
					<section id="one">
						<header class="major">
							<h2> ArtistList </h2>
						</header>
						<p>'; 	for ($i = 0; $i < sizeof($bandlist); $i++){
									$tmp2 = $random_connect->getPersonalBandsInfo($bandlist[$i]["festival"]);
									echo '<A HREF="artist.php?name='.$tmp2["festival_id"] .'"> <img src="'. $tmp2["afbeelding_url"] .'" alt="" height="50" width="50" /> '. $tmp2["naam"].' '. $tmp2["datum_start"] .' </a> </br>'; 
								} echo '</p>
						<ul class="actions">
						</ul>
					</section>';
?>