<?php
	require_once('includes/config.php');

	if (!isset($_POST['query']) || !isset($_POST['type'])) { die(); }

	$html = '';
	$type = $_POST['type'];
	$query = (!empty($_POST['query'])) ? $_POST['query'] : '%';

	if ($type == 'user') {
		$count = $db->count("ccg_users",array("mcf_username[~]"=>$query));

		$results = $db->select("ccg_users",
			array("mcf_username","mcf_userid"),
			array("mcf_username[~]"=>$query,
				  "ORDER"=>"mcf_username ASC")
		);

		$html .= '<div class="col-xs-12 well well-sm"><h6>'.$count.' user'.(($count > 1) ? 's' : '').' found.</h6>';
		foreach ($results as $result) {
			$html .= '<a class="btn btn-default user_result" id="'.$result['mcf_userid'].'" role="button" style="margin-right: 6px; margin-bottom: 6px;">'.$result['mcf_username'].'</a>';
		}
		$html .= '</div>';
	} elseif ($type == 'toon') {
		$count = $db->count("ccg_toons",array("toon[~]"=>$query));

		$results = $db->select("ccg_toons",
			array("toon","toon_id"),
			array("toon[~]"=>$query,
				  "ORDER"=>"toon ASC")
		);

		$html .= '<div class="col-xs-12 well well-sm"><h6>'.$count.' toon'.(($count > 1) ? 's' : '').' found.</h6>';
		foreach ($results as $result) {
			$html .= '<a class="btn btn-default toon_result" id="'.$result['toon_id'].'" role="button" style="margin-right: 6px; margin-bottom: 6px;">'.$result['toon'].'</a>';
		}
		$html .= '</div>';
	}

	$html .= '</div>';

	echo $html;

?>