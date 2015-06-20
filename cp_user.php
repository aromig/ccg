<?php
	require_once('includes/config.php');

	if (!isset($_POST['userid'])) { die(); }

	$userid = $_POST['userid'];

	$results = $db->select("ccg_users",
		"*",
		array("mcf_userid"=>$userid)
	);

	$json = (!empty($results)) ? json_encode($results[0]) : null;

	echo $json;

?>