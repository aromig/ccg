<?php
	require_once('includes/config.php');

	if ($_SERVER['REQUEST_METHOD'] != "POST") { die("Access Denied"); }

	$ref = $_SERVER['HTTP_REFERER'];

	if (strpos($ref, 'www.mmocentralforums.com/ccg/victories.php') === false) {
		die('Access Denied');
	}

	$result_id = $_POST['result_id'];

	// Security Check: Match up ccg_id between $_SESSION['user']
	$id_match = $db->select("ccg_ttr_results",
		array("[><]ccg_users"=>array("ccg_id"=>"ccg_id")),
		array("ccg_ttr_results.ccg_id"),
		array("AND"=>
			array("ccg_users.mcf_username"=>$_SESSION['user'],
				"ccg_ttr_results.result_id"=>$result_id
			)
		)
	);

	// Security Check: Or is_admin?
	if (empty($id_match)) { $id_match = $ccg->is_admin($_SESSION['user']); }

	if (empty($id_match)) {
		echo 'false';
	} else {
		$rows = $db->delete("ccg_ttr_results", array("result_id"=>$result_id));

		if ($rows > 0) { echo 'true'; }
		else { echo 'false'; }
	}
?>