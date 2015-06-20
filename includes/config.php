<?php
session_start();

// Define site-wide constants
define('SITE','http://24.223.185.18/ccg/');
define('SITEEMAIL','noreply@ccg.mmocentralforums.com');
define('PASSWORD_REQ','/^\S*(?=\S{7,})(?=\S*[a-z])(?=\S*[A-Z])((?=\S*[\d])|(?=\S*[\W]))\S*$/');
	// PASSWORD_REQ = 1 uppercase AND 1 lowercase AND (1 number OR 1 symbol)

chdir('../forums/');
include('global.php');
chdir('../ccg');

$current_user = $vbulletin->userinfo;

include('classes/medoo.php');
include('classes/toontown.php');
include('classes/ccg.php');

$db = new medoo();
$tt = new ToonTown();
$ccg = new CCG();

unset($_SESSION['user']);
unset($_SESSION['registered']);

if ($ccg->is_ccg_user($current_user)) {
	$_SESSION['user'] = $current_user['username'];

	$results = $db->select("ccg_users", "mcf_username", array("mcf_username"=>$_SESSION['user']));
	if (!empty($results)) {
		$_SESSION['registered'] = true;
	} else {
		$_SESSION['registered'] = false;
	}

	$bassie = ($_SESSION['role'] == "CCG Ambassador") ? 1 : 0;

	if ($_SESSION['registered']) {
		$update = $db->update("ccg_users",
			array("last_login"=>date("Y-m-d"), "last_ip"=>$_SERVER['REMOTE_ADDR'], "bassie"=>$bassie, "mcf_title"=>$_SESSION['role']),
			array("mcf_username"=>$_SESSION['user'])
		);
	}
}

?>