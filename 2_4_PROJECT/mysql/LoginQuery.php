<?php
	class loginQuery{
		protected $username;
		protected $password;
		protected $result;
		public $connection;
	
		function __construct($user, $pass){
			$this->username = $user;
			$this->password = $pass;
			$this->login();
		}
		
		function login(){
			$conn = new mysqli("127.0.0.1", "root", "", "2_4");
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$this->connection = $conn;
			$query = "select * from persoon where Login ='" . $this->username ."';";
			$this->parse($conn->query($query));
		}
		
		function parse($data){
			if($data->num_rows > 0){
				$this->result = $data->fetch_assoc();
			}
		}
		
		function getPassword(){
			return $this->result["Password"];
		}
		
		function getFirstname(){
			return $this->result["first_name"];
		}
		
		function getLastname(){
			return $this->result["last_name"];
		}
		
		function getAvatar(){
			return $this->result["avatar_url"];
		}
		
		function getID(){
			return $this->result["registration_id"];
		}
		
		function getConnection(){
			return $this->connection;
		}
		function getResult(){
			return $this->result;
		}
	}
	