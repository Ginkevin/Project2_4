<?php
	class socketSend{
		protected $PK;
		protected $ip = '127.0.0.1';
		protected $port = 64005;
		protected $socket;
		public $result;
		
		function __construct($key){
		 //var_dump($key);
		 $this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		 $this->result = socket_connect($this->socket, $this->ip, $this->port) or die("Could not connect to server\n");
		 $this->PK = $key;
		}
		
		function sendSocket(){
			$len = strlen($this->PK);
			socket_send ($this->socket, $this->PK, $len, 0);
		}
	}
?>