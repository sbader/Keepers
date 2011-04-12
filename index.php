<?php
require_once('config.php');
require_once('player.php');
include('header.php');
if(isset($_POST['submit'])){
	$errorarray = validateplayer($_POST);
	if($errorarray['valid']){
		submitplayer($_POST);
	}
}
else if(isset($_POST['submitcalc'])){
	$comboresults = submitplayercombinations($_POST);
}
?>
<div id="leftcol">
	<form action="" method="post" id="playerform">
		<fieldset>
			<div>
				<label for="name">Player Name</label><br />
				<input type="text" name="name" id="name" class="required" value="<?php if(isset($errorarray['valid']) && isset($_POST['name']) && !$errorarray['valid']) echo $_POST['name']; ?>"/>
				<?php if(isset($errorarray['name'])){ 
					echo '<div class="error">' . $errorarray['name'] . '</div>';
				} ?>
			</div>
			<div>
				<label for="points">Points</label<br />
				<input type="text" name="points" id="points" class="required" value="<?php if(isset($errorarray['valid']) && isset($_POST['points']) && !$errorarray['valid']) echo $_POST['points']; ?>"/>
				<?php if(isset($errorarray['points'])){ 
					echo '<div class="error">' . $errorarray['points'] . '</div>';
				} ?>
			</div>
			<div>
				<input type="submit" name="submit" value="Add To List" id="submitplayer" />
			</div>
		</fieldset>
	</form>
	<?php
	require_once('config.php');
	$mysqli = opendbi();
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$sql = "SELECT name, points, id, definite FROM players ORDER BY points DESC, name ASC";
	if($result = $mysqli->query($sql)) {
		if($result->num_rows > 0){
	?>
		<table id="playerstable">
			<tr>
				<th style="width: 250px;">Name</th>
				<th style="width: 50px;">Points</th>
				<th style="width: 50px;text-align: center;">Definite</th>
				<th style="width: 50px;text-align: center;">Delete</th>
			</tr>
			<?php
			while($obj = $result->fetch_object()){ 
				$name = $obj->name; 
				$points = $obj->points;
				$id = $obj->id;
				$def = $obj->definite;
				if($def == 1){$defdisplay = 'check.gif';}else{$defdisplay = 'checkgr.gif';}
			?>
			<tr>
				<td class="name"><?php echo $name; ?></td>
				<td class="points"><?php echo number_format($points,2); ?></td>
				<td class="def"><a href="" class="defa" id="<?php echo $id; ?>" ><img src="images/<?php echo $defdisplay; ?>" /></a></td>
				<td class="del"><a href="" class="dela" id="<?php echo $id; ?>" >Delete?</a></td>
			</tr>
			<?php
			}
			?>
		</table>
	<?php
		}
	  $result->close();
	}
	?>
</div>
<div id="rightcol">
	<div id="rightdiv">
		<form action="" method="post">
			<fieldset>
				<div>
					<label for="numpoints">Max Points</label><br />
					<input type="text" name="numpointshigh" value="<?php if(isset($_POST['numpointshigh'])) echo $_POST['numpointshigh']; else echo 2300; ?>" id="numpoints"/>
				</div>
				<div>
					<label for="numpoints">Lower Limit</label><br />
					<input type="text" name="numpointslow" value="<?php if(isset($_POST['numpointslow'])) echo $_POST['numpointslow']; else echo 1400; ?>" id="numpoints"/>
				</div>
				<div>
					<input type="submit" name="submitcalc" value="Calculate Combinations" />
				</div>
			</fieldset>
		</form>
	</div>
	<?php 
	if(isset($comboresults) && count($comboresults) > 0){
		usort($comboresults,'cmp');
		foreach($comboresults as $combinations){
			if(count($combinations) == 5){
				arsort($combinations);
			?>
			<table>
				<tr>
					<th style="width: 300px;">Name</th>
					<th style="width: 100px;">Points</th>
				</tr>
				<?php
				foreach($combinations as $name => $points){
		?>
			<tr>
				<td class="name"><?php echo $name; ?></td>
				<td class="points"><?php echo number_format($points,2); ?></td>
			</tr>
		<?php
				}
				?>
			<tr>
				<td class="name">Total</td>
				<td class="points"><?php echo array_sum($combinations); ?></td>
			</tr>
				<?php
			}
		?>
			</table>
		<?php
		}
		?>
	<?php	
	} 
	?>
</div>
<script type="text/javascript" src="scripts/index.js"></script>
<?php include('footer.php'); ?>
