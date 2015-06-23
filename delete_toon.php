<?php
	require_once('includes/config.php');

	if ($_SERVER['REQUEST_METHOD'] != "POST") { die('Access Denied'); }

	$ref = $_SERVER['HTTP_REFERER'];

	if (strpos($ref, 'www.mmocentralforums.com/ccg/profile.php') === false) {
		die('Access Denied');
	}

	$toon_id = $_POST['toon_id'];

	// Security Check: Match up ccg_id between $_SESSION['user'] & requested toon_id
	$id_match = $db->select("ccg_toons",
		array("[><]ccg_users"=>array("ccg_id"=>"ccg_id")),
		array("ccg_toons.ccg_id"),
		array("AND" =>
			array("ccg_users.mcf_username"=>$_SESSION['user'],
				"ccg_toons.toon_id"=>$toon_id
			)
		)
	);

	// toon_id did not match the logged in user
	if (empty($id_match)) {
		echo 'false';
	} else { // if toon_id matches logged in user, proceed
		$rows = $db->delete("ccg_toons", array("toon_id"=>$toon_id));

		if ($rows > 0) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
?>