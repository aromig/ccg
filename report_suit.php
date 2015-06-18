<?php
	require_once('includes/config.php');

	$html = '';
	$battle = $_POST['battle'];

	switch ($battle) {
		case 'vp': $cog = 'sellbot'; break;
		case 'cfo': $cog = 'cashbot'; break;
		case 'cj': $cog = 'lawbot'; break;
		case 'ceo': $cog = 'bossbot'; break;
		default:
	}

	foreach ($tt->cogsuits[$cog] as $suit) {
		if ($suit == '') {
			$html .= '<option value="'.$suit.'">Suit</option>';
		} else {
			$html .= '<option value="'.$suit.'">'.$suit.'</option>';
		}
	}

	echo $html;
?>