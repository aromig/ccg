<?php
	require_once('includes/config.php');

	if ($_SERVER['REQUEST_METHOD'] != "POST") { die('Access Denied'); }

	$html = '';
	$day = $_POST['day'];
	$start_times = $ccg->get_schedule_array($day, "start_times");
	$battles = $ccg->get_schedule_array($day, "battle_order");
	
	for ($t=0;$t<count($start_times);$t++) {
		for ($b=0;$b<count($battles);$b++) {
			$battle = $battles[$b];
			switch ($battle) {
				case "VP": $html .= '<tr class="warning">'; break;
				case "CFO": $html .= '<tr class="success">'; break;
				case "CJ": $html .= '<tr class="info">'; break;
				case "CEO": $html .= '<tr class="danger">'; break;
				default: $html .= '<tr>';
			}
			$html .= '<td>'.$battle.'</td>';
			if ($b != 0) {
				$run_time = strtotime($tt->prior_run_length[$battle], $prior_start_time);
				$prior_start_time = $run_time;
			} else { // Don't apply run_time to the first run of the section
				$run_time = strtotime($start_times[$t]);
				$prior_start_time = $run_time;
			}
			$html .= '<td>'.date("h:i A", $run_time).'</td>';						 // Pacfic Time
			$html .= '<td>'.date("h:i A", strtotime("+1 hour", $run_time)).'</td>';  // Mountain Time
			$html .= '<td>'.date("h:i A", strtotime("+2 hours", $run_time)).'</td>'; // Central Time
			$html .= '<td>'.date("h:i A", strtotime("+3 hours", $run_time)).'</td>'; // Eastern Time
			$html .= '<td>'.date("h:i A", strtotime($ccg->GMT_hours(), $run_time)).'</td>'; // GMT
			$html .= '<td>'.date("h:i A", strtotime("+8 hours", $run_time)).'</td>'; // British Summer Time
			$html .= '</tr>';
		}
		$html .= '<tr><td colspan="7"></td></tr>';
	}

	echo $html;
?>