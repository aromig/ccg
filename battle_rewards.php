<?php
	require_once('includes/config.php');

	$html = '';
	$battle = $_POST['battle'];

	if ($battle == "VP") { foreach ($tt->svp_sos_card as $sos) { $html .= '<option value="'.$sos.'">'.$sos.'</option>'; } }
	if ($battle == "CFO") { foreach ($tt->cfo_unite_phrase as $sos) { $html .= '<option value="'.$cfo_unite_phrase.'">'.$cfo_unite_phrase.'</option>'; } }
	if ($battle == "CJ") { foreach ($tt->cj_summons as $sos) { $html .= '<option value="'.$cj_summons.'">'.$cj_summons.'</option>'; } }
	if ($battle == "CEO") { foreach ($tt->ceo_pink_slip as $sos) { $html .= '<option value="'.$ceo_pink_slip.'">'.$ceo_pink_slip.'</option>'; } }

	echo $html;
?>