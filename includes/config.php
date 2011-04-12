<?php
//Change these values
$dbhost = 			'localhost';
$dbuser = 			'#######';
$dbpassword =		'#######';
$dbdatabase = 		'#######';
$config_basedir = 	'http://localhost/Keepers/';

function opendbi(){
  global $dbhost;
  global $dbuser;
  global $dbdatabase;
  global $dbpassword;
  global $config_basedir;
	$mysqli = new mysqli($dbhost,$dbuser,$dbpassword,$dbdatabase);
return $mysqli;
}
?>
