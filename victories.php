<?php
	$page_title = 'Victories - The Cold Callers Guild';
	include_once('./tpl/header.php');
    if (!$_SESSION['registered']) {
?>

<div class="row">
    <div class="col-xs-12"><h3>Ruh Roh!</h3></div>
    <div class="col-xs-12"><h4>Please be sure you are logged into <a href="http://mmocentralforums.com">MMOCentralForums</a> and have registered your account here.</h4></div>
</div>

<?php
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $report_id = $_POST['edit_report_id'];
            $battle = $_POST['edit_battle'];
            $run_datetime = $_POST['edit_date'].' '.$_POST['edit_time'];
                $run_datetime = strtotime($run_datetime);
                $run_datetime = date("Y-m-d H:i:s", $run_datetime);
            $loaded = intval($_POST['edit_loaded']);
            $danced = 0;
            $notes = $_POST['edit_notes'];
            $reward = $_POST['edit_reward'];

            $toons = array();
            for ($i=1;$i<=$loaded;$i++) {
                $toons[$i]["name"] = (!empty($_POST['edit_toon_'.$i])) ? $_POST['edit_toon_'.$i] : 'Unknown';
                $toons[$i]["laff"] = (!empty($_POST['edit_laff_'.$i])) ? $_POST['edit_laff_'.$i] : null;
                $toons[$i]["suit"] = (!empty($_POST['edit_suit_'.$i])) ? $_POST['edit_suit_'.$i] : null;
                $toons[$i]["suitlevel"] = (!empty($_POST['edit_suitlevel_'.$i])) ? $_POST['edit_suitlevel_'.$i] : null;
                $toons[$i]["status"] = $_POST['edit_status_'.$i];
                $toons[$i]["coground"] = ($_POST['edit_coground_'.$i] == "1") ? 1 : 0;
                $toons[$i]["skeleround"] = ($_POST['edit_skeleround_'.$i] == "1") ? 1 : 0;
                $toons[$i]["cleanupround"] = ($_POST['edit_cleanupround_'.$i] == "1") ? 1 : 0;
                $toon_json[$i] = json_encode($toons[$i]);
                if ($toons[$i]["status"] == "Danced") { $danced++; }
            }

                $columns = array(
                    "battle"=>$battle,
                    "run_datetime"=>$run_datetime,
                    "toons_loaded"=>$loaded,
                    "toons_danced"=>$danced,
                    "notes"=>$notes,
                    "reward"=>$reward,
                    "updated_dt"=>date("Y-m-d H:i:s")
                );
                for ($i=1;$i<=8;$i++) {
                    if (!empty($toon_json[$i])) {
                        $columns["toon_".$i] = $toon_json[$i];
                    }
                }

                $stmt = $db->update("ccg_ttr_results",
                    $columns,
                    array("result_id"=>$report_id)
                );

                if ($stmt) { $message = '<h5>Run Report Updated!</h5>'; }
        }

?>

