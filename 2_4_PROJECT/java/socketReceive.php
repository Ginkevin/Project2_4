<?php
	class socketReceive{
		protected $ip = '127.0.0.1';
		protected $port = 64006;
		protected $socket;
		public $result;
		
		function __construct(){
		 $this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		 $this->result = socket_connect($this->socket, $this->ip, $this->port) or die("Could not connect to server\n");
		}
		
		function getResponse(){
			$bytes = socket_recv($this->socket, $buf, 2048, MSG_WAITALL);
			return $buf;
		}
	}
?>