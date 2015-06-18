<?php
	require_once('includes/config.php');

	$html = '';
	$suit = $_POST['suit'];

	$html .= '<option value=""></option>';
	foreach ($tt->suit_levels[$suit] as $level) {
		$html .= '<option value="'.$level.'">'.$level.'</option>';
	}

	echo $html;
?>