<!-- Content goes here -->
<div class="row">
    <div class="col-xs-12"><h3>Victories</h3></div>
    <div class="col-xs-12">
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#by_date">By Date</a></li>
            <li><a data-toggle="pill" href="#by_month">By Month</a></li>
        </ul>
        <hr />
        <div class="tab-content">
            <div id="by_date" class="tab-pane fade in active form-inline">
                <div class="form-group form-group-sm">
                    <label for="run_date" class="control-label" title="Run Date">Date</label>
                    <input type="text" name="run_date" id="run_date" tabindex="1" class="run_date form-control datepicker" style="cursor: pointer;" value="<?= date('m/d/Y') ?>" readonly>
                </div>
                <div class="form-group form-group-sm">
                    <label for="run_time" class="control-label" title="Run Time">Time</label>
                    <select name="run_time" id="run_time" tabindex="2" class="form-control">

                    </select>
                    <select name="timezone_by_date" id="timezone_by_date" class="run_date form-control" tabindex="3">
                        <option value="PT">Pacific</option>
                        <option value="MT">Mountain</option>
                        <option value="CT">Central</option>
                        <option value="ET">Eastern</option>
                        <option value="GMT">GMT</option>
                        <option value="BST">BST</option>
                    </select>
                </div>
                <div class="form-group form-group-sm">
                    <label for="battle_by_date" class="control-label" title="Battle">Battle</label>
                    <select name="battle_by_date" id="battle_by_date" tabindex="4" class="run_date form-control">
                        <option value=""></option>
                        <option value="vp">VP</option>
                        <option value="cfo">CFO</option>
                        <option value="cj">CJ</option>
                        <option value="ceo">CEO</option>
                    </select>
                </div>
                <div class="form-group form-group-sm">
                    <button type="button" name="refresh_date" id="refresh_date" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
                </div>
            </div>

            <div id="by_month" class="tab-pane fade form-inline">
                <div class="form-group form-group-sm">
                    <label for="run_month" class="control-label" title="Run Month">Month</label>
                    <input type="text" name="run_month" id="run_month" tabindex="1" class="form-control datepicker" readonly>
                </div>
                <div class="form-group form-group-sm">
                    <label for="timezone_by_month" class="control-label" title="Timezone">Time Zone</label>
                    <select name="timezone_by_month" id="timezone_by_month" class="form-control" tabindex="2">
                        <option value="PT">Pacific</option>
                        <option value="MT">Mountain</option>
                        <option value="CT">Central</option>
                        <option value="ET">Eastern</option>
                        <option value="GMT">GMT</option>
                        <option value="BST">BST</option>
                    </select>
                </div>
                <div class="form-group form-group-sm">
                    <label for="battle_by_month" class="control-label" title="Battle">Battle</label>
                    <select name="battle_by_month" id="battle_by_month" tabindex="3" class="run_date form-control">
                        <option value=""></option>
                        <option value="vp">VP</option>
                        <option value="cfo">CFO</option>
                        <option value="cj">CJ</option>
                        <option value="ceo">CEO</option>
                    </select>
                </div>
                <div class="form-group form-group-sm">
                    <button type="button" name="refresh_month" id="refresh_month" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12" id="show_reports" style="margin-top: 6px;">
        <!-- Populate results in this panel via AJAX -->
        <?php
            if (!empty($message)) { echo $message; }
        ?>
    </div>
</div>

