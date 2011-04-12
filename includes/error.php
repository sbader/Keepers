<?php
function errorclass($field,$errorarray,$dontecho = false){
	$returnecho = '';
	$fieldexplode = explode(',',$field);
	foreach($fieldexplode as $value){
		if(isset($errorarray[$value])){
			$errorset = true;
		}
	}
	if(isset($errorset) && $errorset){
		$returnecho = ' class="errorfield" ';
		if($dontecho == false){
			echo $returnecho;
		}
	}
	return $returnecho;
}
?>