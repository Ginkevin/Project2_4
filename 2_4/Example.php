<?php
//initial
$ip = '127.0.0.1';
$port = 2500;
set_time_limit(0);

//code
Echo  '<center> setting connections';

//connect to socket or return error_info
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
$result = socket_connect($socket, $ip, $port) or die("Could not connect to server\n");
info();
$result = socket_read ($socket, 1024) or die("Could not read server response\n");
echo "<center> Reply From Server  :".$result;

function info(){
	Echo  '<center> connections succesfull';
}
?>