<div id="edit_report">
    <button type="button" id="closeEdit" class="btn btn-lg" style="background: none; color: #fff; position: absolute; top: 0; right: 0;"><span class="glyphicon glyphicon-remove"></span></button>
    <h3>Edit Report</h3>
    <form role="form" method="post" action="" class="form-horizontal">
        <input type="hidden" id="edit_report_id" name="edit_report_id">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group form-group-sm">
                <label for="edit_battle" title="Battle" class="control-label col-xs-12 col-sm-4">Battle:</label>
                <div class="col-xs-12 col-sm-8">
                    <select name="edit_battle" id="edit_battle" class="form-control edit_date">
                        <?php
                            foreach ($tt->prior_run_length as $battle => $length) {
                                echo '<option value="'.$battle.'">'.$battle.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="edit_date" title="Run Date" class="control-label col-xs-12 col-sm-4">Date:</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="edit_date" id="edit_date" class="edit_date form-control datepicker" style="cursor: pointer;" readonly>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="edit_time" title="Run Time" class="control-label col-xs-12 col-sm-4">Time:</label>
                <div class="form-inline col-xs-12 col-sm-8">
                    <select name="edit_time" id="edit_time" class="form-control" required oninvalid="this.setCustomValidity('Please select a run time.')" oninput="setCustomValidity('')">

                    </select>
                    <select name="edit_timezone" id="edit_timezone" class="edit_date form-control">
                        <option value="PT">Pacific</option>
                        <option value="MT">Mountain</option>
                        <option value="CT">Central</option>
                        <option value="ET">Eastern</option>
                        <option value="GMT">GMT</option>
                        <option value="BST">BST</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group form-group-sm">
                <label for="edit_reward" title="Reward" class="control-label col-xs-12 col-sm-5">Reward:</label>
                <div class="col-xs-12 col-sm-7">
                    <select name="edit_reward" id="edit_reward" class="form-control">

                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="edit_loaded" title="Toons Loaded" class="control-label col-xs-12 col-sm-5"># Toons Loaded:</label>
                <div class="col-xs-12 col-sm-7">
                    <select name="edit_loaded" id="edit_loaded" class="form-control" tabindex="5" required oninvalid="this.setCustomValidity('How many toons loaded into the elevator?')" oninput="setCustomValidity('')">
                        <option value=""></option>
                        <?php for ($i=1;$i<=8;$i++) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div id="edit_1" class="toon_info">
                <input type="hidden" id="suitlevel_1">
                <div class="form-inline form-group-sm">
                    <div class="col-xs-1"><label class="control-label">1</label></div>
                    <input type="text" name="edit_toon_1" id="edit_toon_1" placeholder="Name" class="col-xs-7 col-sm-4 form_field"> 
                    <input type="text" name="edit_laff_1" id="edit_laff_1" placeholder="Laff" class="col-xs-3 col-sm-2 form_field">
                    <select name="edit_suit_1" id="edit_suit_1" class="col-xs-7 col-xs-offset-1 col-sm-3 col-sm-offset-0 form_field suit">
                        <option value="">Suit</option>
                    </select>
                    <select name="edit_suitlevel_1" id="edit_suitlevel_1" class="col-xs-3 col-sm-1 form_field">
                    </select>
                </div>
                <div class="form-inline form-group-sm">
                    <select name="edit_status_1" id="edit_status_1" class="col-xs-10 col-xs-offset-1 col-sm-3 form_field">
                        <option value="Danced">Danced</option>
                        <option value="Sad in Cog Round">Sad in Cog Round</option>
                        <option value="Sad in Skele Round">Sad in Skele Round</option>
                        <option value="Sad in Pie Round">Sad in Pie Round</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="Alt-F4'd">Alt-F4'd</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6">Together in:
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_coground_1" id="edit_coground_1" value="1">Cog Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_skeleround_1" id="edit_skeleround_1" value="1">Skele Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_cleanupround_1" id="edit_cleanupround_1" value="1">Cleanup Round
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div id="edit_2" class="toon_info">
                <input type="hidden" id="suitlevel_2">
                <div class="form-inline form-group-sm">
                    <div class="col-xs-1"><label class="control-label">2</label></div>
                    <input type="text" name="edit_toon_2" id="edit_toon_2" placeholder="Name" class="col-xs-7 col-sm-4 form_field"> 
                    <input type="text" name="edit_laff_2" id="edit_laff_2" placeholder="Laff" class="col-xs-3 col-sm-2 form_field">
                    <select name="edit_suit_2" id="edit_suit_2" class="col-xs-7 col-xs-offset-1 col-sm-3 col-sm-offset-0 form_field suit">
                        <option value="">Suit</option>
                    </select>
                    <select name="edit_suitlevel_2" id="edit_suitlevel_2" class="col-xs-3 col-sm-1 form_field">
                    </select>
                </div>
                <div class="form-inline form-group-sm">
                    <select name="edit_status_2" id="edit_status_2" class="col-xs-10 col-xs-offset-1 col-sm-3 form_field">
                        <option value="Danced">Danced</option>
                        <option value="Sad in Cog Round">Sad in Cog Round</option>
                        <option value="Sad in Skele Round">Sad in Skele Round</option>
                        <option value="Sad in Pie Round">Sad in Pie Round</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="Alt-F4'd">Alt-F4'd</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6">Together in:
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_coground_2" id="edit_coground_2" value="1">Cog Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_skeleround_2" id="edit_skeleround_2" value="1">Skele Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_cleanupround_2" id="edit_cleanupround_2" value="1">Cleanup Round
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div id="edit_3" class="toon_info">
                <input type="hidden" id="suitlevel_3">
                <div class="form-inline form-group-sm">
                    <div class="col-xs-1"><label class="control-label">3</label></div>
                    <input type="text" name="edit_toon_3" id="edit_toon_3" placeholder="Name" class="col-xs-7 col-sm-4 form_field"> 
                    <input type="text" name="edit_laff_3" id="edit_laff_3" placeholder="Laff" class="col-xs-3 col-sm-2 form_field">
                    <select name="edit_suit_3" id="edit_suit_3" class="col-xs-7 col-xs-offset-1 col-sm-3 col-sm-offset-0 form_field suit">
                        <option value="">Suit</option>
                    </select>
                    <select name="edit_suitlevel_3" id="edit_suitlevel_3" class="col-xs-3 col-sm-1 form_field">
                    </select>
                </div>
                <div class="form-inline form-group-sm">
                    <select name="edit_status_3" id="edit_status_3" class="col-xs-10 col-xs-offset-1 col-sm-3 form_field">
                        <option value="Danced">Danced</option>
                        <option value="Sad in Cog Round">Sad in Cog Round</option>
                        <option value="Sad in Skele Round">Sad in Skele Round</option>
                        <option value="Sad in Pie Round">Sad in Pie Round</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="Alt-F4'd">Alt-F4'd</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6">Together in:
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_coground_3" id="edit_coground_3" value="1">Cog Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_skeleround_3" id="edit_skeleround_3" value="1">Skele Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_cleanupround_3" id="edit_cleanupround_3" value="1">Cleanup Round
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div id="edit_4" class="toon_info">
                <input type="hidden" id="suitlevel_4">
                <div class="form-inline form-group-sm">
                    <div class="col-xs-1"><label class="control-label">4</label></div>
                    <input type="text" name="edit_toon_4" id="edit_toon_4" placeholder="Name" class="col-xs-7 col-sm-4 form_field"> 
                    <input type="text" name="edit_laff_4" id="edit_laff_4" placeholder="Laff" class="col-xs-3 col-sm-2 form_field">
                    <select name="edit_suit_4" id="edit_suit_4" class="col-xs-7 col-xs-offset-1 col-sm-3 col-sm-offset-0 form_field suit">
                        <option value="">Suit</option>
                    </select>
                    <select name="edit_suitlevel_4" id="edit_suitlevel_4" class="col-xs-3 col-sm-1 form_field">
                    </select>
                </div>
                <div class="form-inline form-group-sm">
                    <select name="edit_status_4" id="edit_status_4" class="col-xs-10 col-xs-offset-1 col-sm-3 form_field">
                        <option value="Danced">Danced</option>
                        <option value="Sad in Cog Round">Sad in Cog Round</option>
                        <option value="Sad in Skele Round">Sad in Skele Round</option>
                        <option value="Sad in Pie Round">Sad in Pie Round</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="Alt-F4'd">Alt-F4'd</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6">Together in:
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_coground_4" id="edit_coground_4" value="1">Cog Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_skeleround_4" id="edit_skeleround_4" value="1">Skele Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_cleanupround_4" id="edit_cleanupround_4" value="1">Cleanup Round
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div id="edit_5" class="toon_info">
                <input type="hidden" id="suitlevel_5">
                <div class="form-inline form-group-sm">
                    <div class="col-xs-1"><label class="control-label">5</label></div>
                    <input type="text" name="edit_toon_5" id="edit_toon_5" placeholder="Name" class="col-xs-7 col-sm-4 form_field"> 
                    <input type="text" name="edit_laff_5" id="edit_laff_5" placeholder="Laff" class="col-xs-3 col-sm-2 form_field">
                    <select name="edit_suit_5" id="edit_suit_5" class="col-xs-7 col-xs-offset-1 col-sm-3 col-sm-offset-0 form_field suit">
                        <option value="">Suit</option>
                    </select>
                    <select name="edit_suitlevel_5" id="edit_suitlevel_5" class="col-xs-3 col-sm-1 form_field">
                    </select>
                </div>
                <div class="form-inline form-group-sm">
                    <select name="edit_status_5" id="edit_status_5" class="col-xs-10 col-xs-offset-1 col-sm-3 form_field">
                        <option value="Danced">Danced</option>
                        <option value="Sad in Cog Round">Sad in Cog Round</option>
                        <option value="Sad in Skele Round">Sad in Skele Round</option>
                        <option value="Sad in Pie Round">Sad in Pie Round</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="Alt-F4'd">Alt-F4'd</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6">Together in:
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_coground_5" id="edit_coground_5" value="1">Cog Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_skeleround_5" id="edit_skeleround_5" value="1">Skele Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_cleanupround_5" id="edit_cleanupround_5" value="1">Cleanup Round
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div id="edit_6" class="toon_info">
                <input type="hidden" id="suitlevel_6">
                <div class="form-inline form-group-sm">
                    <div class="col-xs-1"><label class="control-label">6</label></div>
                    <input type="text" name="edit_toon_6" id="edit_toon_6" placeholder="Name" class="col-xs-7 col-sm-4 form_field"> 
                    <input type="text" name="edit_laff_6" id="edit_laff_6" placeholder="Laff" class="col-xs-3 col-sm-2 form_field">
                    <select name="edit_suit_6" id="edit_suit_6" class="col-xs-7 col-xs-offset-1 col-sm-3 col-sm-offset-0 form_field suit">
                        <option value="">Suit</option>
                    </select>
                    <select name="edit_suitlevel_6" id="edit_suitlevel_6" class="col-xs-3 col-sm-1 form_field">
                    </select>
                </div>
                <div class="form-inline form-group-sm">
                    <select name="edit_status_6" id="edit_status_6" class="col-xs-10 col-xs-offset-1 col-sm-3 form_field">
                        <option value="Danced">Danced</option>
                        <option value="Sad in Cog Round">Sad in Cog Round</option>
                        <option value="Sad in Skele Round">Sad in Skele Round</option>
                        <option value="Sad in Pie Round">Sad in Pie Round</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="Alt-F4'd">Alt-F4'd</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6">Together in:
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_coground_6" id="edit_coground_6" value="1">Cog Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_skeleround_6" id="edit_skeleround_6" value="1">Skele Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_cleanupround_6" id="edit_cleanupround_6" value="1">Cleanup Round
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div id="edit_7" class="toon_info">
                <input type="hidden" id="suitlevel_7">
                <div class="form-inline form-group-sm">
                    <div class="col-xs-1"><label class="control-label">7</label></div>
                    <input type="text" name="edit_toon_7" id="edit_toon_7" placeholder="Name" class="col-xs-7 col-sm-4 form_field"> 
                    <input type="text" name="edit_laff_7" id="edit_laff_7" placeholder="Laff" class="col-xs-3 col-sm-2 form_field">
                    <select name="edit_suit_7" id="edit_suit_7" class="col-xs-7 col-xs-offset-1 col-sm-3 col-sm-offset-0 form_field suit">
                        <option value="">Suit</option>
                    </select>
                    <select name="edit_suitlevel_7" id="edit_suitlevel_7" class="col-xs-3 col-sm-1 form_field">
                    </select>
                </div>
                <div class="form-inline form-group-sm">
                    <select name="edit_status_7" id="edit_status_7" class="col-xs-10 col-xs-offset-1 col-sm-3 form_field">
                        <option value="Danced">Danced</option>
                        <option value="Sad in Cog Round">Sad in Cog Round</option>
                        <option value="Sad in Skele Round">Sad in Skele Round</option>
                        <option value="Sad in Pie Round">Sad in Pie Round</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="Alt-F4'd">Alt-F4'd</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6">Together in:
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_coground_7" id="edit_coground_7" value="1">Cog Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_skeleround_7" id="edit_skeleround_7" value="1">Skele Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_cleanupround_7" id="edit_cleanupround_7" value="1">Cleanup Round
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div id="edit_8" class="toon_info">
                <input type="hidden" id="suitlevel_8">
                <div class="form-inline form-group-sm">
                    <div class="col-xs-1"><label class="control-label">8</label></div>
                    <input type="text" name="edit_toon_8" id="edit_toon_8" placeholder="Name" class="col-xs-7 col-sm-4 form_field"> 
                    <input type="text" name="edit_laff_8" id="edit_laff_8" placeholder="Laff" class="col-xs-3 col-sm-2 form_field">
                    <select name="edit_suit_8" id="edit_suit_8" class="col-xs-7 col-xs-offset-1 col-sm-3 col-sm-offset-0 form_field suit">
                        <option value="">Suit</option>
                    </select>
                    <select name="edit_suitlevel_8" id="edit_suitlevel_8" class="col-xs-3 col-sm-1 form_field">
                    </select>
                </div>
                <div class="form-inline form-group-sm">
                    <select name="edit_status_8" id="edit_status_8" class="col-xs-10 col-xs-offset-1 col-sm-3 form_field">
                        <option value="Danced">Danced</option>
                        <option value="Sad in Cog Round">Sad in Cog Round</option>
                        <option value="Sad in Skele Round">Sad in Skele Round</option>
                        <option value="Sad in Pie Round">Sad in Pie Round</option>
                        <option value="Disconnected">Disconnected</option>
                        <option value="Alt-F4'd">Alt-F4'd</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6">Together in:
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_coground_8" id="edit_coground_8" value="1">Cog Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_skeleround_8" id="edit_skeleround_8" value="1">Skele Round
                            </label>
                            <label class="btn btn-default">
                                <input type="checkbox" name="edit_cleanupround_8" id="edit_cleanupround_8" value="1">Cleanup Round
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <label for="edit_notes" title="Notes" class="control-label col-xs-12 col-sm-3">Notes:</label>
            <div class="col-xs-12 col-sm-8">
                <textarea name="edit_notes" id="edit_notes" rows="4" class="form-control"></textarea>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
            <div class="form-group">
                <button type="submit" name="submitEdit" id="submitEdit" class="btn btn-primary form-control"><span class="glyphicon glyphicon-ok"></span> Save Report</button>
            </div>
        </div>
    </form>
</div>

<div id="delete_report">
    <h3>Delete Report</h3>
    <div class="err" id="add_err"></div>
    <form action="delete_report.php">
        <div class="row">
            <div class="col-xs-12">
                <h4 class="centered">Are you sure you want to delete this report?</h4>
                <input type="hidden" name="delete_result_id" id="delete_result_id">
                <div class="col-xs-5 col-xs-offset-1">
                    <input type="submit" id="confirm_delete" value="Yes" class="btn btn-primary btn-block btn-lg">
                </div>
                <div class="col-xs-5">
                    <input type="button" id="cancel_delete" value="No" class="btn btn-danger btn-block btn-lg">
                </div>
            </div>
        </div>
    </form>
</div>

<?php } ?>

<!-- footer -->
	</div>
    </div>

<?php include_once('./tpl/footer.php'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="js/victories.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#edit_date").datepicker();
            $("#run_date").datepicker({
                orientation: 'bottom'
            });
            $("#run_month").datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'mm/yy',
                beforeShow: function(input, inst) {
                    if ((dateStr = $(this).val()).length > 0) {
                        var month = parseInt(dateStr.substring(0, 2)) - 1;
                        var year = dateStr.substr(3);
                        $(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
                        $(this).datepicker('setDate', new Date(year, month, 1));
                    }
                },
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            }).focus(function(){
                $(".ui-datepicker-calendar").hide();
                $("#ui-datepicker-div").position({
                    my: "center top",
                    at: "center bottom",
                    of: $(this)
                });
            });
        });
    </script>

  </body>
</html>