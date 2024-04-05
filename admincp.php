<?php
	$page_title = 'AdminCP - The Cold Callers Guild';
	include_once('./tpl/header.php');
    if (!$ccg->is_admin($_SESSION['user'])) {
?>

<div class="row">
    <div class="col-xs-12"><h3>Ruh Roh!</h3></div>
    <div class="col-xs-12"><h4>You don't seem to belong here! Shoo!</h4></div>
</div>

<?php
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['function'] == 'user') {
                // Save Users
                $user = array();
                $user['mcf_username'] = $_POST['username'];
                $user['bassie'] = isset($_POST['bassie']) ? 1 : 0;
                $user['admin'] = isset($_POST['admin']) ? 1 : 0;

                $stmt = $db->update("ccg_users",
                    $user,
                    array("ccg_id"=>$_POST['ccg_id'])
                );

                if ($stmt == 1) { $success = 'User "'.$user['mcf_username'].'" Updated!'; }
            }
            elseif ($_POST['function'] == 'toon') {
                // Save Toons
                $toon = array();
                $toon['toon'] = $_POST['toon'];
                $toon['laff'] = $_POST['laff'];
                $toon['max_toonup'] = $_POST['gags_toonup'];
                $toon['max_trap'] = $_POST['gags_trap'];
                $toon['max_lure'] = $_POST['gags_lure'];
                $toon['max_sound'] = $_POST['gags_sound'];
                $toon['max_throw'] = $_POST['gags_throw'];
                $toon['max_squirt'] = $_POST['gags_squirt'];
                $toon['max_drop'] = $_POST['max_drop'];
                $toon['sellsuit'] = $_POST['suit_sell'];
                $toon['cashsuit'] = $_POST['suit_cash'];
                $toon['lawsuit'] = $_POST['suit_law'];
                $toon['bosssuit'] = $_POST['suit_boss'];

                $stmt = $db->update("ccg_toons",
                    $toon,
                    array("toon_id"=>$_POST['toon_id'])
                );

                if ($stmt == 1) { $success = 'Toon "'.$toon['toon'].'" Updated!'; }
            } elseif ($_POST['function'] == 'report') {
                // Save Run Reports
            } elseif ($_POST['function'] == 'schedule') {
                // Save Schedule
                $schedule = array();
                $days = $db->select("ccg_ttr_schedule","dayofweek");
                foreach ($days as $day) {
                    $schedule['battle_order'] = json_encode(explode("\r\n", $_POST['battle_order_'.$day]));
                    $schedule['start_times'] = json_encode(explode("\r\n", $_POST['start_times_'.$day]));
                    $schedule['run_thread'] = $_POST['run_thread_'.$day];
                    //echo $schedule['battle_order']."<br />".$schedule['start_times']."<br />".$schedule['run_thread']."<hr />";
                    $stmt = $db->update("ccg_ttr_schedule",
                        $schedule,
                        array("dayofweek"=>$day)
                    );
                }
                $success = 'Run Schedule Updated!';

            } elseif ($_POST['function'] == 'other') {
                // Save Other Things
                $other = array();
                $other['primary_district'] = $_POST['primary_district'];
                $other['backup_districts'] = json_encode(array($_POST['backup_district_1'], $_POST['backup_district_2']));
                $other['discord_invite'] = $_POST['discord_invite'];
                $other['event_thread'] = $_POST['event_thread'];
                $textline = explode("\r\n", $_POST['beanfest_days']); // array("Saturdays @ 08:15 AM")
                
                $days = array();
                foreach ($textline as $text) {
                    $textarray = explode(" @ ", $text); // array("Saturdays","08:15 AM")
                    $days[$textarray[0]] = $textarray[1]; // array("Saturdays"=>"08:15 AM")
                }

                $bfest = array(
                    'district'=>$_POST['beanfest_district'],
                    'days'=>$days
                    );

                $other['beanfest'] = json_encode($bfest);
                
                $stmt = $db->update("ccg_ttr_vars",
                    array("value"=>$other['primary_district']),
                    array("var"=>"primary_district")
                );
                $stmt = $db->update("ccg_ttr_vars",
                    array("value"=>$other['backup_districts']),
                    array("var"=>"backup_districts")
                );
                $stmt = $db->update("ccg_ttr_vars",
                    array("value"=>$other['beanfest']),
                    array("var"=>"beanfest")
                );
                $stmt = $db->update("ccg_ttr_vars",
                    array("value"=>$other['discord_invite']),
                    array("var"=>"discord_invite")
                );
                $stmt = $db->update("ccg_ttr_vars",
                    array("value"=>$other['event_thread']),
                    array("var"=>"event_thread")
                );

                $success = 'Other Settings Updated!';
            }
        }
