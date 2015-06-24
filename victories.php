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
    </div>
</div>

<div id="edit_report">
    <button type="button" id="closeEdit" class="btn btn-lg" style="background: none; color: #fff; position: absolute; top: 0; right: 0;"><span class="glyphicon glyphicon-remove"></span></button>
    <h3>Edit Report</h3>
    <form action="save_report.php" class="form-horizontal">
        <input type="hidden" id="edit_report_id">
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
                        <?php for ($i=1;$i<=8;$i++) { echo '<option value="'.$i,'">'.$i.'</option>'; } ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
            <div class="form-group">
                <button type="submit" name="submitEdit" id="submitEdit" class="btn btn-primary form-control"><span class="glyphicon glyphicon-ok"></span> Save Report</button>
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

            $("#closeEdit").click(function() {
                $("#edit_report").fadeOut("normal");
            });

            var getEditRunTimes = function(select_ctl, report_value) {
                var battle = $("#edit_battle").val();
                var date_val = $("#edit_date").val();
                var time_val = (report_value == '') ? $("#edit_time").val() : report_value;
                var tz = $("#edit_timezone").val();
                $.ajax({
                    type: "POST",
                    url: "run_times.php",
                    data: "battle="+battle+"&date="+date_val+"&tz="+tz,
                    success: function(html){
                        $("#"+select_ctl).html(html);
                        setTimeout(function(){$("#"+select_ctl).val(time_val);}, 500);
                    }
                });
            }

            $(".edit_date").change(function(){
                getEditRunTimes("edit_time", "");
            });

            var loadRewards = function(battle, value){
                $.ajax({
                    type: "POST",
                    url: "battle_rewards.php",
                    data: "battle="+battle,
                    success: function(html){
                        $("#edit_reward").html(html);
                        $("#edit_reward").val(value);
                    }
                });
            }

            $("#edit_battle").change(function(){
                var battle = $(this).val();
                loadRewards(battle, '');
                populateSuits(battle);
                if (battle == 'VP') {
                    $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                        $(this).parent().show();
                    });
                } else {
                    $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                        $(this).parent().hide();
                        if ($(this).prop('checked')) {
                            $(this).prop('checked', false);
                            $(this).parent().toggleClass('active');
                            $(this).blur();
                        }
                    });
                }
            });

            var populateSuits = function(battle) {
                $.ajax({
                    type: "POST",
                    url: "report_suit.php",
                    data: "battle="+battle,
                    success: function(html){
                        $("#edit_suit_1,#edit_suit_2,#edit_suit_3,#edit_suit_4,#edit_suit_5,#edit_suit_6,#edit_suit_7,#edit_suit_8").each(function(){
                            $(this).html(html);

                            var ddl = $(this).prop("name");
                            var ddl_val = $(this).val();
                            var num = ddl.substr(ddl.lastIndexOf("_")+1);

                            $("#edit_suitlevel_"+num).html('');
                        });
                    }
                });
            }

            var populateSuitLevels = function(select_ctl) {
                var ddl = $(select_ctl).prop("name");
                var ddl_val = $(select_ctl).val();
                var num = select_ctl.substr(select_ctl.lastIndexOf("_")+1);

                $.ajax({
                    type: "POST",
                    url: "report_suitlevel.php",
                    data: "suit="+encodeURIComponent(ddl_val),
                    success: function(html){
                        $("#edit_suitlevel_"+num).html(html);
                        setTimeout(function(){$("#edit_suitlevel_"+num).delay(100).val($("#suitlevel_"+num).val());}, 500);
                    }
                });
            }

            $(".suit").change(function(){
                var ddl = $(this).prop("name");
                var ddl_val = $(this).val();
                var num = ddl.substr(ddl.lastIndexOf("_")+1);

                $.ajax({
                    type: "POST",
                    url: "report_suitlevel.php",
                    data: "suit="+encodeURIComponent(ddl_val),
                    success: function(html){
                        $("#edit_suitlevel_"+num).html(html);
                    }
                });
            });

            var populateForm = function(json, tz) {
                var report = $.parseJSON(json);
                var battle = report.battle;
                $("#edit_battle").val(battle);

                if (battle == 'VP') {
                    $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                        $(this).parent().show();
                    });
                } else {
                    $("#edit_skeleround_1,#edit_skeleround_2,#edit_skeleround_3,#edit_skeleround_4,#edit_skeleround_5,#edit_skeleround_6,#edit_skeleround_7,#edit_skeleround_8").each(function(){
                        $(this).parent().hide();
                        if ($(this).prop('checked')) {
                            $(this).prop('checked', false);
                            $(this).parent().toggleClass('active');
                            $(this).blur();
                        }
                    });
                }

                var datetime = new Date(report.run_datetime);
                $("#edit_date").val((datetime.getMonth()+1)+'/'+datetime.getDate()+'/'+datetime.getFullYear());
                $("#edit_timezone").val(tz);
                var hour = (datetime.getHours() <= 12) ? datetime.getHours() : datetime.getHours()-12;
                var hour = (hour < 12) ? '0'+hour : hour;
                var minute = (datetime.getMinutes() < 10) ? '0'+datetime.getMinutes() : datetime.getMinutes();
                var ampm = (datetime.getHours() < 12) ? ' AM' : ' PM';
                var time = hour+':'+minute+ampm;

                getEditRunTimes("edit_time", time);
                loadRewards(battle, report.reward);
                $("#edit_loaded").val(report.toons_loaded).trigger('change');
                populateSuits(battle);

                var toon = new Array();
                toon[1] = $.parseJSON(report.toon_1);
                toon[2] = $.parseJSON(report.toon_2);
                toon[3] = $.parseJSON(report.toon_3);
                toon[4] = $.parseJSON(report.toon_4);
                toon[5] = $.parseJSON(report.toon_5);
                toon[6] = $.parseJSON(report.toon_6);
                toon[7] = $.parseJSON(report.toon_7);
                toon[8] = $.parseJSON(report.toon_8);
                setTimeout(function(){
                    for (var i=1;i<=8;i++) {
                        if (toon[i] !== null) {
                            $("#edit_toon_"+i).val(toon[i].name);
                            $("#edit_laff_"+i).val(toon[i].laff);
                            var suit = toon[i].suit;
                            $("#suitlevel_"+i).val(toon[i].suitlevel);
                            $("#edit_suit_"+i).val(suit);
                            populateSuitLevels('#edit_suit_'+i);
                            $("#edit_status_"+i).val(toon[i].status);

                            $("#edit_coground_"+i).prop('checked', false).parent().removeClass('active');
                            if (toon[i].coground) { $("#edit_coground_"+i).prop('checked', true).parent().toggleClass('active'); }
                            $("#edit_skeleround_"+i).prop('checked', false).parent().removeClass('active');
                            if (toon[i].skeleround) { $("#edit_skeleround_"+i).prop('checked', true).parent().toggleClass('active'); }
                        }
                    }
                }, 500);
            }

            $("#show_reports").on('click', '.edit_report', function(){
                var callid = $(this).prop("id").split("_");
                var resultid = callid[0];
                var tz = callid[1];
                $("#edit_report_id").val(resultid);
                
                $.ajax({
                    type: "POST",
                    url: "edit_report.php",
                    data: "resultid="+resultid,
                    success: function(json){
                        populateForm(json, tz);
                    }
                });
                $("#edit_report").fadeIn("normal");
                return false;
            });

            $("#edit_loaded").change(function(){
                for (i=1;i<=8;i++) {
                    $("#edit_"+i).hide();
                }
                if ($("#loaded").val() != "") {
                    for (i=1;i<=parseInt($("#edit_loaded").val());i++) {
                        $("#edit_"+i).show();
                    }
                }
            });

        });
    </script>

  </body>
</html>