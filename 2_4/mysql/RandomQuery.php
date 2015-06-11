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