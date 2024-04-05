<?php
	$page_title = 'TTR Run &amp; Event Schedule - The Cold Callers Guild';
	include_once('./tpl/header.php');
?>

<!-- Content goes here -->
<div class="row">
	<div class="col-xs-12"><h3>TTR Run Schedule</h3></div>
	<div class="col-xs-12">
		<h4>District for all runs: <strong><?= $ccg->get_ttr_var('primary_district') ?></strong></h4>
		<h5><a title="When to use the Backup District" href="http://www.mmocentralforums.com/forums/showthread.php?t=376511">Backup District</a>: <strong>
			<?php
				$backups = json_decode($ccg->get_ttr_var('backup_districts'), true);
				echo $backups[0];
			 ?>
			</strong></h5>
		<h5>Second Backup District: <strong><?= $backups[1] ?></strong></h5>

		<h4 class="centered">
			<select id="schedule_day" name="schedule_day">
				<option value="Monday">Monday</option>
				<option value="Tuesday">Tuesday</option>
				<option value="Wednesday">Wednesday</option>
				<option value="Thursday">Thursday</option>
				<option value="Friday">Friday</option>
				<option value="Saturday">Saturday</option>
				<option value="Sunday">Sunday</option>
			</select>
		</h4>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Battle</th>
						<th>Pacific</th>
						<th>Mountain</th>
						<th>Central</th>
						<th>Eastern</th>
						<th>GMT</th>
						<?php if ($ccg->is_BST()) { ?>
						<th>BST</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody id="schedule_info">
					<!-- Populated from AJAX call -->
				</tbody>
			</table>
		</div>
	</div>

<?php
	$beanfest = json_decode($ccg->get_ttr_var('beanfest'), true);
?>

	<div class="col-xs-12"><h3>Beanfests</h3></div>
	<div class="col-xs-12">
		<h4>District: <strong><?= $beanfest['district'] ?></strong></h4>
		<h5>Where: Goofy Speedway</h5>
	</div>
	<div class="col-xs-12 col-md-4 col-lg-6">
		<p>Are you low on beans? Don't have enough Jellybeans for that Accessory? Do you just want to help out the CCG community? Bring any toon, big or small, to the CCG's beanfest!</p>
		<p>Meet up at Goofy Speedway in the area between the Auto Shop and the tunnel leading back to Toontown Central!</p>
	</div>
	<div class="col-xs-12 col-md-8 col-lg-6 centered">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th></th>
						<th>Pacific</th>
						<th>Mountain</th>
						<th>Central</th>
						<th>Eastern</th>
						<th>GMT</th>
						<?php if ($ccg->is_BST()) { ?>
						<th>BST</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($beanfest['days'] as $day => $time) {
							echo '<tr>';
							echo '<td>'.$day.'</td>';
							$fest_time = strtotime($time);
							// Pacific Time
							echo '<td>'.date("h:i A", $fest_time).'</td>';
							// Mountain Time
							echo '<td>'.date("h:i A", strtotime("+1 hour", $fest_time)).'</td>';
							// Central Time
							echo '<td>'.date("h:i A", strtotime("+2 hours", $fest_time)).'</td>';
							// Eastern Time
							echo '<td>'.date("h:i A", strtotime("+3 hours", $fest_time)).'</td>';
							// Greenwich Mean Time
							echo '<td>'.date("h:i A", strtotime($ccg->GMT_hours(), $fest_time)).'</td>';
							if ($ccg->is_BST()) {
								// British Summer Time Time
								echo '<td>'.date("h:i A", strtotime("+8 hours", $fest_time)).'</td>';
							}
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
		<img src="images/purple.gif" /> <img src="images/fuchsia.gif" /> <img src="images/orange.gif" /> <img src="images/red.gif" /> <img src="images/green.gif" /> <img src="images/blue.gif" /> <img src="images/pink.gif" /> <img src="images/blue_green.gif" /> <img src="images/yellow.gif" />
	</div>

<?php
	$event_thread = $ccg->get_ttr_var('event_thread');
?>

	<div class="col-xs-12"><h3>Upcoming Events</h3></div>
	<div class="col-xs-12">
		<?php
			$event_thread = $ccg->get_ttr_var('event_thread');
			$curl = curl_init();
			//set it to point at the event list
			curl_setopt($curl, CURLOPT_URL, "https://www.mmocentralforums.com/forums/showpost.php?p={$event_thread}");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($curl);
			curl_close($curl);
			preg_match("|<font size=\"5\"><b>Event List</b></font><br />(.*)<font size=\"5\"><b>End Event List</b></font>|s", $output, $match);
			$event_list = $match[0];
			$search = "<font size=\"5\"><b>Event List</b></font><br />";
			$event_list = str_replace($search, "", $event_list);
			$search = "<font size=\"5\"><b>End Event List</b></font>";
			$event_list = str_replace($search, "", $event_list);
			$event_list = trim($event_list);
			if (str_replace('<br />', '', $event_list) != "") {
				echo $event_list;
			} else {
				echo "<p>No events found. Please check back later!</p>";
			}
		?>
	</div>
</div>

<!-- footer -->
	</div>
    </div>

<?php include_once('./tpl/footer.php'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="js/schedule.js"></script>

  </body>
</html>