<?php
	$page_title = 'Register a New Toon - The Cold Callers Guild';
	include_once('./tpl/header.php');

	if (!$_SESSION['registered']) {
?>

<div class="row">
	<div class="col-xs-12"><h3>Ruh Roh!</h3></div>
	<div class="col-xs-12"><h4>Please be sure you are logged into <a href="http://mmocentralforums.com">MMOCentralForums</a> and have registered your account here.</h4></div>
</div>

<?php
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Form was submitted
			// Validate Name & Laff
			if (!preg_match('/^[a-zA-Z][a-zA-Z\. ]+$/', $_POST['toon_name'])) {
				$error[] = 'Name is not valid.';
			}
			if (!preg_match('/^\d+$/', $_POST['toon_laff'])) {
				$error[] = 'Laff is not valid.';
			} elseif ((int)$_POST['toon_laff'] < 15) {
				$error[] = 'Laff is not valid.';
			}
			// Validated! Insert new row into database and go back to Profile page
			// Get ccg_id of logged in user first
			$ccgid = $db->select("ccg_users",
				array("ccg_id"),
				array("mcf_username"=>$_SESSION['user'])
			);
			if (!isset($error)) {
				// Insert
				$stmt = $db->insert("ccg_toons", array(
					"ccg_id"=>$ccgid[0]['ccg_id'],
					"toon"=>$_POST['toon_name'],
					"laff"=>$_POST['toon_laff'],
					"max_toonup"=>$_POST['gags_toonup'],
					"max_trap"=>$_POST['gags_trap'],
					"max_lure"=>$_POST['gags_lure'],
					"max_sound"=>$_POST['gags_sound'],
					"max_throw"=>$_POST['gags_throw'],
					"max_squirt"=>$_POST['gags_squirt'],
					"max_drop"=>$_POST['gags_drop'],
					"sellsuit"=>$_POST['suit_sell'],
					"cashsuit"=>$_POST['suit_cash'],
					"lawsuit"=>$_POST['suit_law'],
					"bosssuit"=>$_POST['suit_boss'],
					"last_update"=>date("Y-m-d H:i:s")
				));
				// Redirect to Profile page
				die('<script type="text/javascript">window.location.href="profile.php";</script>');
			}
		}
?>

