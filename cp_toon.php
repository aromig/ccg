<?php
	require_once('includes/config.php');

	if ($_SERVER['REQUEST_METHOD'] != "POST") { die('Access Denied'); }

	if (!isset($_POST['toonid'])) { die(); }

	$toonid = $_POST['toonid'];

	$results = $db->select("ccg_toons",
		array("[><]ccg_users"=>array("ccg_id"=>"ccg_id")),
		array("ccg_users.mcf_username",
			  "ccg_toons.toon_id",
			  "ccg_toons.toon",
			  "ccg_toons.laff",
			  "ccg_toons.max_toonup",
			  "ccg_toons.max_trap",
			  "ccg_toons.max_lure",
			  "ccg_toons.max_sound",
			  "ccg_toons.max_throw",
			  "ccg_toons.max_squirt",
			  "ccg_toons.max_drop",
			  "ccg_toons.sellsuit",
			  "ccg_toons.cashsuit",
			  "ccg_toons.lawsuit",
			  "ccg_toons.bosssuit"
			),
		array("ccg_toons.toon_id"=>$toonid)
	);

	$json = (!empty($results)) ? json_encode($results[0]) : null;

	echo $json;

?>