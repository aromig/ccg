<?php
	require_once('includes/config.php');

	$html = '';
	$battle = $_POST['battle'];

	if ($battle == "VP") { foreach ($tt->vp_sos_card as $sos) { $html .= '<option value="'.$sos.'">'.$sos.'</option>'; } }
	if ($battle == "CFO") { foreach ($tt->cfo_unite_phrase as $phrase) { $html .= '<option value="'.$phrase.'">'.$phrase.'</option>'; } }
	if ($battle == "CJ") { foreach ($tt->cj_summons as $summons) { $html .= '<option value="'.$summons.'">'.$summons.'</option>'; } }
	if ($battle == "CEO") { foreach ($tt->ceo_pink_slip as $slip) { $html .= '<option value="'.$slip.'">'.$slip.'</option>'; } }

	echo $html;
?>