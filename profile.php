<?php
	$page_title = 'Your Profile - The Cold Callers Guild';
	include_once('./tpl/header.php');

	if (!$_SESSION['registered']) {
?>

<div class="row">
	<div class="col-xs-12"><h3>Ruh Roh!</h3></div>
	<div class="col-xs-12"><h4>Please be sure you are logged into <a href="http://mmocentralforums.com">MMOCentralForums</a> and have registered your account here.</h4></div>
</div>

<?php
	} else {
?>

<!-- Content goes here -->
<div class="row">
	<div class="col-xs-12"><h3>Welcome to your profile, <?= $_SESSION['user'] ?>!</h3></div>
	<div class="col-xs-12"><h4>

<?php
	$toons = $db->select(
		"ccg_toons",				 						// FROM ccg_toons
		array("[><]ccg_users"=>array("ccg_id"=>"ccg_id")),	// INNER JOIN ccg_users ON ccg_toons.ccg_id = ccg_users.ccg_id
		array("ccg_toons.toon",
			  "ccg_toons.laff",
			  "ccg_toons.max_toonup",
			  "ccg_toons.max_trap",
			  "ccg_toons.max_lure",
			  "ccg_toons.max_sound",
			  "ccg_toons.max_throw",
			  "ccg_toons.max_squirt",
			  "ccg_toons.max_drop",
			  "ccg_toons.sellsuit",
			  "ccg_toons.cashsuit",
			  "ccg_toons.lawsuit",
			  "ccg_toons.bosssuit",
			  "ccg_toons.toon_id"
		),													// SELECT ccg_toons.*
		array("ccg_users.mcf_username"=>$_SESSION['user'],	// WHERE ccg_users.user = $_SESSION['user']
			  "ORDER"=>"ccg_toons.toon ASC")
	);
	
	if (empty($toons)) {
		echo '<p>You have no toons registered.</p>';
	} else {
		echo '<p>You have '.sizeof($toons).' toon'.(sizeof($toons) > 1 ? 's' : '').' registered.</p>';
	}
?>
	</h4></div>
	<div class="col-xs-12" id="profile_register"><button class="btn btn-primary btn-lg" onclick="window.location.href='add_toon.php';"><span class="glyphicon glyphicon-plus"></span> Register a Toon</button></div>

<?php if (!empty($toons)) { foreach ($toons as $toon) { ?>
	<div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-0">
		<div class="profile_toon well">
			<h4><?= $toon['toon'] ?></h4>
			<h5><?= $toon['laff'] ?> Laff</h5>
			<div class="profile_gags row">
				<h4>Gags</h4>
				<div class="col-xs-12 col-sm-6">
			<?php
				$gags = 0;
				if ((int)$toon['max_toonup']>0) { echo '<img src="gags/gag_toonup'.$toon['max_toonup'].'.png" />'; $gags++; }
				if ((int)$toon['max_trap']>0) { echo '<img src="gags/gag_trap'.$toon['max_trap'].'.png" />'; $gags++; }
				if ((int)$toon['max_lure']>0) { echo '<img src="gags/gag_lure'.$toon['max_lure'].'.png" />'; $gags++; }
					if ($gags == 3) echo '</div><div class="col-xs-12 col-sm-6">';
				if ((int)$toon['max_sound']>0) { echo '<img src="gags/gag_sound'.$toon['max_sound'].'.png" />'; $gags++; }
					if ($gags == 3) echo '</div><div class="col-xs-12 col-sm-6">';
				if ((int)$toon['max_throw']>0) { echo '<img src="gags/gag_throw'.$toon['max_throw'].'.png" />'; $gags++; }
					if ($gags == 3) echo '</div><div class="col-xs-12 col-sm-6">';
				if ((int)$toon['max_squirt']>0) { echo '<img src="gags/gag_squirt'.$toon['max_squirt'].'.png" />'; $gags++; }
					if ($gags == 3) echo '</div><div class="col-xs-12 col-sm-6">';
				if ((int)$toon['max_drop']>0) echo '<img src="gags/gag_drop'.$toon['max_drop'].'.png" />';
			?>
				</div>
			</div>
			<div class="profile_suits">
				<h4>Cog Suits</h4>
			<?php
			$filter_in = array(" ", ".");
			$filter_out = array("_", "");
				echo '<img src="cogs/cogs_'.strtolower(str_replace($filter_in, $filter_out, $toon['sellsuit'])).'.png" title="'.$toon['sellsuit'].'" class="img-circle" />';
				echo '<img src="cogs/cogs_'.strtolower(str_replace($filter_in, $filter_out, $toon['cashsuit'])).'.png" title="'.$toon['cashsuit'].'" class="img-circle" />';
				echo '<img src="cogs/cogs_'.strtolower(str_replace($filter_in, $filter_out, $toon['lawsuit'])).'.png" title="'.$toon['lawsuit'].'" class="img-circle" />';
				echo '<img src="cogs/cogs_'.strtolower(str_replace($filter_in, $filter_out, $toon['bosssuit'])).'.png" title="'.$toon['bosssuit'].'" class="img-circle" />';
			?>
			</div>
			<div class="profile_btns">
				<a href="#" class="delete_toon" id="<?= $toon['toon'] ?>|<?= $toon['toon_id'] ?>"><img src="images/delete.png" title="Delete <?= $toon['toon'] ?>" /></a> 
				<a href="edit_toon.php?id=<?= $toon['toon_id'] ?>"><img src="images/update.png" title="Edit <?= $toon['toon'] ?>" /></a>
			</div>
		</div>

	</div>
<?php } } ?>

</div>

<div id="delete_toon">
	<h3>Delete Toon</h3>
	<div class="err" id="add_err"></div>
	<form action="delete_toon.php">
		<div class="row">
			<div class="col-xs-12" id="prompt">

			</div>
			<div class="col-xs-10 col-xs-offset-1">
				<p>* This action cannot be undone!</p>
			</div>
			<input type="hidden" name="delete_toon_id" id="delete_toon_id" />
			<div class="col-xs-5 col-xs-offset-1">
				<input type="submit" id="confirm_delete" value="Yes" class="btn btn-primary btn-block btn-lg" />
			</div>
			<div class="col-xs-5">
				<input type="button" id="cancel_delete" value="No" class="btn btn-danger btn-block btn-lg" />
			</div>
		</div>
	</form>
</div>

<?php } ?>

<!-- footer -->
	</div>
    </div>

    <footer class="container centered">
        
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="js/delete_toon.js"></script>

  </body>
</html>