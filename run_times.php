<?php
	require_once('includes/config.php');

	if ($_SERVER['REQUEST_METHOD'] != "POST") { die('Access Denied'); }

	$html = '<option value=""></option>';
	$battle = $_POST['battle'];
	$battle_date = $_POST['date'];
	$timezone = $_POST['tz'];

	$day = date('l', strtotime($battle_date));
	$start_times = $ccg->get_schedule_array($day, "start_times");
	$battles = $ccg->get_schedule_array($day, "battle_order");

	for ($t=0;$t<count($start_times);$t++) {
		for ($b=0;$b<count($battles);$b++) {
			if ($b != 0) {
				$run_time = strtotime($tt->prior_run_length[$battles[$b]], $prior_start_time);
				$prior_start_time = $run_time;
			} else {
				$run_time = strtotime($start_times[$t]);
				$prior_start_time = $run_time;
			}

			if ($battle != '') {
				if (strtolower($battles[$b]) == strtolower($battle)) {
					switch ($timezone) {
						case "PT":
							$html .= '<option value="'.date("h:i A", $run_time).'">'.date("h:i A", $run_time).'</option>';
							break;
						case "MT":
							$html .= '<option value="'.date("h:i A", $run_time).'">';
							$html .= date("h:i A", strtotime("+1 hour", $run_time)).'</option>';
							break;
						case "CT":
							$html .= '<option value="'.date("h:i A", $run_time).'">';
							$html .= date("h:i A", strtotime("+2 hours", $run_time)).'</option>';
							break;
						case "ET":
							$html .= '<option value="'.date("h:i A", $run_time).'">';
							$html .= date("h:i A", strtotime("+3 hours", $run_time)).'</option>';
							break;
						case "GMT":
							$html .= '<option value="'.date("h:i A", $run_time).'">';
							$html .= date("h:i A", strtotime("+7 hours", $run_time)).'</option>';
							break;
						case "BST":
							$html .= '<option value="'.date("h:i A", $run_time).'">';
							$html .= date("h:i A", strtotime("+8 hours", $run_time)).'</option>';
							break;
					}
				}
			} else {
				switch ($timezone) {
					case "PT":
						$html .= '<option value="'.date("h:i A", $run_time).'">'.date("h:i A", $run_time).'</option>';
						break;
					case "MT":
						$html .= '<option value="'.date("h:i A", $run_time).'">';
						$html .= date("h:i A", strtotime("+1 hour", $run_time)).'</option>';
						break;
					case "CT":
						$html .= '<option value="'.date("h:i A", $run_time).'">';
						$html .= date("h:i A", strtotime("+2 hours", $run_time)).'</option>';
						break;
					case "ET":
						$html .= '<option value="'.date("h:i A", $run_time).'">';
						$html .= date("h:i A", strtotime("+3 hours", $run_time)).'</option>';
						break;
					case "GMT":
						$html .= '<option value="'.date("h:i A", $run_time).'">';
						$html .= date("h:i A", strtotime("+7 hours", $run_time)).'</option>';
						break;
					case "BST":
						$html .= '<option value="'.date("h:i A", $run_time).'">';
						$html .= date("h:i A", strtotime("+8 hours", $run_time)).'</option>';
						break;
					}
			}
		}
	}

	echo $html;
?>