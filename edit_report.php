<?php
	require_once('includes/config.php');

	if (!isset($_POST['resultid'])) { die(); }

	$resultid = $_POST['resultid'];

	$results = $db->select("ccg_ttr_results",
		"*",
		array("result_id"=>$resultid)
	);

	$json = (!empty($results)) ? json_encode($results[0]) : null;

	echo $json;
?>