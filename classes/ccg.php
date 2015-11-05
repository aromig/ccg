<?php

class CCG {
	public function GMT_Hours() {
		return date('I') ? "+7 hours" : "+8 hours";
	}

	public function is_BST() {
		$today = strtotime("today");
		$year = date('y');
		$BSTstart = strtotime($year."-03-31 last Sunday");
		$BSTend = strtotime($year."-10-31 last Sunday");
		if ($today < $BSTstart || $today > $BSTend) {
			return false;
		} else {
			return true;
		}
	}

	public $ccg_roles = array(
		"0"  => "Unregistered",
		"32" => "CCG Member",
		"41" => "CCG Ambassador",
		"11" => "MCF Mini-Mod",
		"7"  => "MCF Moderator",
		"5"  => "MCF Super Moderator",
		"6"  => "MCF Administrator"
		);

	public function is_bassie($uname) {
		$db = new medoo();
		$bassie = false;
		$match = $db->count("ccg_users", array(
			"AND"=> array(
				"ccg_users.mcf_username"=>$uname,
				"ccg_users.bassie"=>1
			)
		));
		if ($match > 0) { $bassie = true; }

		return $bassie;
	}

	public function is_admin($uname) {
		$db = new medoo();
		$admin = false;
		$match = $db->count("ccg_users", array(
			"AND"=> array(
				"ccg_users.mcf_username"=>$uname,
				"ccg_users.admin"=>1
			)
		));
		if ($match > 0) { $admin = true; }

		return $admin;
	}

	public function is_ccg_user($usr) {

		// Check Primary Usergroup and then Additional Usergroups

		$valid_user = false;
		$pri_group = $usr['usergroupid'];
		$role = "Unregistered";

		switch ($pri_group) {
			case '11':	$valid_user = true; $role = "MCF Mini-Mod"; break; // Mini-Mod
			case '7' :	$valid_user = true; $role = "MCF Moderator"; break; // Moderator
			case '5' :	$valid_user = true; $role = "MCF Super Moderator"; break; // Super Moderator
			case '6' :	$valid_user = true; $role = "MCF Administrator"; break; // Administrator
			default: // Keep $valid_user's current value
		}

		if (!$valid_user) {
			$groups = explode(",", $usr['membergroupids']);
			foreach ($groups as $group) {
				switch ($group) {
					case '32':	$valid_user = true; if ($role != "CCG Ambassador") { $role = "CCG Member"; } break; // CCG
					case '41':	$valid_user = true; $role = "CCG Ambassador"; break; // CCG Ambassador
					case '11':	$valid_user = true; $role = "MCF Mini-Mod"; break; // Mini-Mod
					case '7' :	$valid_user = true; $role = "MCF Moderator"; break; // Moderator
					case '5' :	$valid_user = true; $role = "MCF Super Moderator"; break; // Super Moderator
					case '6' :	$valid_user = true; $role = "MCF Administrator"; break; // Administrator
					default: // Keep $valid_user's current value
				}
			}
		}

		$_SESSION['role'] = $role;

		return $valid_user;
	}

	public function get_ttr_report_by_id($id) {
		$db = new medoo();
		$run_report = $db->select(
			"ccg_ttr_results",
			array("[><]ccg_users"=>array("ccg_id"=>"ccg_id")),
			array("ccg_ttr_results.result_id",
				  "ccg_ttr_results.battle",
				  "ccg_ttr_results.run_datetime",
				  "ccg_ttr_results.toons_loaded",
				  "ccg_ttr_results.toons_danced",
				  "ccg_ttr_results.notes",
				  "ccg_ttr_results.toon_1",
				  "ccg_ttr_results.toon_2",
				  "ccg_ttr_results.toon_3",
				  "ccg_ttr_results.toon_4",
				  "ccg_ttr_results.toon_5",
				  "ccg_ttr_results.toon_6",
				  "ccg_ttr_results.toon_7",
				  "ccg_ttr_results.toon_8",
				  "ccg_ttr_results.reward",
				  "ccg_users.mcf_username"
			),
			array("ccg_ttr_results.result_id"=>$id)
		);

		return (!empty($run_report)) ? $run_report : null;
	}

