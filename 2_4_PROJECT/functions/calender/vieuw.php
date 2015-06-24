<?php
session_start();
include 'calendar.php';
echo '<link href="calendar.css" type="text/css" rel="stylesheet" />';
$calendar = new Calendar();
$calendar->setFestival();
echo $calendar->show();
?>