?>

<!-- Content goes here -->
<div class="row">
    <div class="col-xs-12"><h3>AdminCP</h3></div>

    <div id="admin_nav" class="col-xs-12 col-sm-3 col-sm-push-9 col-md-3 col-md-push-9">
        <ul class="nav nav-pills">
            <li><a data-toggle="pill" href="#userMgr"><span class="glyphicon glyphicon-user"></span> Users</a></li>
            <li><a data-toggle="pill" href="#toonMgr"><span class="glyphicon glyphicon-sunglasses"></span> Toons</a></li>
            <!--li><a data-toggle="pill" href="#reportMgr"><span class="glyphicon glyphicon-list-alt"></span> Reports</a></li-->
            <li><a data-toggle="pill" href="#scheduleMgr"><span class="glyphicon glyphicon-calendar"></span> Schedule</a></li>
            <li><a data-toggle="pill" href="#otherMgr"><span class="glyphicon glyphicon-cog"></span> Other</a></li>
        </ul>
    </div>

    <div id="admin_panel" class="col-xs-12 col-sm-9 col-sm-pull-3 col-md-9 col-md-pull-3">
        <div class="tab-content">
            <div id="mainPane" class="tab-pane fade in active">
                <?php
                    if (isset($success)) {
                        echo'<h4>'.$success.'</h4>';
                    } else {
                        $user_count = $db->count("ccg_users");
                        $toon_count = $db->count("ccg_toons");
                        $prev_month = date('Y-m-01', strtotime(date('Y-m').' -1 month'));
                        $prev_month_lastday = date('Y-m-t', strtotime($prev_month));
                        $this_month = date('Y-m-01');
                        $this_month_lastday = date('Y-m-t', strtotime($this_month));
                        $prev_report_count = $db->count("ccg_ttr_results",array(
                            "run_datetime[<>]"=>array($prev_month.' 00:00:00',
                                                  $prev_month_lastday.' 23:59:59')));
                        $this_report_count = $db->count("ccg_ttr_results",array(
                            "run_datetime[<>]"=>array($this_month.' 00:00:00',
                                                  $this_month_lastday.' 23:59:59')));
                ?>
                        <h4>Welcome to the CCG AdminCP!</h4>
                        <div class="col-xs-6 col-md-3 centered">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><h4>Users Registered</h4></div>
                                <div class="panel-body">
                                    <h2><?= $user_count ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3 centered">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><h4>Toons Registered</h4></div>
                                <div class="panel-body">
                                    <h2><?= $toon_count ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3 centered">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><h4>Reports<br />(<?= date('M Y', strtotime(date('Y-m').' -1 month')) ?>)</h4></div>
                                <div class="panel-body">
                                    <h2><?= $prev_report_count ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3 centered">
                            <div class="panel panel-primary">
                                <div class="panel-heading"><h4>Reports<br />(<?= date('M Y') ?>)</h4></div>
                                <div class="panel-body">
                                    <h2><?= $this_report_count ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <p>You can use this control panel to manage various aspects of the site and your users.</p>
                            <ul>
                                <li>
                                    <span class="glyphicon glyphicon-user"></span> <strong>Users</strong><br />
                                    View User Account Information, Grant Admin Status, &amp; Rename Their Account.
                                </li>
                                <li>
                                    <span class="glyphicon glyphicon-sunglasses"></span> <strong>Toons</strong><br />
                                    View &amp; Edit Toon Information such as Name, Laff, Gags &amp; Cog Suits.
                                </li>
                                <li>
                                    <span class="glyphicon glyphicon-calendar"></span> <strong>Schedule</strong><br />
                                    Update the daily Run Schedules as well as the respective Run Thread numbers.
                                </li>
                                <li>
                                    <span class="glyphicon glyphicon-cog"></span> <strong>Other</strong><br />
                                    Update other settings such as Run Districts &amp; Beanfest Information.
                                </li>
                                <li>
                                    <span class="glyphicon glyphicon-list-alt"></span> <strong>Reports</strong><br />
                                    Edit Run Reports from the <a href="victories.php">Victories</a> page.
                                </li>
                            </ul>
                        </div>

                        <?php
                    }
                ?>
            </div>
            <div id="userMgr" class="tab-pane fade">
                <h4>Manage Users</h4>
                <div class="col-xs-12 col-sm-8 col-md-6">
                    <div class="input-group">
                        <input type="text" name="search_user" id="search_user" class="form-control" placeholder="User Name">
                        <span class="input-group-btn">
                            <button name="search_user_btn" id="search_user_btn" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </span>
                    </div>
                </div>
                
                <div id="user_results" style="margin-top: 12px;"></div>
                <div id="user_details" style="clear: both;">
                    <h6 class="bg-danger">Warning: <strong><em>Only</em></strong> change the Username if the user had their account on MMOCentralForums.com renamed! Doing so otherwise will prevent them from accessing their profile.</h6>
                    <form role="form" method="post" action="" autocomplete="off" id="user_form" class="form-horizontal">
                        <input type="hidden" name="function" value="user">
                        <input type="hidden" id="ccg_id" name="ccg_id">
                        <div class="form-group col-sm-6">
                            <input type="hidden" id="orig_username">
                            <label for="username" class="col-xs-12 control-label">Username:</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="forum_title" class="col-xs-12 control-label">Forum Title:</label>
                            <div class="col-xs-12">
                                <p id="forum_title" class="form-control-static">Forum Title</p>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="reg_date" class="col-xs-12 control-label">Registration Date:</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="reg_date" name="reg_date" readonly>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="reg_ip" class="col-xs-12 control-label">Registration IP:</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="reg_ip" name="reg_ip" readonly>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="reg_date" class="col-xs-12 control-label">Last Login:</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="last_login" name="last_login" readonly>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="reg_ip" class="col-xs-12 control-label">Last Login IP:</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="last_ip" name="last_ip" readonly>
                            </div>
                        </div>
                        <div class="form-group col-xs-6 col-sm-6" title="Ambassador status is dependent on the user's group membership on MMOCentralForums. You may uncheck and Save if the user is no longer an ambassador and needs removed manually.">
                            <label for="bassie" class="col-xs-12 control-label"><input type="checkbox" id="bassie" name="bassie" value="1"> Ambassador?</label>
                        </div>
                        <div class="form-group col-xs-6 col-sm-6">
                            <label for="admin" class="col-xs-12 control-label"><input type="checkbox" id="admin" name="admin" value="1"> Admin?</label>
                        </div>
                        <div class="form-group col-xs-6">
                            <div class="col-sm-12">
                                <button type="submit" id="save_user" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="toonMgr" class="tab-pane fade">
                <h4>Manage Toons</h4>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="input-group">
                        <input type="text" name="search_toon" id="search_toon" class="form-control" placeholder="Toon Name">
                        <span class="input-group-btn">
                            <button name="search_toon_btn" id="search_toon_btn" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="input-group">
                        <input type="text" name="search_userstoon" id="search_userstoon" class="form-control" placeholder="User Name">
                        <span class="input-group-btn">
                            <button name="search_userstoon_btn" id="search_userstoon_btn" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </span>
                    </div>
                </div>
                
                <div id="toon_results" style="margin-top: 12px;"></div>
                <div id="toon_details" style="clear: both;">
                    <form role="form" method="post" action="" autocomplete="off" id="toon_form" class="form-horizontal">
                        <input type="hidden" name="function" value="toon">
                        <input type="hidden" id="toon_id" name="toon_id">
                        <div class="form-group col-sm-6">
                            <label for="toon" class="col-xs-12 control-label">Toon Name:</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="toon" name="toon">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="toon_username" class="col-xs-12 control-label">Username:</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="toon_username" name="toon_username" readonly>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="laff" class="col-xs-12 control-label">Laff:</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="laff" name="laff">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="laff" class="col-xs-12 control-label">&nbsp;</label>
                            <div class="col-xs-12">
                                <p class="form-control-static">&nbsp;</p>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="gags_toonup" class="col-xs-12 control-label">Toon-Up:</label>
                            <div class="col-xs-12">
                                <select name="gags_toonup" id="gags_toonup" class="form-control">
                                <?php
                                    for ($i=0;$i<=7;$i++) {
                                        echo '<option value="'.$i.'">'.$tt->gags['toonup'][$i].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gags_trap" class="col-xs-12 control-label">Trap:</label>
                            <div class="col-xs-12">
                                <select name="gags_trap" id="gags_trap" class="form-control">
                                <?php
                                    for ($i=0;$i<=7;$i++) {
                                        echo '<option value="'.$i.'">'.$tt->gags['trap'][$i].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gags_lure" class="col-xs-12 control-label">Lure:</label>
                            <div class="col-xs-12">
                                <select name="gags_lure" id="gags_lure" class="form-control">
                                <?php
                                    for ($i=0;$i<=7;$i++) {
                                        echo '<option value="'.$i.'">'.$tt->gags['lure'][$i].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gags_sound" class="col-xs-12 control-label">Sound:</label>
                            <div class="col-xs-12">
                                <select name="gags_sound" id="gags_sound" class="form-control">
                                <?php
                                    for ($i=0;$i<=7;$i++) {
                                        echo '<option value="'.$i.'">'.$tt->gags['sound'][$i].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gags_throw" class="col-xs-12 control-label">Throw:</label>
                            <div class="col-xs-12">
                                <select name="gags_throw" id="gags_throw" class="form-control">
                                <?php
                                    for ($i=0;$i<=7;$i++) {
                                        echo '<option value="'.$i.'">'.$tt->gags['throw'][$i].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gags_squirt" class="col-xs-12 control-label">Squirt:</label>
                            <div class="col-xs-12">
                                <select name="gags_squirt" id="gags_squirt" class="form-control">
                                <?php
                                    for ($i=0;$i<=7;$i++) {
                                        echo '<option value="'.$i.'">'.$tt->gags['squirt'][$i].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="gags_drop" class="col-xs-12 control-label">Drop:</label>
                            <div class="col-xs-12">
                                <select name="gags_drop" id="gags_drop" class="form-control">
                                <?php
                                    for ($i=0;$i<=7;$i++) {
                                        echo '<option value="'.$i.'">'.$tt->gags['drop'][$i].'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="laff" class="col-xs-12 control-label">&nbsp;</label>
                            <div class="col-xs-12">
                                <p class="form-control-static">&nbsp;</p>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="suit_sell" class="col-xs-12 control-label">Sellbot Suit::</label>
                            <div class="col-xs-12">
                                <select name="suit_sell" id="suit_sell" class="form-control">
                                <?php
                                    foreach ($tt->cogsuits['sellbot'] as $suit) {
                                        echo '<option value="'.$suit.'">'.$suit.'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="suit_cash" class="col-xs-12 control-label">Cashbot Suit::</label>
                            <div class="col-xs-12">
                                <select name="suit_cash" id="suit_cash" class="form-control">
                                <?php
                                    foreach ($tt->cogsuits['cashbot'] as $suit) {
                                        echo '<option value="'.$suit.'">'.$suit.'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="suit_law" class="col-xs-12 control-label">Lawbot Suit::</label>
                            <div class="col-xs-12">
                                <select name="suit_law" id="suit_law" class="form-control">
                                <?php
                                    foreach ($tt->cogsuits['lawbot'] as $suit) {
                                        echo '<option value="'.$suit.'">'.$suit.'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="suit_boss" class="col-xs-12 control-label">Bossbot Suit::</label>
                            <div class="col-xs-12">
                                <select name="suit_boss" id="suit_boss" class="form-control">
                                <?php
                                    foreach ($tt->cogsuits['bossbot'] as $suit) {
                                        echo '<option value="'.$suit.'">'.$suit.'</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <div class="col-sm-12">
                                <button type="submit" id="save_toon" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Save</button>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <div class="col-xs-4 col-xs-offset-8 col-md-3 col-md-offset-9 col-lg-2 col-lg-ffset-10">
                                <button type="button" id="trash_toon" class="btn btn-danger btn-block" style="padding-left: 0; padding-right: 0;"><span class="glyphicon glyphicon-trash" title="Delete Toon"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="reportMgr" class="tab-pane fade">
                <h4>Manage Reports</h4>
            </div>
            <div id="scheduleMgr" class="tab-pane fade">
                <h4>Manage Run Schedule</h4>
                <p>When setting up the schedule, "Start Times" refers to the times (in Pacific timezone) when the corresponding battle in the list will start. Each battle should have a matching start time on their same rows.</p>
                <!-- ul>
                < ?php
                    /*$i = 1;
                    $runArray = array();
                    foreach ($tt->prior_run_length as $run => $length) {
                        $runArray[$i]['run'] = $run;
                        $runArray[$i]['length'] = $length;
                        $i++;
                    }
                    for ($j=1;$j<=count($runArray);$j++) {
                        if ($j == 1) {
                            echo '<li>'.$runArray[$j]['run'].': '.$runArray[$j]['length'].' after '.$runArray[count($runArray)]['run'];
                        } else {
                            echo '<li>'.$runArray[$j]['run'].': '.$runArray[$j]['length'].' after '.$runArray[$j-1]['run'];
                        }
                    }*/
                ?>
                </!-->

                <form role="form" method="post" action="" autocomplete="off" id="schedule_form" class="form-horizontal">
                    <input type="hidden" name="function" value="schedule">

                <?php
                    $schedule = $db->select("ccg_ttr_schedule","*");
                    foreach ($schedule as $day) {
                ?>
                    <h5 style="clear: both;"><?= $day['dayofweek'] ?></h5>
                    <div class="form-group col-sm-6">
                        <label for="battle_order_<?= $day['dayofweek'] ?>" class="col-xs-12 control-label">Battle Order:<br /><small>(Start Times based on first battle listed)</small></label>
                        <div class="col-xs-12">
                            <?php
                                $i = 0;
                                $battle_order = "";
                                $battles = json_decode($day['battle_order'], true);
                                foreach ($battles as $battle) {
                                    if ($i > 0) { $battle_order .= "\n"; }
                                    $battle_order .= $battle;
                                    $i++;
                                }
                            ?>
                            <textarea id="battle_order_<?= $day['dayofweek'] ?>" name="battle_order_<?= $day['dayofweek'] ?>" class="form-control" rows="4"><?= $battle_order ?></textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="start_times_<?= $day['dayofweek'] ?>" class="col-xs-12 control-label">Start Times (Pacific Timezone):<br /><small>(Example: 5:00 AM)</small></label>
                        <div class="col-xs-12">
                            <?php
                                $i = 0;
                                $start_times = "";
                                $times = json_decode($day['start_times'], true);
                                foreach ($times as $time) {
                                    if ($i > 0) { $start_times .= "\n"; }
                                    $start_times .= $time;
                                    $i++;
                                }
                            ?>
                            <textarea id="start_times_<?= $day['dayofweek'] ?>" name="start_times_<?= $day['dayofweek'] ?>" class="form-control" rows="4"><?= $start_times ?></textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="run_thread_<?= $day['dayofweek'] ?>" class="col-xs-12 control-label">MCF Run Thread:</label>
                        <div class="col-xs-12">
                            <input type="text" class="form-control" id="run_thread_<? $day['dayofweek'] ?>" name="run_thread_<?= $day['dayofweek'] ?>" value="<?= $day['run_thread'] ?>">
                        </div>
                    </div>
                <?php
                    }
                ?>
                    <div class="form-group col-xs-12">
                        <div class="col-sm-6">
                            <button type="submit" id="save_schedule" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="otherMgr" class="tab-pane fade">
                <h4>Other Settings</h4>
                <form role="form" method="post" action="" autocomplete="off" id="other_form" class="form-horizontal">
                    <input type="hidden" name="function" value="other">
                    <?php
                        $primary_district = $ccg->get_ttr_var('primary_district');
                        $backup_districts = json_decode($ccg->get_ttr_var('backup_districts'), true);
                        $beanfest = json_decode($ccg->get_ttr_var('beanfest'), true);
                        $discord_invite = $ccg->get_ttr_var('discord_invite');
                        $event_thread = $ccg->get_ttr_var('event_thread');
                    ?>
                    <h5>TTR : Run Districts:</h5>
                    <div class="form-group col-xs-12">
                        <label for="primary_district" class="col-xs-12 control-label">Primary District:</label>
                        <div class="col-sm-6">
                            <select id="primary_district" name="primary_district" class="form-control">
                            <?php
                                foreach ($tt->districts as $district) {
                                    echo '<option value="'.$district.'"';
                                    if ($district == $primary_district) { echo ' selected'; }
                                    echo '>'.$district.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="backup_district_1" class="col-xs-12 control-label">Backup Districts:</label>
                        <div class="col-sm-6">
                            <select id="backup_district_1" name="backup_district_1" class="form-control">
                            <?php
                                foreach ($tt->districts as $district) {
                                    echo '<option value="'.$district.'"';
                                    if ($district == $backup_districts[0]) { echo ' selected'; }
                                    echo '>'.$district.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <select id="backup_district_2" name="backup_district_2" class="form-control">
                            <?php
                                foreach ($tt->districts as $district) {
                                    echo '<option value="'.$district.'"';
                                    if ($district == $backup_districts[1]) { echo ' selected'; }
                                    echo '>'.$district.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>

                    <h5 style="clear: both;">TTR : Beanfest</h5>
                    <div class="form-group col-xs-12">
                        <label for="beanfest_district" class="col-xs-12 control-label">District:</label>
                        <div class="col-sm-6">
                            <select id="beanfest_district" name="beanfest_district" class="form-control">
                            <?php
                                foreach ($tt->districts as $district) {
                                    echo '<option value="'.$district.'"';
                                    if ($district == $beanfest['district']) { echo ' selected'; }
                                    echo '>'.$district.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="beanfest_days" class="col-xs-12 control-label">Days &amp; Times (Pacific Timezone):<br /><small>(Example: Saturdays @ 08:15 AM)</small></label>
                        <div class="col-sm-9">
                            <?php
                                $i = 0;
                                $text = "";
                                foreach ($beanfest['days'] as $day => $time) {
                                    if ($i > 0) { $text .= "\n"; }
                                    $text .= $day." @ ".$time;
                                    $i++;
                                }
                            ?>
                            <textarea id="beanfest_days" name="beanfest_days" class="form-control" rows="3"><?= $text ?></textarea>
                        </div>
                    </div>

                    <h5 style="clear: both;">Misc</h5>
                    <div class="form-group col-xs-12">
                        <label for="discord_invite" class="col-xs-12 control-label">Discord Invite URL:</label>
                        <div class="col-sm-6">
                            <input id="discord_invite" name="discord_invite" class="form-control" type="text" value="<?php echo $discord_invite; ?>" />
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="event_thread" class="col-xs-12 control-label">Event Thread ID:</label>
                        <div class="col-sm-6">
                            <input id="event_thread" name="event_thread" class="form-control" type="text" value="<?php echo $event_thread; ?>" />
                        </div>
                        <div class="col-sm-6">
                            <a href="https://www.mmocentralforums.com/forums/showpost.php?p=<?= $event_thread ?>" target="_blank"><span class="glyphicon glyphicon-link"></span> Go to thread</a>
                        </div>
                    </div>

                    <div class="form-group col-xs-6">
                        <div class="col-sm-12">
                            <button type="submit" id="save_other" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php
    }
?>

<!-- footer -->
	</div>
    </div>

<?php include_once('./tpl/footer.php'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/admincp.js"></script>

  </body>
</html>