	public function get_ttr_reports_by_month($run_month, $battle = null) {
		$date = explode("/", $run_month);
		$month = $date[0];
		$endmonth = sprintf('%02d', (intval($month, 10) + 1));
		$year = $date[1];
		$endyear = ($month == '12') ? intval($year) + 1 : $year;

		$where = array();
		$where["ccg_ttr_results.run_datetime[<>]"] = array($year.'-'.$month.'-01 00:00:00', $endyear.'-'.$endmonth.'-01 00:00:00');
		if (!empty($battle)) {
			$where["ccg_ttr_results.battle"] = $battle;
		}

		$db = new medoo();
		$run_report = $db->select(
			"ccg_ttr_results",
			array("[><]ccg_users"=>array("ccg_id"=>"ccg_id")),
			array("ccg_ttr_results.result_id",
				  "ccg_ttr_results.battle",
				  "ccg_ttr_results.run_datetime",
				  "ccg_ttr_results.toons_loaded",
				  "ccg_ttr_results.toons_danced",
				  "ccg_ttr_results.notes",
				  "ccg_ttr_results.toon_1",
				  "ccg_ttr_results.toon_2",
				  "ccg_ttr_results.toon_3",
				  "ccg_ttr_results.toon_4",
				  "ccg_ttr_results.toon_5",
				  "ccg_ttr_results.toon_6",
				  "ccg_ttr_results.toon_7",
				  "ccg_ttr_results.toon_8",
				  "ccg_ttr_results.reward",
				  "ccg_users.mcf_username"
			),
			array(
				"AND"=>$where,
				"ORDER"=>"ccg_ttr_results.run_datetime DESC"
				)
		);

		return (!empty($run_report)) ? $run_report : null;
	}

	public function get_ttr_reports_by_date($run_date, $run_time = null, $battle = null) {
		if (!empty($run_time)) {
			$run_datetime = $run_date.' '.$run_time;
			$run_datetime = strtotime($run_datetime);
			$run_datetime = date("Y-m-d H:i:s", $run_datetime);
		} else {
			$run_datetime = date("Y-m-d", strtotime($run_date));
		}

		$where = array();
		if (!empty($run_time)) {
			$where["ccg_ttr_results.run_datetime"] = $run_datetime;
		} else {
			$where["ccg_ttr_results.run_datetime[<>]"] = array($run_datetime. ' 00:00:00', $run_datetime. ' 23:59:59');
		}		
		if (!empty($battle)) {
			$where["ccg_ttr_results.battle"] = $battle;
		}

		$db = new medoo();
		$run_report = $db->select(
			"ccg_ttr_results",
			array("[><]ccg_users"=>array("ccg_id"=>"ccg_id")),
			array("ccg_ttr_results.result_id",
				  "ccg_ttr_results.battle",
				  "ccg_ttr_results.run_datetime",
				  "ccg_ttr_results.toons_loaded",
				  "ccg_ttr_results.toons_danced",
				  "ccg_ttr_results.notes",
				  "ccg_ttr_results.toon_1",
				  "ccg_ttr_results.toon_2",
				  "ccg_ttr_results.toon_3",
				  "ccg_ttr_results.toon_4",
				  "ccg_ttr_results.toon_5",
				  "ccg_ttr_results.toon_6",
				  "ccg_ttr_results.toon_7",
				  "ccg_ttr_results.toon_8",
				  "ccg_ttr_results.reward",
				  "ccg_users.mcf_username"
			),
			array(
				"AND"=>$where,
				"ORDER"=>"ccg_ttr_results.run_datetime DESC"
				)
		);
		
		return (!empty($run_report)) ? $run_report : null;
	}

	public function get_ttr_var($var) {
		$db = new medoo();
		$vars = $db->select(
			"ccg_ttr_vars",
			"value",
			array("var"=>$var)
		);

		return (!empty($vars)) ? $vars[0] : null;
	}

	public function get_schedule_array($day, $column) {
		$db = new medoo();
		$results = $db->select(
			"ccg_ttr_schedule",
			$column,
			array("dayofweek"=>$day)
		);

		return (!empty($results)) ? json_decode($results[0], true) : null;
	}

}

?>