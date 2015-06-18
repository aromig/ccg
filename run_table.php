<?php
	require_once('includes/config.php');

	$html = '';
	$day = $_POST['day'];
	for ($t=0;$t<count($tt->run_schedule[$day]["start_time"]);$t++) {
		for ($b=0;$b<count($tt->run_schedule[$day]["battle"]);$b++) {
			$battle = $tt->run_schedule[$day]["battle"][$b];
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
				$run_time = strtotime($tt->run_schedule[$day]["start_time"][$t]);
				$prior_start_time = $run_time;
			}
			$html .= '<td>'.date("h:i A", $run_time).'</td>';						 // Pacfic Time
			$html .= '<td>'.date("h:i A", strtotime("+1 hour", $run_time)).'</td>';  // Mountain Time
			$html .= '<td>'.date("h:i A", strtotime("+2 hours", $run_time)).'</td>'; // Central Time
			$html .= '<td>'.date("h:i A", strtotime("+3 hours", $run_time)).'</td>'; // Eastern Time
			$html .= '<td>'.date("h:i A", strtotime("+7 hours", $run_time)).'</td>'; // Greenwich Mean Time
			$html .= '<td>'.date("h:i A", strtotime("+8 hours", $run_time)).'</td>'; // British Summer Time
			$html .= '</tr>';
		}
		$html .= '<tr><td colspan="7"></td></tr>';
	}

	echo $html;
?>