<?php
function cln($inp){
	$inp = htmlentities($inp,ENT_QUOTES,'UTF-8');
	return $inp;
}
function updateLastseen($user, $db){
	$qry = $db->prepare("UPDATE users SET lastseen = NOW() WHERE uid = :user");
	$qry->execute([
		":user" => $user
	]);
}
?>
