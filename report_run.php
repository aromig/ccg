<?php
	$page_title = 'Report a Run - The Cold Callers Guild';
	include_once('./tpl/header.php');

	if (!$_SESSION['registered']) {
?>

<div class="row">
	<div class="col-xs-12"><h3>Ruh Roh!</h3></div>
	<div class="col-xs-12"><h4>Please be sure you are logged into <a href="http://mmocentralforums.com">MMOCentralForums</a> and have registered your account here.</h4></div>
</div>

<?php
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Form validates client-side for the dropdowns
			$btl = $_POST['run_report']; // First get the battle prefix from hidden field ie vp_, cfo_, cj_, ceo_
			$battle = strtoupper(rtrim($btl,"_"));
			// Populate variables for insert
			$run_datetime = $_POST[$btl.'date'].' '.$_POST[$btl.'time'];
				$run_datetime = strtotime($run_datetime);
				$run_datetime = date("Y-m-d H:i:s", $run_datetime);
			$loaded = intval($_POST['loaded']);
			//$danced = intval($_POST['danced']);
			$danced = 0;
			$disco = 0;
			$notes = $_POST['notes'];
			$tzone = $_POST[$btl.'timezone'];

			$reward = $_POST[$btl.'reward'];

			$toons = array(
				0 => array(
					"name"=>"",
					"laff"=>0,
					"suit"=>"",
					"status"=>"Danced",
					"coground"=>0,
					"skeleround"=>0,
					"cleanupround"=>0
				)
			);
			for ($i=1;$i<=$loaded;$i++) {
				$toons[$i]["name"] = (!empty($_POST['toon_'.$i])) ? $_POST['toon_'.$i] : 'Unknown';
				$toons[$i]["laff"] = (!empty($_POST['laff_'.$i])) ? $_POST['laff_'.$i] : null;
				$toons[$i]["suit"] = (!empty($_POST['suit_'.$i])) ? $_POST['suit_'.$i] : null;
				$toons[$i]["suitlevel"] = (!empty($_POST['suitlevel_'.$i])) ? $_POST['suitlevel_'.$i] : null;
				$toons[$i]["status"] = $_POST['status_'.$i];
				$toons[$i]["coground"] = ($_POST['coground_'.$i] == "1") ? 1 : 0;
				$toons[$i]["skeleround"] = ($_POST['skeleround_'.$i] == "1") ? 1 : 0;
				$toons[$i]["cleanupround"] = ($_POST['cleanupround_'.$i] == "1") ? 1 : 0;
				$toon_json[$i] = json_encode($toons[$i]);
				if ($toons[$i]["status"] == "Danced") { $danced++; }
				if ($toons[$i]["status"] == "Disconnected") { $disco++; }
			}

			$loaded -= $disco;

			// $toon_json[$i]; // example: submit this to ccg_ttr_results.toon_$i
			// $toon = json_decode($from_db_field, true); // decode from db
			// $toon["name"]; // access value

			$ccgid = $db->select("ccg_users",
				array("ccg_id"),
				array("mcf_username"=>$_SESSION['user'])
			);

			$columns = array(
				"ccg_id"=>$ccgid[0]['ccg_id'],
				"battle"=>$battle,
				"run_datetime"=>$run_datetime,
				"toons_loaded"=>intval($_POST['loaded']),
				"toons_danced"=>$danced,
				"notes"=>$notes,
				"reward"=>$reward,
				"report_ip"=>$_SERVER['REMOTE_ADDR'],
				"entered_dt"=>date("Y-m-d H:i:s")
			);
			for ($i=1;$i<=8;$i++) {
				if (!empty($toon_json[$i])) {
					$columns["toon_".$i] = $toon_json[$i];
				}
			}

			$stmt = $db->insert("ccg_ttr_results", $columns);

			$report = $ccg->get_ttr_report_by_id($stmt);
			//$report = $ccg->get_ttr_report_by_id(30);
			$run_tstamp = strtotime($report[0]['run_datetime']);
			switch ($tzone) {
				case "PT":
					$user_dt = date("jS F Y", $run_tstamp);
					$user_tm = date("h:i A", $run_tstamp);
					break;
				case "MT":
					$user_dt = date("jS F Y", strtotime("+1 hour", $run_tstamp));
					$user_tm = date("h:i A", strtotime("+1 hour", $run_tstamp));
					break;
				case "CT":
					$user_dt = date("jS F Y", strtotime("+2 hours", $run_tstamp));
					$user_tm = date("h:i A", strtotime("+2 hours", $run_tstamp));
					break;
				case "ET":
					$user_dt = date("jS F Y", strtotime("+3 hours", $run_tstamp));
					$user_tm = date("h:i A", strtotime("+3 hours", $run_tstamp));
					break;
				case "GMT":
					$user_dt = date("jS F Y", strtotime("+7 hours", $run_tstamp));
					$user_tm = date("h:i A", strtotime("+7 hours", $run_tstamp));
					break;
				case "BST":
					$user_dt = date("jS F Y", strtotime("+8 hours", $run_tstamp));
					$user_tm = date("h:i A", strtotime("+8 hours", $run_tstamp));
					break;
				default:
			}
			$dayofweek = date("l", $run_tstamp);
?>

<!-- Content for after POST -->
<div class="row">
	<div class="col-xs-12"><h3><?= $battle ?> Victory Submitted!</h3></div>
	<div class="col-xs-12">
		<p>Your victory results has been logged. Thank you for keeping our records up-to-date!</p>
		<h4>Your Report:</h4>
		<div class="col-xs-12 col-sm-8 report report_<?= strtolower($report[0]['battle']) ?>" id="new_report">
			<div class="col-xs-12">
				<p>
				<strong><?= $report[0]['mcf_username'] ?></strong> reports that on:<br /><br />

				<?= $user_dt ?> at <?php echo $user_tm.' '.$tzone; ?><br />
				<?php echo $report[0]['toons_danced'].'/'.$loaded; ?> danced at the <?= $report[0]['battle'] ?> for <?= $report[0]['reward'] ?>
				</p>
			</div>
			<?php
			for ($i=1;$i<=8;$i++) {
				if (!empty($report[0]['toon_'.$i])) {
					$toon = json_decode($report[0]['toon_'.$i], true);
					echo '<div class="clearfix visible-sm-*"></div>';
					echo '<div class="col-xs-8 col-sm-6 col-md-4">';
					echo ($toon['coground'] == '1') ? '+' : '';
					echo ($toon['skeleround'] == '1') ? '*' : '';
					echo ($toon['cleanupround'] == '1') ? '*' : '';
					echo $toon['name'].' </div><div class="col-xs-4 col-sm-1 col-sm-offset-0">'.$toon['laff'].' </div><div class="col-xs-6 col-sm-5 col-md-3">'.$toon['suit'].' '.$toon['suitlevel'].'</div>';
					echo '<div class="col-xs-6 col-sm-6 col-sm-offset-6 col-md-4 col-md-offset-0">';
					if ($toon['status'] == "Danced") {
						echo $tt->suit_milestones[intval($toon['suitlevel'])][$toon['suit']];
					}
					echo ($toon['status'] != "Danced") ? $toon['status'] : '&nbsp;';
					echo '</div>';
				}
			}
			?>
			<div class="col-xs-12">
				<p>+ Together in Cog Round</p>
				<?= ($battle == 'VP') ? '<p>* Together in Skelecog Round</p>' : '' ?>
				<?= ($battle == 'CEO') ? '<p>* Together in Cleanup Round</p>' : '' ?>
				<p><?= nl2br($report[0]['notes']) ?></p>
			</div>
		</div>
<!-- TextArea to Copy for posting on Forum -->
		<div class="col-xs-12 col-sm-4">
			<button type="button" id="report_copy_btn" class="btn btn-default form-control">
				<span class="glyphicon glyphicon-copy"></span> Copy for Run Thread
			</button>
			<div id="report_copy">
				<h6>Copy (Win: Ctrl-C / Mac: &#8984;-C) the report below to paste into the Run Report thread.</h6>
				<textarea class="form-control" id="report_copy_text" style="height: 250px; margin-bottom: 6px;" readonly><?= $report[0]['mcf_username'] ?> reports that on:

<?= $user_dt ?> at <?php echo $user_tm.' '.$tzone.PHP_EOL; ?>
<?php echo $report[0]['toons_danced'].'/'.$loaded; ?> danced at the <?= $report[0]['battle'] ?> for <?= $report[0]['reward'].PHP_EOL ?>

<?php
			for ($i=1;$i<=8;$i++) {
				if (!empty($report[0]['toon_'.$i])) {
					$toon = json_decode($report[0]['toon_'.$i], true);
					echo ($toon['coground'] == '1') ? '+' : '';
					echo ($toon['skeleround'] == '1') ? '*' : '';
					echo ($toon['cleanupround'] == '1') ? '*' : '';
					echo $toon['name'].' - '.$toon['laff'].' - '.$toon['suit'].' '.$toon['suitlevel'];
					if ($toon['status'] == "Danced") {
						if (!empty($tt->suit_milestones[intval($toon['suitlevel'])][$toon['suit']])) {
							echo ' <- '.$tt->suit_milestones[intval($toon['suitlevel'])][$toon['suit']];
						}
					}
					echo ($toon['status'] != "Danced") ? ' - '.$toon['status'] : '';
					echo PHP_EOL;
				}
			}

			$run_thread = $ccg->get_schedule_array($dayofweek, "run_thread");
			?>

+ Together in Cog Round
<?= ($battle == 'VP') ? '* Together in Skelecog Round'.PHP_EOL : '' ?>
<?= ($battle == 'CEO') ? '* Together in Cleanup Round'.PHP_EOL : '' ?>
<?= PHP_EOL.$report[0]['notes'] ?></textarea>
				<a href="http://www.mmocentralforums.com/forums/newreply.php?do=newreply&noquote=1&t=<?= $run_thread ?>" id="replytothread" class="btn btn-default form-control" target="_blank">
					<span class="glyphicon glyphicon-paste"></span> Reply to <?= $dayofweek ?> Run Thread
				</a>
			</div>
		</div>
	</div>

</div>

<?php
		}
		else
		{
?>

<!-- Content goes here -->
<div class="row">
	<div class="col-xs-12"><h3>Report a TTR Run</h3></div>
		<div class="col-xs-12" id="report_container">
			<p>Please fill out the following form to record your group's boss battle victories on ToonTown Rewritten.</p>
			<ol>
				<li>Choose the boss battle that you are reporting.</li>
				<li>Select the date and time the run occurred.
					<ul><li>Times are generated from the <a href="schedule.php" target="_blank">Run Schedule</a> depending on the day of the week you choose.</li></ul></li>
				<li>Select the reward given at the end of the boss battle.</li>
				<li>Select the number of toons that loaded onto the elevator and how many danced at the end.
					<ul><li>Please use the correct number of toons that loaded. If a toon disconnected during the fight, it will be accounted for when the victory results are generated as long as you choose "Disconnected" instead of "Danced".</li></ul></li>
				<li>Enter the toons' information to the best of your ability.</li>
				<li>Enter any notes or thoughts about the battle.</li>
				<li>Submit your report and you will be given the opportunity to copy it to the appropriate Run Report thread on the forum.</li>
			</ol>
			<p><strong>Please Remember!</strong> All <a href="http://www.disneysonlineworlds.com/index.php/Policies_and_Disclaimers" target="_blank">MMOCentralForums' Site Rules</a> apply when submitting your run report.</p>
		<form role="form" method="post" action="" autocomplete="on" id="report_run" class="form-horizontal">
			<input type="hidden" name="run_report" id="run_report" value="vp_" />
			<div class="col-xs-12">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="pill" href="#vp">VP</a></li>
					<li><a data-toggle="pill" href="#cfo">CFO</a></li>
					<li><a data-toggle="pill" href="#cj">CJ</a></li>
					<li><a data-toggle="pill" href="#ceo">CEO</a></li>
				</ul>
				<div class="col-sm-6">
					<?php
						if (isset($error)) {
							foreach ($error as $err) {
								echo '<label class="input-lg bg-danger error">'.$err.'</label>';
							}
						}
					?>
				</div>
				<div class="tab-content">
					<div id="vp" class="tab-pane fade in active">
						<h4>Vice President</h4>
						<div class="form-group form-group-sm">
							<label for="vp_date" title="VP Run Date" class="control-label col-xs-12 col-sm-3">Date:</label>
							<div class="col-xs-12 col-sm-3">
								<input type="text" name="vp_date" id="vp_date" class="run_date form-control datepicker" style="cursor: pointer;" placeholder="Date" tabindex="1" value="<?= date('m/d/Y') ?>" readonly>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="vp_time" title="VP Run Time" class="control-label col-xs-12 col-sm-3">Time:</label>
							<div class="form-inline col-xs-12 col-sm-8">
								<select name="vp_time" id="vp_time" class="form-control" tabindex="2" required oninvalid="this.setCustomValidity('Please select a run time.')" oninput="setCustomValidity('')">

								</select>
								<select name="vp_timezone" id="vp_timezone" class="run_date form-control" tabindex="3">
									<option value="PT">Pacific</option>
									<option value="MT">Mountain</option>
									<option value="CT">Central</option>
									<option value="ET">Eastern</option>
									<option value="GMT">GMT</option>
									<option value="BST">BST</option>
								</select>
							</div>
						</div>

						<div class="form-group form-group-sm">
							<label for="vp_reward" title="Toon Rescued" class="control-label col-xs-12 col-sm-3">Toon Rescued:</label>
							<div class="col-xs-12 col-sm-3">
								<select name="vp_reward" id="vp_reward" class="form-control" tabindex="4" required oninvalid="this.setCustomValidity('Please choose the toon you rescued.')" oninput="setCustomValidity('')">
								<?php
									foreach ($tt->vp_sos_card as $sos) {
										echo '<option value="'.$sos.'">'.$sos.'</option>';
									}
								?>
								</select>
							</div>
						</div>
					</div>
					<div id="cfo" class="tab-pane fade">
						<h4>Chief Financial Officer</h4>
						<div class="form-group form-group-sm">
							<label for="cfo_date" title="VP Run Date" class="control-label col-xs-12 col-sm-3">Date:</label>
							<div class="col-xs-12 col-sm-3">
								<input type="text" name="cfo_date" id="cfo_date" class="run_date form-control datepicker" style="cursor: pointer;" placeholder="Date" tabindex="1" value="<?= date('m/d/Y') ?>" readonly>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="cfo_time" title="VP Run Time" class="control-label col-xs-12 col-sm-3">Time:</label>
							<div class="form-inline col-xs-12 col-sm-8">
								<select name="cfo_time" id="cfo_time" class="form-control" tabindex="2"ceo_ oninvalid="this.setCustomValidity('Please select a run time.')" oninput="setCustomValidity('')">

								</select>
								<select name="cfo_timezone" id="cfo_timezone" class="run_date form-control" tabindex="3">
									<option value="PT">Pacific</option>
									<option value="MT">Mountain</option>
									<option value="CT">Central</option>
									<option value="ET">Eastern</option>
									<option value="GMT">GMT</option>
									<option value="BST">BST</option>
								</select>
							</div>
						</div>

						<div class="form-group form-group-sm">
							<label for="cfo_reward" title="Unite Phrase" class="control-label col-xs-12 col-sm-3">Unite Phrase:</label>
							<div class="col-xs-12 col-sm-3">
								<select name="cfo_reward" id="cfo_reward" class="form-control" tabindex="4"ceo_ oninvalid="this.setCustomValidity('Please choose the unite phrase you received.')" oninput="setCustomValidity('')">
								<?php
									foreach ($tt->cfo_unite_phrase as $unite) {
										echo '<option value="'.$unite.'">'.$unite.'</option>';
									}
								?>
								</select>
							</div>
						</div>
					</div>
					<div id="cj" class="tab-pane fade">
						<h4>Chief Justice</h4>
						<div class="form-group form-group-sm">
							<label for="cj_date" title="VP Run Date" class="control-label col-xs-12 col-sm-3">Date:</label>
							<div class="col-xs-12 col-sm-3">
								<input type="text" name="cj_date" id="cj_date" class="run_date form-control datepicker" style="cursor: pointer;" placeholder="Date" tabindex="1" value="<?= date('m/d/Y') ?>" readonly>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="cj_time" title="VP Run Time" class="control-label col-xs-12 col-sm-3">Time:</label>
							<div class="form-inline col-xs-12 col-sm-8">
								<select name="cj_time" id="cj_time" class="form-control" tabindex="2"ceo_ oninvalid="this.setCustomValidity('Please select a run time.')" oninput="setCustomValidity('')">

								</select>
								<select name="cj_timezone" id="cj_timezone" class="run_date form-control" tabindex="3">
									<option value="PT">Pacific</option>
									<option value="MT">Mountain</option>
									<option value="CT">Central</option>
									<option value="ET">Eastern</option>
									<option value="GMT">GMT</option>
									<option value="BST">BST</option>
								</select>
							</div>
						</div>

						<div class="form-group form-group-sm">
							<label for="cj_reward" title="Cog Summons" class="control-label col-xs-12 col-sm-3">Cog Summons:</label>
							<div class="col-xs-12 col-sm-3">
								<select name="cj_reward" id="cj_reward" class="form-control" tabindex="4"ceo_ oninvalid="this.setCustomValidity('Please choose the cog summons you received.')" oninput="setCustomValidity('')">
								<?php
									foreach ($tt->cj_summons as $summons) {
										echo '<option value="'.$summons.'">'.$summons.'</option>';
									}
								?>
								</select>
							</div>
						</div>
					</div>
					<div id="ceo" class="tab-pane fade">
						<h4>Chief Executive Officer</h4>
						<div class="form-group form-group-sm">
							<label for="ceo_date" title="VP Run Date" class="control-label col-xs-12 col-sm-3">Date:</label>
							<div class="col-xs-12 col-sm-3">
								<input type="text" name="ceo_date" id="ceo_date" class="run_date form-control datepicker" style="cursor: pointer;" placeholder="Date" tabindex="1" value="<?= date('m/d/Y') ?>" readonly>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="ceo_time" title="VP Run Time" class="control-label col-xs-12 col-sm-3">Time:</label>
							<div class="form-inline col-xs-12 col-sm-8">
								<select name="ceo_time" id="ceo_time" class="form-control" tabindex="2"ceo_ oninvalid="this.setCustomValidity('Please select a run time.')" oninput="setCustomValidity('')">

								</select>
								<select name="ceo_timezone" id="ceo_timezone" class="run_date form-control" tabindex="3">
									<option value="PT">Pacific</option>
									<option value="MT">Mountain</option>
									<option value="CT">Central</option>
									<option value="ET">Eastern</option>
									<option value="GMT">GMT</option>
									<option value="BST">BST</option>
								</select>
							</div>
						</div>

						<div class="form-group form-group-sm">
							<label for="ceo_reward" title="Pink Slip" class="control-label col-xs-12 col-sm-3">Pink Slip:</label>
							<div class="col-xs-12 col-sm-3">
								<select name="ceo_reward" id="ceo_reward" class="form-control" tabindex="4"ceo_ oninvalid="this.setCustomValidity('Please choose the pink slip you received.')" oninput="setCustomValidity('')">
								<?php
									foreach ($tt->ceo_pink_slip as $slip) {
										echo '<option value="'.$slip.'">'.$slip.'</option>';
									}
								?>
								</select>
							</div>
						</div>
					</div>
				</div>
					<div class="form-group form-group-sm">
						<label for="loaded" title="Toons Loaded" class="control-label col-xs-12 col-sm-3"># Toons Loaded:</label>
						<div class="col-xs-4 col-sm-2">
							<select name="loaded" id="loaded" class="form-control" tabindex="5" required oninvalid="this.setCustomValidity('How many toons loaded into the elevator?')" oninput="setCustomValidity('')">
								<option value=""></option>
								<?php for ($i=1;$i<=8;$i++) { echo '<option value="'.$i,'">'.$i.'</option>'; } ?>
							</select>
						</div>
					</div>
					<!--div class="form-group form-group-sm">
						<label for="danced" title="Toons Danced" class="control-label col-xs-12 col-sm-3"># Toons Danced:</label>
						<div class="col-xs-4 col-sm-2">
							<select name="danced" id="danced" class="form-control" tabindex="5" required oninvalid="this.setCustomValidity('How many toons danced at the end of the battle?')" oninput="setCustomValidity('')">
								<option value=""></option>
								<?php for ($i=1;$i<=8;$i++) { echo '<option value="'.$i,'">'.$i.'</option>'; } ?>
							</select>
						</div>
					</div-->
<!-- BEGIN TOON INPUT AREA -->
					<div id="toon_1" class="col-xs-12 toon_info">
						<div class="toon_no">1.</div>
						<div class="form-inline col-xs-12">
							<input type="text" name="toon_1" id="toon_1" placeholder="Name" class="col-xs-8 col-sm-4 form_field input-sm"> 
							<input type="text" name="laff_1" id="laff_1" placeholder="Laff" class="col-xs-3 col-sm-2 form_field input-sm">
							<select name="suit_1" id="suit_1" class="col-xs-8 col-sm-3 form_field input-sm suit">
								<option value="">Suit</option>
								<?php
									foreach ($tt->cogsuits["sellbot"] as $suit) {
										if (!empty($suit)) { echo '<option value="'.$suit.'">'.$suit.'</option>'; }
									}
								?>
							</select>
							<select name="suitlevel_1" id="suitlevel_1" class="col-xs-3 col-sm-1 form_field input-sm">

							</select>
						</div>
						<div class="form-inline col-xs-12">
							<select name="status_1" id="status_1" class="col-xs-6 col-sm-3 form_field input-sm">
								<option value="Danced">Danced</option>
								<option value="Sad in Cog Round">Sad in Cog Round</option>
								<option value="Sad in Skele Round">Sad in Skele Round</option>
								<option value="Sad in Pie Round">Sad in Pie Round</option>
								<option value="Disconnected">Disconnected</option>
								<option value="Alt-F4'd">Alt-F4'd</option>
								<option value="Unknown">Unknown</option>
							</select>
							<div class="col-xs-12 col-sm-8">Together in:
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default">
										<input type="checkbox" name="coground_1" id="coground_1" value="1">Cog Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="skeleround_1" id="skeleround_1" value="1">Skele Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="cleanupround_1" id="cleanupround_1" value="1">Cleanup Round
									</label>
								</div>
							</div>
						</div>
					</div>
					<div id="toon_2" class="col-xs-12 toon_info">
						<div class="toon_no">2.</div>
						<div class="form-inline col-xs-12">
							<input type="text" name="toon_2" id="toon_2" placeholder="Name" class="col-xs-8 col-sm-4 form_field input-sm"> 
							<input type="text" name="laff_2" id="laff_2" placeholder="Laff" class="col-xs-3 col-sm-2 form_field input-sm">
							<select name="suit_2" id="suit_2" class="col-xs-8 col-sm-3 form_field input-sm suit">
								<option value="">Suit</option>
								<?php
									foreach ($tt->cogsuits["sellbot"] as $suit) {
										if (!empty($suit)) { echo '<option value="'.$suit.'">'.$suit.'</option>'; }
									}
								?>
							</select>
							<select name="suitlevel_2" id="suitlevel_2" class="col-xs-3 col-sm-1 form_field input-sm">

							</select>
						</div>
						<div class="form-inline col-xs-12">
							<select name="status_2" id="status_2" class="col-xs-6 col-sm-3 form_field input-sm">
								<option value="Danced">Danced</option>
								<option value="Sad in Cog Round">Sad in Cog Round</option>
								<option value="Sad in Skele Round">Sad in Skele Round</option>
								<option value="Sad in Pie Round">Sad in Pie Round</option>
								<option value="Disconnected">Disconnected</option>
								<option value="Alt-F4'd">Alt-F4'd</option>
								<option value="Unknown">Unknown</option>
							</select>
							<div class="col-xs-12 col-sm-8">Together in:
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default">
										<input type="checkbox" name="coground_2" id="coground_2" value="1">Cog Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="skeleround_2" id="skeleround_2" value="1">Skele Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="cleanupround_2" id="cleanupround_2" value="1">Cleanup Round
									</label>
								</div>
							</div>
						</div>
					</div>
					<div id="toon_3" class="col-xs-12 toon_info">
						<div class="toon_no">3.</div>
						<div class="form-inline col-xs-12">
							<input type="text" name="toon_3" id="toon_3" placeholder="Name" class="col-xs-8 col-sm-4 form_field input-sm"> 
							<input type="text" name="laff_3" id="laff_3" placeholder="Laff" class="col-xs-3 col-sm-2 form_field input-sm">
							<select name="suit_3" id="suit_3" class="col-xs-8 col-sm-3 form_field input-sm suit">
								<option value="">Suit</option>
								<?php
									foreach ($tt->cogsuits["sellbot"] as $suit) {
										if (!empty($suit)) { echo '<option value="'.$suit.'">'.$suit.'</option>'; }
									}
								?>
							</select>
							<select name="suitlevel_3" id="suitlevel_3" class="col-xs-3 col-sm-1 form_field input-sm">

							</select>
						</div>
						<div class="form-inline col-xs-12">
							<select name="status_3" id="status_3" class="col-xs-6 col-sm-3 form_field input-sm">
								<option value="Danced">Danced</option>
								<option value="Sad in Cog Round">Sad in Cog Round</option>
								<option value="Sad in Skele Round">Sad in Skele Round</option>
								<option value="Sad in Pie Round">Sad in Pie Round</option>
								<option value="Disconnected">Disconnected</option>
								<option value="Alt-F4'd">Alt-F4'd</option>
								<option value="Unknown">Unknown</option>
							</select>
							<div class="col-xs-12 col-sm-8">Together in:
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default">
										<input type="checkbox" name="coground_3" id="coground_3" value="1">Cog Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="skeleround_3" id="skeleround_3" value="1">Skele Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="cleanupround_3" id="cleanupround_3" value="1">Cleanup Round
									</label>
								</div>
							</div>
						</div>
					</div>
					<div id="toon_4" class="col-xs-12 toon_info">
						<div class="toon_no">4.</div>
						<div class="form-inline col-xs-12">
							<input type="text" name="toon_4" id="toon_4" placeholder="Name" class="col-xs-8 col-sm-4 form_field input-sm"> 
							<input type="text" name="laff_4" id="laff_4" placeholder="Laff" class="col-xs-3 col-sm-2 form_field input-sm">
							<select name="suit_4" id="suit_4" class="col-xs-8 col-sm-3 form_field input-sm suit">
								<option value="">Suit</option>
								<?php
									foreach ($tt->cogsuits["sellbot"] as $suit) {
										if (!empty($suit)) { echo '<option value="'.$suit.'">'.$suit.'</option>'; }
									}
								?>
							</select>
							<select name="suitlevel_4" id="suitlevel_4" class="col-xs-3 col-sm-1 form_field input-sm">

							</select>
						</div>
						<div class="form-inline col-xs-12">
							<select name="status_4" id="status_4" class="col-xs-6 col-sm-3 form_field input-sm">
								<option value="Danced">Danced</option>
								<option value="Sad in Cog Round">Sad in Cog Round</option>
								<option value="Sad in Skele Round">Sad in Skele Round</option>
								<option value="Sad in Pie Round">Sad in Pie Round</option>
								<option value="Disconnected">Disconnected</option>
								<option value="Alt-F4'd">Alt-F4'd</option>
								<option value="Unknown">Unknown</option>
							</select>
							<div class="col-xs-12 col-sm-8">Together in:
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default">
										<input type="checkbox" name="coground_4" id="coground_4" value="1">Cog Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="skeleround_4" id="skeleround_4" value="1">Skele Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="cleanupround_4" id="cleanupround_4" value="1">Cleanup Round
									</label>
								</div>
							</div>
						</div>
					</div>
					<div id="toon_5" class="col-xs-12 toon_info">
						<div class="toon_no">5.</div>
						<div class="form-inline col-xs-12">
							<input type="text" name="toon_5" id="toon_5" placeholder="Name" class="col-xs-8 col-xs-4 form_field input-sm"> 
							<input type="text" name="laff_5" id="laff_5" placeholder="Laff" class="col-xs-3 col-sm-2 form_field input-sm">
							<select name="suit_5" id="suit_5" class="col-xs-8 col-sm-3 form_field input-sm suit">
								<option value="">Suit</option>
								<?php
									foreach ($tt->cogsuits["sellbot"] as $suit) {
										if (!empty($suit)) { echo '<option value="'.$suit.'">'.$suit.'</option>'; }
									}
								?>
							</select>
							<select name="suitlevel_5" id="suitlevel_5" class="col-xs-3 col-sm-1 form_field input-sm">

							</select>
						</div>
						<div class="form-inline col-xs-12">
							<select name="status_5" id="status_5" class="col-xs-6 col-sm-3 form_field input-sm">
								<option value="Danced">Danced</option>
								<option value="Sad in Cog Round">Sad in Cog Round</option>
								<option value="Sad in Skele Round">Sad in Skele Round</option>
								<option value="Sad in Pie Round">Sad in Pie Round</option>
								<option value="Disconnected">Disconnected</option>
								<option value="Alt-F4'd">Alt-F4'd</option>
								<option value="Unknown">Unknown</option>
							</select>
							<div class="col-xs-12 col-sm-8">Together in:
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default">
										<input type="checkbox" name="coground_5" id="coground_5" value="1">Cog Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="skeleround_5" id="skeleround_5" value="1">Skele Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="cleanupround_5" id="cleanupround_5" value="1">Cleanup Round
									</label>
								</div>
							</div>
						</div>
					</div>
					<div id="toon_6" class="col-xs-12 toon_info">
						<div class="toon_no">6.</div>
						<div class="form-inline col-xs-12">
							<input type="text" name="toon_6" id="toon_6" placeholder="Name" class="col-xs-8 col-xs-4 form_field input-sm"> 
							<input type="text" name="laff_6" id="laff_6" placeholder="Laff" class="col-xs-3 col-sm-2 form_field input-sm">
							<select name="suit_6" id="suit_6" class="col-xs-8 col-sm-3 form_field input-sm suit">
								<option value="">Suit</option>
								<?php
									foreach ($tt->cogsuits["sellbot"] as $suit) {
										if (!empty($suit)) { echo '<option value="'.$suit.'">'.$suit.'</option>'; }
									}
								?>
							</select>
							<select name="suitlevel_6" id="suitlevel_6" class="col-xs-3 col-sm-1 form_field input-sm">

							</select>
						</div>
						<div class="form-inline col-xs-12">
							<select name="status_6" id="status_6" class="col-xs-6 col-sm-3 form_field input-sm">
								<option value="Danced">Danced</option>
								<option value="Sad in Cog Round">Sad in Cog Round</option>
								<option value="Sad in Skele Round">Sad in Skele Round</option>
								<option value="Sad in Pie Round">Sad in Pie Round</option>
								<option value="Disconnected">Disconnected</option>
								<option value="Alt-F4'd">Alt-F4'd</option>
								<option value="Unknown">Unknown</option>
							</select>
							<div class="col-xs-12 col-sm-8">Together in:
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default">
										<input type="checkbox" name="coground_6" id="coground_6" value="1">Cog Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="skeleround_6" id="skeleround_6" value="1">Skele Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="cleanupround_6" id="cleanupround_6" value="1">Cleanup Round
									</label>
								</div>
							</div>
						</div>
					</div>
					<div id="toon_7" class="col-xs-12 toon_info">
						<div class="toon_no">7.</div>
						<div class="form-inline col-xs-12">
							<input type="text" name="toon_7" id="toon_7" placeholder="Name" class="col-xs-8 col-sm-4 form_field input-sm"> 
							<input type="text" name="laff_7" id="laff_7" placeholder="Laff" class="col-xs-3 col-sm-2 form_field input-sm">
							<select name="suit_7" id="suit_7" class="col-xs-8 col-sm-3 form_field input-sm suit">
								<option value="">Suit</option>
								<?php
									foreach ($tt->cogsuits["sellbot"] as $suit) {
										if (!empty($suit)) { echo '<option value="'.$suit.'">'.$suit.'</option>'; }
									}
								?>
							</select>
							<select name="suitlevel_7" id="suitlevel_7" class="col-xs-3 col-sm-1 form_field input-sm">

							</select>
						</div>
						<div class="form-inline col-xs-12">
							<select name="status_7" id="status_7" class="col-xs-6 col-sm-3 form_field input-sm">
								<option value="Danced">Danced</option>
								<option value="Sad in Cog Round">Sad in Cog Round</option>
								<option value="Sad in Skele Round">Sad in Skele Round</option>
								<option value="Sad in Pie Round">Sad in Pie Round</option>
								<option value="Disconnected">Disconnected</option>
								<option value="Alt-F4'd">Alt-F4'd</option>
								<option value="Unknown">Unknown</option>
							</select>
							<div class="col-xs-12 col-sm-8">Together in:
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default">
										<input type="checkbox" name="coground_7" id="coground_7" value="1">Cog Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="skeleround_7" id="skeleround_7" value="1">Skele Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="cleanupround_7" id="cleanupround_7" value="1">Cleanup Round
									</label>
								</div>
							</div>
						</div>
					</div>
					<div id="toon_8" class="col-xs-12 toon_info">
						<div class="toon_no">8.</div>
						<div class="form-inline col-xs-12">
							<input type="text" name="toon_8" id="toon_8" placeholder="Name" class="col-xs-8 col-sm-4 form_field input-sm"> 
							<input type="text" name="laff_8" id="laff_8" placeholder="Laff" class="col-xs-3 col-sm-2 form_field input-sm">
							<select name="suit_8" id="suit_8" class="col-xs-8 col-sm-3 form_field input-sm suit">
								<option value="">Suit</option>
								<?php
									foreach ($tt->cogsuits["sellbot"] as $suit) {
										if (!empty($suit)) { echo '<option value="'.$suit.'">'.$suit.'</option>'; }
									}
								?>
							</select>
							<select name="suitlevel_8" id="suitlevel_8" class="col-xs-3 col-sm-1 form_field input-sm">

							</select>
						</div>
						<div class="form-inline col-xs-12">
							<select name="status_8" id="status_8" class="col-xs-6 col-sm-3 form_field input-sm">
								<option value="Danced">Danced</option>
								<option value="Sad in Cog Round">Sad in Cog Round</option>
								<option value="Sad in Skele Round">Sad in Skele Round</option>
								<option value="Sad in Pie Round">Sad in Pie Round</option>
								<option value="Disconnected">Disconnected</option>
								<option value="Alt-F4'd">Alt-F4'd</option>
								<option value="Unknown">Unknown</option>
							</select>
							<div class="col-xs-12 col-sm-8">Together in:
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default">
										<input type="checkbox" name="coground_8" id="coground_8" value="1">Cog Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="skeleround_8" id="skeleround_8" value="1">Skele Round
									</label>
									<label class="btn btn-default">
										<input type="checkbox" name="cleanupround_8" id="cleanupround_8" value="1">Cleanup Round
									</label>
								</div>
							</div>
						</div>
					</div>
<!-- END TOON INPUT AREA -->
					<div class="form-group">
						<label for="notes" title="Notes" class="control-label col-xs-12 col-sm-3">Notes:</label>
						<div class="col-xs-12 col-sm-6">
							<textarea name="notes" id="notes" rows="4" class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-xs-12 col-sm-4 col-sm-offset-3 col-md-3 centered">
							<input type="submit" name="" id="submit" class="btn btn-lg btn-primary" value="Submit Victory Results">
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<?php 	}
	}
?>

<!-- footer -->
	</div>
    </div>

<?php include_once('./tpl/footer.php'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/report_run.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$(".datepicker").datepicker();
    	});
    </script>

  </body>
</html>