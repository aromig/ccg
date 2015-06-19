<?php
	$page_title = 'TTR Run &amp; Event Schedule - The Cold Callers Guild';
	include_once('./tpl/header.php');
?>

<!-- Content goes here -->
<div class="row">
	<div class="col-xs-12"><h3>TTR Run Schedule</h3></div>
	<div class="col-xs-12">
		<h4>District for all runs: <strong><?= $ccg->get_ttr_var('primary_district') ?></strong></h4>
		<h5><a title="When to use the Backup District" href="http://www.mmocentralforums.com/forums/showthread.php?t=364633">Backup District</a>: <strong>
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
						<th>BST</th>
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
		<h5>Where: Goofy's Speedway</h5>
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
						<th>BST</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
							foreach ($beanfest['days'] as $day => $times) {
								echo '<td>'.$day.'</td>';
								foreach ($times as $time) {
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
									echo '<td>'.date("h:i A", strtotime("+7 hours", $fest_time)).'</td>';
									// British Summer Time Time
									echo '<td>'.date("h:i A", strtotime("+8 hours", $fest_time)).'</td>';
								}
							}
						?>
					</tr>
				</tbody>
			</table>
		</div>
		<img src="images/purple.gif" /> <img src="images/fuchsia.gif" /> <img src="images/orange.gif" /> <img src="images/red.gif" /> <img src="images/green.gif" /> <img src="images/blue.gif" /> <img src="images/pink.gif" /> <img src="images/blue_green.gif" /> <img src="images/yellow.gif" />
	</div>
</div>

<!-- footer -->
	</div>
    </div>

    <footer class="container centered">
        
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="js/schedule.js"></script>

  </body>
</html>