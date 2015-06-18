<?php
	$page_title = 'Member List - The Cold Callers Guild';
	include_once('./tpl/header.php');

	if (!$_SESSION['registered']) {
?>

<div class="row">
	<div class="col-xs-12"><h3>Ruh Roh!</h3></div>
	<div class="col-xs-12"><h4>Please be sure you are logged into <a href="http://mmocentralforums.com">MMOCentralForums</a> and have registered your account here.</h4></div>
</div>

<?php
	} else {
?>

<!-- Content goes here -->
<div class="row">
	<div class="col-xs-12"><h3>Member List</h3></div>

	<div class="col-xs-12" style="overflow-x: auto;">
		<table class="table table-striped table-hover" id="memberlist">
			<thead>
				<tr>
					<th>Toon Name</th>
					<th>Member</th>
					<th>Role</th>
					<th class="centered">Laff</th>
					<th title="Toon-Up" class="centered">TU</th>
					<th title="Trap" class="centered">TR</th>
					<th title="Lure" class="centered">LR</th>
					<th title="Sound" class="centered">SD</th>
					<th title="Throw" class="centered">TH</th>
					<th title="Squirt" class="centered">SQ</th>
					<th title="Drop" class="centered">DR</th>
					<th title="Sellbot Suit" class="centered">SB</th>
					<th title="Cashbot Suit" class="centered">CB</th>
					<th title="Lawbot Suit" class="centered">LB</th>
					<th title="Bossbot Suit" class="centered">BB</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$memberlist = $db->select(
					"ccg_toons",
					array("[><]ccg_users"=>array("ccg_id"=>"ccg_id")),
					array("ccg_toons.toon",
						  "ccg_toons.laff",
						  "ccg_toons.max_toonup",
						  "ccg_toons.max_trap",
						  "ccg_toons.max_lure",
						  "ccg_toons.max_sound",
						  "ccg_toons.max_throw",
						  "ccg_toons.max_squirt",
						  "ccg_toons.max_drop",
						  "ccg_toons.sellsuit",
						  "ccg_toons.cashsuit",
						  "ccg_toons.lawsuit",
						  "ccg_toons.bosssuit",
						  "ccg_toons.toon_id",
						  "ccg_users.mcf_username",
						  "ccg_users.admin",
						  "ccg_users.bassie"
					),
					array("ORDER"=>"ccg_toons.toon ASC")
				);

				$filter_in = array(" ", ".");
				$filter_out = array("_", "");

				if (!empty($memberlist)) {
					foreach ($memberlist as $member) {
						echo '<tr>';
						echo '<td>'.$member['toon'].'</td>';
						echo '<td>'.$member['mcf_username'].'</td>';
						echo '<td>';
							if ($member['admin'] == '1') { echo 'Admin'; }
							if ($member['bassie'] == '1') { echo 'Ambassador / Bassie'; }
						echo '</td>';
						echo '<td class="centered">'.$member['laff'].'</td>';
						echo ($member['max_toonup'] != 0) ? '<td class="centered"><img src="gags/gag_toonup'.$member['max_toonup'].'_small.png" title="'.$tt->gags['toonup'][$member['max_toonup']].'" /></td>' : '<td></td>';
						echo ($member['max_trap'] != 0) ? '<td class="centered"><img src="gags/gag_trap'.$member['max_trap'].'_small.png" title="'.$tt->gags['trap'][$member['max_trap']].'" /></td>' : '<td></td>';
						echo ($member['max_lure'] != 0) ? '<td class="centered"><img src="gags/gag_lure'.$member['max_lure'].'_small.png" title="'.$tt->gags['lure'][$member['max_lure']].'" /></td>' : '<td></td>';
						echo ($member['max_sound'] != 0) ? '<td class="centered"><img src="gags/gag_sound'.$member['max_sound'].'_small.png" title="'.$tt->gags['sound'][$member['max_sound']].'" /></td>' : '<td></td>';
						echo ($member['max_throw'] != 0) ? '<td class="centered"><img src="gags/gag_throw'.$member['max_throw'].'_small.png" title="'.$tt->gags['throw'][$member['max_throw']].'" /></td>' : '<td></td>';
						echo ($member['max_squirt'] != 0) ? '<td class="centered"><img src="gags/gag_squirt'.$member['max_squirt'].'_small.png" title="'.$tt->gags['squirt'][$member['max_squirt']].'" /></td>' : '<td></td>';
						echo ($member['max_drop'] != 0) ? '<td><img src="gags/gag_drop'.$member['max_drop'].'_small.png" title="'.$tt->gags['drop'][$member['max_drop']].'" /></td>' : '<td></td>';
						echo ($member['sellsuit'] != '') ? '<td class="centered"><img src="cogs/cogs_'.strtolower(str_replace($filter_in, $filter_out, $member['sellsuit'])).'_small.png" title="'.$member['sellsuit'].'" class="img-circle" /></td>' : '<td></td>';
						echo ($member['cashsuit'] != '') ? '<td class="centered"><img src="cogs/cogs_'.strtolower(str_replace($filter_in, $filter_out, $member['cashsuit'])).'_small.png" title="'.$member['cashsuit'].'" class="img-circle" /></td>' : '<td></td>';
						echo ($member['lawsuit'] != '') ? '<td class="centered"><img src="cogs/cogs_'.strtolower(str_replace($filter_in, $filter_out, $member['lawsuit'])).'_small.png" title="'.$member['lawsuit'].'" class="img-circle" /></td>' : '<td></td>';
						echo ($member['bosssuit'] != '') ? '<td class="centered"><img src="cogs/cogs_'.strtolower(str_replace($filter_in, $filter_out, $member['bosssuit'])).'_small.png" title="'.$member['bosssuit'].'" class="img-circle" /></td>' : '<td></td>';

					}
				}
			?>
			</tbody>
		</table>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-12"><h3>Ambassadors</h3></div>

		<div class="col-xs-12 col-sm-6">
			<?php
				$bassielist = $db->select(
					"ccg_users",
					array("mcf_username", "mcf_userid"),
					array("bassie"=>1, "ORDER"=>"mcf_username ASC")
				);

				if (!empty($bassielist)) {
					foreach ($bassielist as $bassie) {
						echo '<div class="col-xs-8"><h5>'.$bassie['mcf_username'].'</h5></div>';
						echo '<div class="col-xs-4 centered"><a href="http://www.mmocentralforums.com/forums/private.php?do=newpm&u='.$bassie['mcf_userid'].'" target="_blank"><button type="button" class="btn btn-default" title="Send a Private Message to '.$bassie['mcf_username'].'"><span class="glyphicon glyphicon-envelope"></span></button></a></div>';
					}
				}

			?>
		</div>
		<div class="col-xs-12 col-sm-6 bassie_descr">
			<p class="well">The ambassadors are the members whom you should go to with any CCG related questions or problems. These include (but are not limited to) problems or concerns on a run, questions about strategy, clarification of guidelines, or anything related to CCG activities.</p>
		</div>
	</div>
</div>

<?php } ?>

<!-- footer -->
	</div>
    </div>

    <footer class="container centered">
        
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    
    <script type="text/javascript">
    	$(document).ready(function(){
    		var dTable = $('#memberlist').dataTable( {
    			"pagingType": "full_numbers",
                "columns": [
                    null, null,
                    { "visible": false, "searchable": true, "orderable": false },
                    null,
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false },
                    { "orderable": false }
                ]
    		});

    	});
    </script>
  </body>
</html>