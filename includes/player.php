<?php
require_once('config.php');
class Player{
  public $valid = true;
  public $errorarray = Array();
  public $name;
  public $points;
  public $id;
  
  function valid(){
    return $this->valid;
  }
  function id(){
    return $this->id;
  }
  protected function validate_player($postarray){
  	$errorarray['valid'] = true;
  	if(empty($postarray['name'])){
  		$this->valid = false;
  		$errorarray['name'] = 'Name cannot be empty';
  	}
  	else if($this->check_player_name_exists($postarray['name'])){
  			$this->valid = false;
  			$errorarray['name'] = 'There is already a player with that name';
    }
  	else{
  	  $this->name = $postarray['name'];
  	}
  	if(empty($postarray['points'])){
  		$this->valid = false;
  		$errorarray['points'] = 'Points cannot be empty';
  	}
  	else if(!empty($postarray['points']) && !is_numeric($postarray['points'])){
  		$this->valid = false;
  		$errorarray['points'] = 'Points value must be numeric';
  	}
  	else if(!empty($postarray['points']) && $postarray['points'] < 0){
  		$this->valid = false;
  		$errorarray['points'] = 'Points value cannot be less than zero';
  	}
  	else{
  	  $this->points = $postarray['points'];
  	}
  return $errorarray;
  }
  protected function submit_player($postarray){
  	$mysqli = opendbi();
  	if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    	}

  	$stmt = mysqli_prepare($mysqli, "INSERT INTO players (name,points) VALUES (?, ?)");
  	mysqli_stmt_bind_param($stmt,'sd',$name,$points);

  	$name = mysqli_real_escape_string($mysqli,$this->name);
  	$points = mysqli_real_escape_string($mysqli,$this->points);

  	mysqli_stmt_execute($stmt);
  	$this->id = mysqli_stmt_insert_id($stmt);
  	mysqli_stmt_close($stmt);
    
  return true;
  }
  protected function definite_player($postarray){
  	$mysqli = opendbi();
  	if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    	}

  	$stmt = mysqli_prepare($mysqli, "UPDATE players SET definite=? WHERE id=?");
  	mysqli_stmt_bind_param($stmt,'ii',$change,$id);

  	$change = mysqli_real_escape_string($mysqli,$postarray['change']);
  	$id = mysqli_real_escape_string($mysqli,$postarray['id']);

  	mysqli_stmt_execute($stmt);
  	$rows = mysqli_stmt_affected_rows($stmt);
  	mysqli_stmt_close($stmt);
  	if($rows == 1){
  		return true;
  	}
  	else{
  		return false;
  	}
  }

  protected function delete_player($postarray){
  	$mysqli = opendbi();
  	if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    	}

  	$stmt = mysqli_prepare($mysqli, "DELETE FROM players WHERE id=?");
  	mysqli_stmt_bind_param($stmt,'i',$id);

  	$id = mysqli_real_escape_string($mysqli,$postarray['id']);

  	mysqli_stmt_execute($stmt);
  	$rows = mysqli_stmt_affected_rows($stmt);
  	mysqli_stmt_close($stmt);
  	if($rows == 1){
  		return true;
  	}
  	else{
  		return false;
  	}
  }
  private function check_player_name_exists($name){
    $mysqli = opendbi();
		$sql = mysqli_prepare($mysqli,'SELECT id FROM players WHERE name=?');
		mysqli_stmt_bind_param($sql,'s',$name);
		$name = mysqli_real_escape_string($mysqli,$name);
		$sql->execute();
		$sql->store_result();
		if($sql->num_rows > 0){
		  return true;
		}
		else{
		  return false;
		}
  }
}
function submitplayercombinations($postarray){
	ini_set("memory_limit","1000M");
	ini_set('max_execution_time', 600);
	$mysqli = opendbi();
	$sql = 'SELECT name, points, definite FROM players';
	if($result = $mysqli->query($sql)) {
		if($result->num_rows > 4){
			$pointsarray = array();
			$definitearray = array();
			while($obj = $result->fetch_object()){ 
				$name = $obj->name; 
				$points = $obj->points;
				if($obj->definite == 1){
					//array_push($definitearray,$name);
					$definitearray[$name] = $points;
				}
				else{
					$pointsarray[$name] = $points;
				}
			}
		}
	}
	$results = array(array());
	if($pointsarray){
		$set = getplayercombinations($pointsarray,$definitearray);
		foreach($set as $combination){
			if(count($combination) == 5 && array_sum($combination) <= $postarray['numpointshigh'] && array_sum($combination) > $postarray['numpointslow']){
				array_push($results,$combination);
			}
		}
	}
return $results;
}

function getplayercombinations($array,$array2){
	$results = array(array());
	foreach ($array as $name => $points){
	    foreach ($results as $combination){
	        array_push($results, array_merge(array($name => $points), $combination, $array2));
		}
	}
	

return $results;
}

function cmp($a,$b){
	if(array_sum($a) == array_sum($b)){
		return 0;
	}
	return (array_sum($a) < array_sum($b)) ? 1 : -1;
}
?>