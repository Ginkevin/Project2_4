<?php
include("LoginQuery.php");
	class RandomQuery{
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
			$query = "SELECT * FROM `persoon_naar_festival` WHERE persoon = " . $persoon . "  LIMIT 5";
			$data = $this->connection->query($query);
			$this->parseList($data);
		}
		
		function getFriendInfo(){
			//$array = new SplFixedArray(sizeof($this->result));
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
			return $array;
		}
		
		function getPersonInfo($PK){
			for ($i = 0; $i < sizeof($this->result); $i++){
				$query = "SELECT * FROM `persoon` WHERE registration_id = " . $PK;
				$data = $this->connection->query($query);
				//don't overwrite $this->result(). Needed for query, rather use $tmp
				$tmp = $data->fetch_assoc();
				$array[$i]["first_name"] = $tmp["first_name"];
				$array[$i]["last_name"] = $tmp["last_name"];
				$array[$i]["avatar_url"] = $tmp["avatar_url"];
				$array[$i]["registration_id"] = $tmp["registration_id"];
			}
			return $array;
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
	}
?>