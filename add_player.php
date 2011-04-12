<?php
if(isset($_POST)){
	require_once('config.php');
	require_once('player.php');
	$player = new Player();
	$player->validate_player($_POST);
	if($player->valid()){
		$player->submit_player($_POST);
		header('HTTP/1.1 200 OK');
		echo $player->id();
	}
	else{
		header('HTTP/1.1 400 Bad Request');
	}
}
?>