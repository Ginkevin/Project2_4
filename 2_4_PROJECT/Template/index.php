<?php
include("../mysql/RandomQuery.php");
session_start();
	//initialise
		$random_connect = new RandomQuery();
		$random_connect->getFriends($_SESSION["userid"]); 
		$result = $random_connect->getResult();
		
	//personalise
	$friendlist = $random_connect->getFriendInfo();
	$random_connect->getPersonalBands($_SESSION["userid"]);
	$bandlist = $random_connect->getResult();
	
 //echo $today = date("Y-m-d");
echo'
<html>
<script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","../ajax/test.php?q="+str,true);
  xmlhttp.send();
}
</script>
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
				 <img src="'. $_SESSION["avatar"] .'" alt="" height="300" width="400" />
				 </br></br></br>
				 <center><p>band zoeken:</p></center>

				<form>
					<input type="text" size="30" onkeyup="showResult(this.value)">
					<div id="livesearch"></div>
				</form>
			</header>

		<!-- Main -->
			<div id="main">
					
				<!-- One -->
					<section id="one">
						<header class="major">
							<h2>'. $_SESSION["voornaam"] . " " . $_SESSION["achternaam"] .'</h2>
						</header>
						<p>Lorim ipsum un kino der titon mit</p>
						<ul class="actions">
						
							<li><a href="#" class="button">change preferences</a></li>
						</ul>
					</section>

				<!-- Two -->
					<section id="two">
						<h2>Friends / Events</h2> 
						<div class="row">
							<article class="6u 12u$(xsmall) work-item">
							';	for ($i = 0; $i < sizeof($friendlist); $i++){
								if ($i < 5){
								echo '<A HREF="person.php?name='.$friendlist[$i]["registration_id"] .'"><img src="'. $friendlist[$i]["avatar_url"] .'" alt="" height="50" width="50" /> '. $friendlist[$i]["first_name"].' '. $friendlist[$i]["last_name"] .' </a> </br>'; 
								}
								else{
									break;
								}
								} 
				 echo '
				 </br></br></br>
								<h3></h3>
								<p></p>	</article>
							
							<article class="6u$ 12u$(xsmall) work-item">
								';	for ($i = 0; $i < sizeof($bandlist); $i++){
								if ($i < 5){
									$tmp2 = $random_connect->getPersonalBandsInfo($bandlist[$i]["festival"]);
									echo '<A HREF="artist.php?name='.$tmp2["festival_id"] .'"> <img src="'. $tmp2["afbeelding_url"] .'" alt="" height="50" width="50" /> '. $tmp2["naam"].' '. $tmp2["datum_start"] .' </a> </br>'; 
								}
								else{
									break;
								}
								} 
								echo '
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

	


//echo var_dump($bandlist);
?>