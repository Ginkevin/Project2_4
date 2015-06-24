<?php
include("../mysql/mysqlQuery.php");
session_start();
	//initialise
	//personalise
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
							<h2> Friendlist </h2>
						</header>
						<p>';					
						if (!isset($_SESSION["friendlist_information_more"][0])){
								echo '<A HREF="person.php?name='.$_SESSION["friendlist_information_more"]["registration_id"] .'"><img src="'. $_SESSION["friendlist_information_more"]["avatar_url"] .'" alt="" height="50" width="50" /> '. $_SESSION["friendlist_information_more"]["first_name"].' '. $_SESSION["friendlist_information_more"]["last_name"] .' </a> </br>'; 
								}
								else{
								for ($i = 0; $i < sizeof($_SESSION["friendlist_information_more"]); $i++){
								echo '<A HREF="person.php?name='.$_SESSION["friendlist_information_more"][$i]["registration_id"] .'"><img src="'. $_SESSION["friendlist_information_more"][$i]["avatar_url"] .'" alt="" height="50" width="50" /> '. $_SESSION["friendlist_information_more"][$i]["first_name"].' '. $_SESSION["friendlist_information_more"][$i]["last_name"] .' </a> </br>'; 
							} 
								}echo '</p>
						<ul class="actions">
						</ul>
					</section>';
?>