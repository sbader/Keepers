<?php
if(isset($_POST)){
	require_once('config.php');
	require_once('player.php');
	$player = new Player();
	if($player->definite_player($_POST)){
		header('HTTP/1.1 200 OK');
	}
	else{
		header('HTTP/1.1 400 Bad Request');
	}
}
?>