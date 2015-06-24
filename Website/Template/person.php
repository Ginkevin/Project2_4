<?php
include("../mysql/mysqlQuery.php");
include("../java/socketSend.php");
include("../java/socketReceive.php");

session_start();
	//initialise;
		$random_connect = new mysqlQuery();
		$friendslist = $random_connect->getFriends($_GET["name"]); 
		$result = $random_connect->getResult();
		$friend_boolean = false;
		
	//personalise;
	$person = $random_connect->getPersonInfo($_GET["name"]);
	$friendlist = $random_connect->getFriendInfo();
	$random_connect->getPersonalBands($_GET["name"]);
	$bandlist = $random_connect->getResult();

//check for friend invite;
if(isset($_GET['invite'])){
	if($_GET["invite"] == true){
	$random_connect->inviteFriends($_SESSION["userid"],$_GET["name"]);
	header("Location: http://127.0.0.1/2_4/Template/person.php?name=".$_GET["name"]);
	}
}

//get personal messages from server; limit 10;
	$java_connect = new socketSend("GET,COMMENT," . $_GET["name"]);
	$java_connect->sendSocket();
	$java_connect = new SocketReceive();
	$java_result = $java_connect->getResponse();
	$jason_result = json_decode($java_result, true);

	$query = array();
	//convert JSON to arrays and ready query;
	$personal_messages;
	for ($i=0; $i < 10; $i++){
		$message = "message".$i;
		if ($jason_result[$message] != null){
		list($personal_messages[$i]["sender"], $personal_messages[$i]["date"], $personal_messages[$i]["message"]) = explode("#", $jason_result[$message]);
		array_push($query, $personal_messages[$i]["sender"]);
		}
	}
	$personal_messages_information = $random_connect->getPersonInfo(array_unique($query));
	
	$block_messages = array();
	$block_messages = create_message($personal_messages, $personal_messages_information);
	function create_message($pm, $pmi){
		$block = array();
		for ($ii =0; $ii< sizeof($pm); $ii++){
			if (isset($pmi[0])){
				for ($jj=0; $jj< sizeof($pmi); $jj++){
					if($pm[$ii]["sender"] == $pmi[$jj]["registration_id"]){
					$block[$ii]["sender"] = $pm[$ii]["sender"];
					$block[$ii]["message"] = $pm[$ii]["message"];
					$block[$ii]["avatar_url"] = $pmi[$jj]["avatar_url"];
					$block[$ii]["first_name"] = $pmi[$jj]["first_name"];
					$block[$ii]["last_name"] = $pmi[$jj]["last_name"];
					$block[$ii]["date"] = $pm[$ii]["date"];
					break;
					}
				}
			}
			else{
					$block[$ii]["sender"] = $pm[$ii]["sender"];
					$block[$ii]["message"] = $pm[$ii]["message"];
					$block[$ii]["avatar_url"] = $pmi["avatar_url"];
					$block[$ii]["first_name"] = $pmi["first_name"];
					$block[$ii]["last_name"] = $pmi["last_name"];
					$block[$ii]["date"] = $pm[$ii]["date"];
			}
		}
		return $block;
	}

//check if page = users page;	
if ($_SESSION["userid"] == 	$_GET["name"]){
	header("Location: http://127.0.0.1/2_4/Template/home.php");
	die();
}

//get friendlist from database and put in memory
$get_friendlist_memory= array();
$tmp_bool = false;
for ($i =0; $i < sizeof($result); $i++){
	if ($result[$i]["vriend1"] == $_GET["name"]){
		array_push($get_friendlist_memory, $result[$i]["vriend2"]);
	}
	if ($result[$i]["vriend2"] == $_GET["name"]){
		for ($j = 0; $j< $i; $j++){
			if($result[$j][0] == $result[$i]["vriend2"]){
				$tmp_bool = true;
			}
		}
		if ($tmp_bool == true){
		}
		else if($tmp_bool == false){
			array_push($get_friendlist_memory, $result[$i]["vriend1"]);
		}
		}
		$tmp_bool = false;
}
//get friends information from database based on memory
$friendlist_information = $random_connect->getPersonInfo($get_friendlist_memory);
$_SESSION["friendlist_information_more"] = $friendlist_information;

//check if friend exists;

if (isset($friendlist_information[0])){
for ($i = 0; $i < sizeof($friendlist_information); $i++){
	if($friendlist_information[$i]["registration_id"] == $_SESSION["userid"]){
		$friend_boolean = true;
	}
}
}
else{
	if($friendlist_information["registration_id"] == $_SESSION["userid"]){
		$friend_boolean = true;
	}
}

