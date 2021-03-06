<?php
	require_once('includes/config.php');
	
	if ($_SERVER['REQUEST_METHOD'] != "POST") { die('Access Denied'); }

	$html = '';
	$type = $_POST['type'];
	$run_month = (!empty($_POST['month'])) ? $_POST['month'] : null;
	$run_date = (!empty($_POST['date'])) ? $_POST['date'] : null;
	$run_time = (!empty($_POST['time'])) ? $_POST['time'] : null;
	$timezone = (!empty($_POST['tz'])) ? $_POST['tz'] : null;
	$battle = (!empty($_POST['battle'])) ? $_POST['battle'] : null;

	if ($type == 'by_date') {
		$reports = $ccg->get_ttr_reports_by_date($run_date, $run_time, $battle);
	} else if ($type == 'by_month') {
		$reports = $ccg->get_ttr_reports_by_month($run_month, $battle);
	}

	if (!empty($reports)) {
		echo '<h5>'.count($reports).' Reports Found</h5>';

		foreach ($reports as $report) {
			$disco = 0;

			$toon = array();
			for ($i=1;$i<=8;$i++) {
				$toon[$i] = json_decode($report['toon_'.$i], true);
				if ($toon[$i]['status'] == "Disconnected") { $disco++; }
			}

			$loaded = intval($report['toons_loaded']) - $disco;

			$run_tstamp = strtotime($report['run_datetime']);

			switch ($timezone) {
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
					$user_dt = date("jS F Y", strtotime($ccg->GMT_hours(), $run_tstamp));
					$user_tm = date("h:i A", strtotime($ccg->GMT_hours(), $run_tstamp));
					break;
				case "BST":
					$user_dt = date("jS F Y", strtotime("+8 hours", $run_tstamp));
					$user_tm = date("h:i A", strtotime("+8 hours", $run_tstamp));
					break;
				default:
			}
	?> 
		<div class="col-xs-12 report report_<?= strtolower($report['battle']) ?>" id="report_<?= $report['result_id'] ?>">
			<div class="col-xs-12">
				<p>
					<strong><?= $report['mcf_username'] ?></strong> reports that on:<br />

					<?= $user_dt ?> at <?php echo $user_tm.' '.$timezone; ?><br />
					<?php echo $report['toons_danced'].'/'.$loaded; ?> danced at the <?= $report['battle'] ?> for <?= $report['reward'] ?>
				</p>
			</div>

	<?php
		for ($i=1;$i<=8;$i++) {
			if (!empty($toon[$i])) {
				echo '<div class="clearfix visible-sm-*"></div>';
				echo '<div class="col-xs-8 col-sm-4 col-md-3">';
				echo ($toon[$i]['coground'] == '1') ? '+' : '';
				echo ($toon[$i]['skeleround'] == '1') ? '*' : '';
				echo ($toon[$i]['cleanupround'] == '1') ? '*' : '';
				echo $toon[$i]['name'].' </div><div class="col-xs-4 col-sm-1 col-sm-offset-0 col-md-1">'.$toon[$i]['laff'].' </div><div class="col-xs-6 col-sm-4 col-md-4">'.$toon[$i]['suit'].' '.$toon[$i]['suitlevel'].'</div>';
				echo '<div class="col-xs-6 col-sm-3 col-sm-offset-0 col-md-4">';
				if ($toon[$i]['status'] == "Danced") {
						if (!empty($tt->suit_milestones[intval($toon[$i]['suitlevel'])][$toon[$i]['suit']])) {
							echo $tt->suit_milestones[intval($toon[$i]['suitlevel'])][$toon[$i]['suit']];
						}
					}
				echo ($toon[$i]['status'] != "Danced") ? $toon[$i]['status'] : '&nbsp;';
				echo '</div>';
			}
		}
	?>
			<div class="col-xs-12">
				<p>+ Together in Cog Round</p>
				<?= ($report["battle"] == 'VP') ? '<p>* Together in Skelecog Round</p>' : '' ?>
				<?= ($report["battle"] == 'CEO') ? '<p>* Together in Cleanup Round</p>' : '' ?>
				<p><?= nl2br($report['notes']) ?></p>
			</div>
			<?php
				if ($report['mcf_username'] == $_SESSION['user'] || $ccg->is_admin($_SESSION['user'])) {
			?>
				<a href="#" id="<?= $report['result_id'].'_'.$timezone ?>" class="edit_report" title="Edit Report"><img src="images/cog_35x35.png" alt="Edit Report" /></a>
			<?php }
				if ($ccg->is_admin($_SESSION['user'])) { ?>
				<a href="#" id="delete_<?= $report['result_id'] ?>" class="delete_report" title="Delete Report"><img src="images/delete.png" alt="Delete Report" /></a>
			<?php }
			?>
		</div>
	<?php
		}
	} else {
		echo '<h5>No Reports Found</h5>';
	}
?>