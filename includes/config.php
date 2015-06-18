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
include('classes/user.php');
include('classes/toontown.php');
include('classes/ccg.php');

$db = new medoo();
$user = new User();
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
			array("last_login"=>date("Y-m-d"), "last_ip"=>$_SERVER['REMOTE_ADDR'], "bassie"=>$bassie),
			array("mcf_username"=>$_SESSION['user'])
		);
	}
}

/*// If the rememberme cookie exists and aren't logged in, log in the user that matches the token
if (!$user->is_logged_in() && (isset($_COOKIE['rememberme']))) {
	$results = $db->select("ccg_users", "user", array("persistToken"=>$_COOKIE['rememberme']));
	if (!empty($results)) {
        $_SESSION['user'] = $results[0];
        $_SESSION['loggedin'] = true;
	}
}*/

?>