//HTML ELEMENT
echo'
<html>
	<head>
		<title>Strata by HTML5 UP</title>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]>
		<script src="assets/js/ie/html5shiv.js">
		
		</script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body id="top">
		<!-- Header -->
			<header id="header">
				 <img src="'. $person["avatar_url"] .'" alt="" height="300" width="400" />
	'; 
	//var_dump($friend_boolean);
	if(!$friend_boolean){
	echo '</br></br><li><a href="http://127.0.0.1/2_4/Template/person.php?name='. $_GET["name"] .'&invite=true" class="button">Invite</a></li>';
	}		
	echo'
	</header>
		<!-- Main -->
			<div id="main">
					
				<!-- One -->
					<section id="one">
						<header class="major">
							<h2>'. $person["first_name"] . " " . $person["last_name"] .'</h2>
						</header>
						<p>Lorim ipsum un kino der titon mit</p>
						<ul class="actions">
						
							
						</ul>
					</section>

				<!-- Two -->
					<section id="two">
						<h2>Friends / Events</h2> 
						<div class="row">
							<article class="6u 12u$(xsmall) work-item">
							';	if (!isset($friendlist_information[0]) && $friendlist_information !=null){
								echo '<A HREF="person.php?name='.$friendlist_information["registration_id"] .'"><img src="'. $friendlist_information["avatar_url"] .'" alt="" height="50" width="50" /> '. $friendlist_information["first_name"].' '. $friendlist_information["last_name"] .' </a> </br>'; 
								}
								else {
								for ($i = 0; $i < sizeof($friendlist_information); $i++){
								if ($i < 5){
								echo '<A HREF="person.php?name='.$friendlist_information[$i]["registration_id"] .'"><img src="'. $friendlist_information[$i]["avatar_url"] .'" alt="" height="50" width="50" /> '. $friendlist_information[$i]["first_name"].' '. $friendlist_information[$i]["last_name"] .' </a> </br>'; 
								}
								else{
									break;
								}
								}
								}
				 echo '
				 </a></li>
				 ';
				 if(sizeof($friendlist_information) >= 5 && is_array($friendlist_information[3])){
				 echo '<a href="http://127.0.0.1/2_4/Template/friendlist.php?name='. $_GET["name"] .'" class="button">More</a>' ;
				 }
				 echo '
				
				 </br></br></br>						
						<h3></h3>
								<p></p>	</article>
							
							<article class="6u$ 12u$(xsmall) work-item">
								';	
								if (isset($bandlist[0])){
									if(!isset($bandlist[0]["vriend1"])){
								for ($i = 0; $i < sizeof($bandlist); $i++){
								if ($i < 5){
									$tmp2 = $random_connect->getPersonalBandsInfo($bandlist[$i]["festival"]);
									echo '<A HREF="artist.php?name='.$tmp2["festival_id"] .'"><img src="'. $tmp2["afbeelding_url"] .'" alt="" height="50" width="50" /> '. $tmp2["naam"].' '. $tmp2["datum_start"] .'</a>  </br>'; 
								}
								else{
									break;
								}
								}
									}
								}
							if(sizeof($bandlist) >= 5){
				 echo '<a href="http://127.0.0.1/2_4/Template/artistlist.php?name='. $_GET["name"] .'" class="button">More</a>';
				 }								
								echo '
								<h3></h3>
								<p></p>
							</article>
						</div>
						<ul class="actions">
						<form action="../java/comment.php?user='. $_GET["name"] .'" method="post">
						write comment (max length: 1000): <input id="myText" type="text" name="message"><br>
						<li><input type="submit" value="Comment"></a></li></br></br>
						<p>';
						
						for ($command_list = 0; $command_list < sizeof($block_messages); $command_list++){
								echo '<img src="'. $block_messages[$command_list]["avatar_url"] .'" alt="" height="50" width="50" />'.$block_messages[$command_list]["first_name"].''. $block_messages[$command_list]["last_name"].'  </br>';
								echo "<textarea>" . $block_messages[$command_list]["message"] . "</textarea>";
						}
						echo '</p> </form>
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
			<script> document.getElementById("myText").maxLength = "1000"; </script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html> 
';
	


//echo "var dump: result" . var_dump($result) . "</br>" ;
//echo "var dump: person" . var_dump($person) . "</br>" ;
//echo "var dump: friendlist" . var_dump($friendlist) . "</br>" ;

?>