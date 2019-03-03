<?php

try{
	global $db;
	$db= new PDO('mysql:host=localhost;dbname=iitbazaar;charset:utf8', 'root', 'root');
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e) {
   die ("Sorry, we're updating IIT Bazaar right now for a better experience...Please come back later");
}


date_default_timezone_set("Asia/Kolkata");

?>
