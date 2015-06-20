<?php
	require_once('includes/config.php');

	if (!isset($_POST['query']) || !isset($_POST['type'])) { die(); }

	$html = '';
	$type = $_POST['type'];
	$query = $_POST['query'];

	if ($type == 'user') {
		$results = $db->select("ccg_users",
			array("mcf_username",
				  "mcf_userid"
				  ),
			array("mcf_username[~]"=>$query,
				  "ORDER"=>"mcf_username ASC")
		);

		$html .= '<div class="col-xs-12 well well-sm">';
		foreach ($results as $result) {
			$html .= '<a class="btn btn-default user_result" id="'.$result['mcf_userid'].'" role="button" style="display: inline; margin-right: 6px;">'.$result['mcf_username'].'</a>';
		}
		$html .= '</div>';
	}

	$html .= '</div>';

	echo $html;

?>