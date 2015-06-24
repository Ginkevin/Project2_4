<?php
$PK = array();
error_reporting(0);
include("LoginQuery.php");
	class mysqlQuery{
		public $connection;
		protected $result;
		
		function __construct(){
			$conn = new mysqli("127.0.0.1", "root", "", "2_4");
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$this->connection = $conn;
		}
		
		function getRandom($PK){
			$query = "Select festival_id, naam, datum_start, afbeelding_url from festival where festival_id = " . $PK;
			$data = $this->connection->query($query);
			$this->parseRandom($data);
		}
		
		function getFriends($PK){
			$query = "SELECT * FROM `vriendenlijst` WHERE vriend1 = " . $PK ." or vriend2 = ". $PK ;
			$data = $this->connection->query($query);
			$this->parseList($data);
		}
		
		function inviteFriends($vriend, $persona){
			$query = "INSERT INTO vriendenlijst VALUES(".$persona.",".$vriend.")";
			$data = $this->connection->query($query);
		}
		
		function getBands($date){
			$query = "SELECT * FROM `festival` WHERE datum_start >= '" . $date . "' ORDER BY datum_start ASC LIMIT 5";
			$data = $this->connection->query($query);
			$this->parseList($data);
		}
		
		function getBandsInfo(){
			for ($i = 0; $i < sizeof($this->result); $i++){
				//don't overwrite $this->result(). Needed for query, rather use $tmp
				$array[$i]["naam"] = $this->result[$i]["naam"];
				$array[$i]["datum_start"] = $this->result[$i]["datum_start"];
				$array[$i]["afbeelding_url"] = $this->result[$i]["afbeelding_url"];
				$array[$i]["festival_id"] = $this->result[$i]["festival_id"];
			}
			return $this->result;
		}
		
		function getPersonalBands($persoon){
			$query = "SELECT * FROM `persoon_naar_festival` WHERE persoon = " . $persoon . "";
			$data = $this->connection->query($query);
			$this->parseList($data);
		}
		
		function getFriendInfo(){
			//$array = new SplFixedArray(sizeof($this->result));
			$array = "";
			for ($i = 0; $i < sizeof($this->result); $i++){
				$query = "SELECT * FROM `persoon` WHERE registration_id = " . $this->result[$i]["vriend2"];
				$data = $this->connection->query($query);
				//don't overwrite $this->result(). Needed for query, rather use $tmp
				$tmp = $data->fetch_assoc();
				$array[$i]["first_name"] = $tmp["first_name"];
				$array[$i]["last_name"] = $tmp["last_name"];
				$array[$i]["avatar_url"] = $tmp["avatar_url"];
				$array[$i]["registration_id"] = $tmp["registration_id"];
			}
			
			if($array != NULL){
				return $array;
			}
			
		}
		function getSelf($PK){
			$query = "SELECT * FROM `persoon` WHERE registration_id = " . $PK;
		    //$data = $this->connection->query($query);
			var_dump($query);
			//$result = $data->fetch_assoc();
			//return $result;
		}
		
		function getPersonInfo($PK){
			$query;
			if (sizeof($PK) == 1){
				if(isset($PK[0])){
					
					$query = "SELECT * FROM `persoon` WHERE registration_id = " . $PK[0] .$PK[1];
					//var_dump($query);
					$data = $this->connection->query($query);
					$tmp = $data->fetch_assoc();
					return $tmp;
				}
				else{
					$query = "SELECT * FROM `persoon` WHERE registration_id = " . $PK;
					$data = $this->connection->query($query);
					$tmp = $data->fetch_assoc();
					return $tmp;
				}
			}
			else if($PK == null){
			}
			else if(sizeof($PK > 1)){
				$initial = true;
				foreach ($PK as $tmp){
						if($initial == true){
							$query = "SELECT * FROM `persoon` WHERE registration_id = " . $tmp;
							$initial = false;
						}
						else{
							$query .= " OR registration_id=". $tmp; 
						}
				}
			$data = $this->connection->query($query);
			$this->parseList($data);
			return $this->result;	
			}
					
		}
		
		function getPersonalBandsInfo($PK){
			//$array = new SplFixedArray(sizeof($this->result));
				$query = "SELECT * FROM `festival` WHERE festival_id = " . $PK;
				$data = $this->connection->query($query);
				//don't overwrite $this->result(). Needed for query, rather use $tmp
				$tmp = $data->fetch_assoc();
				$array["naam"] = $tmp["naam"];
				$array["afbeelding_url"] = $tmp["afbeelding_url"];
				$array["datum_start"] = $tmp["datum_start"];
				$array["festival_id"] = $PK;
			return $array;
		}
		
		function parseList($data){
			$counter = 0;
			$array = new SplFixedArray($data->num_rows);
			if($data->num_rows > 0){
				while ($data->num_rows > $counter){
					$array[$counter] = $data->fetch_assoc();
					$counter++;
				}
			$this->result = $array;
			}
			
		}
		
		function parseRandom($data){
			if($data->num_rows > 0){
				$this->result = $data->fetch_assoc();
			}
		}
		
		function getResult(){
			return $this->result;
		}
		
		function orderticket($festival_id, $persoon){
			$getTickets = "SELECT Tickets from festival where festival_id =" . $festival_id;
			$data = $this->connection->query($getTickets);
			$this->parseRandom($data);
			$nr_of_tickets = $this->result;
			if ($nr_of_tickets < 1){
				return false;
			}
			else{
			$nr_of_tickets["Tickets"] = $nr_of_tickets["Tickets"] - 1;
			$setTickets = "UPDATE festival set Tickets= " . $nr_of_tickets["Tickets"] . " WHERE festival_id = " . $festival_id;
			$execute = $this->connection->query($setTickets);
			$setFestival_Person  = "INSERT INTO persoon_naar_festival VALUES(".$festival_id.",". $persoon .")";
			$this->connection->query($setFestival_Person);
			return true;
			}
		}
	}
?>