<?php
	require_once('includes/config.php');

	if ($_SERVER['REQUEST_METHOD'] != "POST") { die('Access Denied'); }

	$ref = $_SERVER['HTTP_REFERER'];

	if (strpos($ref, 'www.mmocentralforums.com/ccg/admincp.php') === false) {
		die('Access Denied');
	}

	$toon_id = $_POST['toon_id'];
	$toon = $_POST['toon'];

	// toon_id did not match the logged in user
	if (!$ccg->is_admin($_SESSION['user'])) {
		echo 'false';
	} else { // if toon_id matches logged in user, proceed
		$rows = $db->delete("ccg_toons", array("toon_id"=>$toon_id));

		if ($rows > 0) {
			echo '<div class="col-xs-12"><h6>Toon "'.$toon.'"" deleted</h6>';
		} else {
			echo '<div class="col-xs-12"><h6>Something went wrong.<br />Toon "'.$toon.'" not deleted.</h6>';
		}
	}
?>