<!-- Content goes here -->
<div class="row">
	<div class="col-xs-12"><h3>Add a Toon</h3></div>
	<div class="col-xs-12"><h4></h4></div>
	<div class="col-sm-6 col-xs-12">
		<form role="form" method="post" action="" autocomplete="on" id="add_toon" class="form-horizontal">
			<div class="form-group form-group-sm">
				<label for="toon_name" title="Toon Name" class="control-label col-xs-6 col-sm-3">Name</label>
				<div class="col-xs-6 col-sm-9">
					<input type="text" name="toon_name" id="toon_name" class="form-control" placeholder="Toon Name" tabindex="1" value="<?= $_POST['toon_name'] ?>">
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="toon_laff" title="Laff Points" class="control-label col-xs-6 col-sm-3">Laff</label>
				<div class="col-xs-6 col-sm-9">
					<input type="text" name="toon_laff" id="toon_laff" class="form-control" placeholder="Laff Points" tabindex="2" value="<?= $_POST['toon_laff'] ?>">
				</div>
			</div>

			<h5>Gags</h5>
			<div class="form-group form-group-sm">
				<label for="gags_toonup" title="Toon Up" class="control-label col-xs-6 col-sm-3">Toon-Up</label>
				<div class="col-xs-6 col-sm-9">
					<select name="gags_toonup" id="gags_toonup" class="form-control" tabindex="3">>
						<?php
							for ($i=0;$i<=7;$i++) {
								echo '<option value="'.$i.'"';
								if ($_POST['gags_toonup'] == $i) { echo ' selected'; }
								echo '>'.$tt->gags['toonup'][$i].'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="gags_trap" title="Trap" class="control-label col-xs-6 col-sm-3">Trap</label>
				<div class="col-xs-6 col-sm-9">
					<select name="gags_trap" id="gags_trap" class="form-control" tabindex="4">>
						<?php
							for ($i=0;$i<=7;$i++) {
								echo '<option value="'.$i.'"';
								if ($_POST['gags_trap'] == $i) { echo ' selected'; }
								echo '>'.$tt->gags['trap'][$i].'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="gags_lure" title="Lure" class="control-label col-xs-6 col-sm-3">Lure</label>
				<div class="col-xs-6 col-sm-9">
					<select name="gags_lure" id="gags_lure" class="form-control" tabindex="5">>
						<?php
							for ($i=0;$i<=7;$i++) {
								echo '<option value="'.$i.'"';
								if ($_POST['gags_lure'] == $i) { echo ' selected'; }
								echo '>'.$tt->gags['lure'][$i].'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="gags_sound" title="Sound" class="control-label col-xs-6 col-sm-3">Sound</label>
				<div class="col-xs-6 col-sm-9">
					<select name="gags_sound" id="gags_sound" class="form-control" tabindex="6">>
						<?php
							for ($i=0;$i<=7;$i++) {
								echo '<option value="'.$i.'"';
								if ($_POST['gags_sound'] == $i) { echo ' selected'; }
								echo '>'.$tt->gags['sound'][$i].'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="gags_throw" title="Throw" class="control-label col-xs-6 col-sm-3">Throw</label>
				<div class="col-xs-6 col-sm-9">
					<select name="gags_throw" id="gags_throw" class="form-control" tabindex="7">>
						<?php
							for ($i=0;$i<=7;$i++) {
								echo '<option value="'.$i.'"';
								if ($_POST['gags_throw'] == $i) { echo ' selected'; }
								echo '>'.$tt->gags['throw'][$i].'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="gags_squirt" title="Squirt" class="control-label col-xs-6 col-sm-3">Squirt</label>
				<div class="col-xs-6 col-sm-9">
					<select name="gags_squirt" id="gags_squirt" class="form-control" tabindex="8">>
						<?php
							for ($i=0;$i<=7;$i++) {
								echo '<option value="'.$i.'"';
								if ($_POST['gags_squirt'] == $i) { echo ' selected'; }
								echo '>'.$tt->gags['squirt'][$i].'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="gags_drop" title="Drop" class="control-label col-xs-6 col-sm-3">Drop</label>
				<div class="col-xs-6 col-sm-9">
					<select name="gags_drop" id="gags_drop" class="form-control" tabindex="9">>
						<?php
							for ($i=0;$i<=7;$i++) {
								echo '<option value="'.$i.'"';
								if ($_POST['gags_drop'] == $i) { echo ' selected'; }
								echo '>'.$tt->gags['drop'][$i].'</option>';
							}
						?>
					</select>
				</div>
			</div>

			<h5>Cog Suits</h5>
			<div class="form-group form-group-sm">
				<label for="suit_sell" title="Sellbot Suit" class="control-label col-xs-6 col-sm-3">Sellbot</label>
				<div class="col-xs-6 col-sm-9">
					<select name="suit_sell" id="suit_sell" class="form-control" tabindex="10">
					<?php
						foreach ($tt->cogsuits['sellbot'] as $suit) {
							echo '<option value="'.$suit.'"';
							if ($_POST['suit_sell'] == $suit) { echo ' selected'; }
							echo '>'.$suit.'</option>';
						}
					?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="suit_cash" title="Cashbot Suit" class="control-label col-xs-6 col-sm-3">Cashbot</label>
				<div class="col-xs-6 col-sm-9">
					<select name="suit_cash" id="suit_cash" class="form-control" tabindex="11">
					<?php
						foreach ($tt->cogsuits['cashbot'] as $suit) {
							echo '<option value="'.$suit.'"';
							if ($_POST['suit_cash'] == $suit) { echo ' selected'; }
							echo '>'.$suit.'</option>';
						}
					?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="suit_law" title="Lawbot Suit" class="control-label col-xs-6 col-sm-3">Lawbot</label>
				<div class="col-xs-6 col-sm-9">
					<select name="suit_law" id="suit_law" class="form-control" tabindex="12">
					<?php
						foreach ($tt->cogsuits['lawbot'] as $suit) {
							echo '<option value="'.$suit.'"';
							if ($_POST['suit_law'] == $suit) { echo ' selected'; }
							echo '>'.$suit.'</option>';
						}
					?>
					</select>
				</div>
			</div>
			<div class="form-group form-group-sm">
				<label for="suit_boss" title="Bossbot Suit" class="control-label col-xs-6 col-sm-3">Bossbot</label>
				<div class="col-xs-6 col-sm-9">
					<select name="suit_boss" id="suit_boss" class="form-control" tabindex="13">
					<?php
						foreach ($tt->cogsuits['bossbot'] as $suit) {
							echo '<option value="'.$suit.'"';
							if ($_POST['suit_boss'] == $suit) { echo ' selected'; }
							echo '>'.$suit.'</option>';
						}
					?>
					</select>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<div class="col-xs-6 col-sm-9 col-xs-offset-3 col-sm-offset-3">
					<input type="submit" name="submit" value="Add Toon" class="btn btn-primary btn-block btn-lg" tabindex="14">
				</div>
			</div>
		</form>
	</div>
	<div class="col-sm-6">
		<?php
			if (isset($error)) {
				foreach ($error as $err) {
					echo '<label class="input-lg bg-danger error">'.$err.'</label>';
				}
			}
		?>
	</div>
</div>

<?php } ?>
<!-- footer -->
	</div>
    </div>

<?php include_once('./tpl/footer.php'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
        
  </body>
</html>