<?php
	require_once('includes/config.php');

	$html = '';
	$battle = strtolower($_POST['battle']);

	foreach ($tt->battle_status[$battle] as $status) {
		$html .= '<option value="'.$status.'">'.$status.'</option>';
	}

	echo $html;
?>