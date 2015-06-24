<?php
	require_once('includes/config.php');

	if ($_SERVER['REQUEST_METHOD'] != "POST") { die('Access Denied'); }

	$html = '';
	$suit = $_POST['suit'];

	$html .= '<option value=""></option>';
	if ($suit != '') {
		foreach ($tt->suit_levels[$suit] as $level) {
			$html .= '<option value="'.$level.'">'.$level.'</option>';
		}
	}

	echo $html;
?>