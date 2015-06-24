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
    <h3>Edit Report</h3>
    <form action="save_report.php" class="form-horizontal">
        <input type="hidden" id="edit_report_id">
        <div class="col-xs-12">
            <div class="form-group form-group-sm">
                <label for="edit_battle" title="Battle" class="control-label col-xs-12 col-sm-3">Battle:</label>
                <div class="col-xs-12 col-sm-3">
                    <select name="edit_battle" id="edit_battle" class="form-control run_date">
                        <?php
                            foreach ($tt->prior_run_length as $battle => $length) {
                                echo '<option value="'.$battle.'">'.$battle.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="edit_date" title="Run Date" class="control-label col-xs-12 col-sm-3">Date:</label>
                <div class="col-xs-12 col-sm-3">
                    <input type="text" name="edit_date" id="edit_date" class="run_date form-control datepicker" style="cursor: pointer;" readonly>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="edit_time" title="Run Time" class="control-label col-xs-12 col-sm-3">Time:</label>
                <div class="form-inline col-xs-12 col-sm-8">
                    <select name="edit_time" id="edit_time" class="form-control" required oninvalid="this.setCustomValidity('Please select a run time.')" oninput="setCustomValidity('')">

                    </select>
                    <select name="edit_timezone" id="edit_timezone" class="run_date form-control">
                        <option value="PT">Pacific</option>
                        <option value="MT">Mountain</option>
                        <option value="CT">Central</option>
                        <option value="ET">Eastern</option>
                        <option value="GMT">GMT</option>
                        <option value="BST">BST</option>
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="edit_reward" title="Reward" class="control-label col-xs-12 col-sm-3">Reward:</label>
                <div class="col-xs-12 col-sm-3">
                    <select name="edit_reward" id="edit_reward" class="form-control">

                    </select>
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

            var getRunTimes = function(select_ctl) {
                var battle = $("#edit_battle").val();
                var date_val = $("#edit_date").val();
                var time_val = $("#edit_time").val();
                var tz = $("#edit_timezone").val();
                $.ajax({
                    type: "POST",
                    url: "run_times.php",
                    data: "battle="+battle+"&date="+date_val+"&tz="+tz,
                    success: function(html){
                        $("#"+select_ctl).html(html);
                        $("#"+select_ctl).val(time_val);
                    }
                });
            }

            $(".run_date").change(function(){
                getRunTimes("edit_time");
            });

            var loadRewards = function(battle){
                $.ajax({
                    type: "POST",
                    url: "battle_rewards.php",
                    data: "battle="+battle,
                    success: function(html){
                        $("#edit_reward").html(html);
                    }
                });
            }

            $("#edit_battle").change(function(){
                var battle = $(this).val();
                loadRewards(battle);
            });

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
                        console.log(json);
                        var report = $.parseJSON(json);
                        console.log(report.toon_1);
                        var datetime = new Date(report.run_datetime);
                        $("#edit_date").val((datetime.getMonth()+1)+'/'+datetime.getDate()+'/'+datetime.getFullYear());
                        $("#edit_timezone").val(tz);
                        getRunTimes("edit_time");
                        var time = (datetime.getHours() < 12 ? '0'+datetime.getHours() : datetime.getHours())+':'+(datetime.getMinutes() < 10 ? '0'+datetime.getMinutes() : datetime.getMinutes())+(datetime.getHours() < 12 ? ' AM' : ' PM');
                        var battle = $("#edit_battle").val();
                        loadRewards(battle);
                    }
                });
                $("#edit_report").fadeIn("normal");
            });
        });
    </script>

  </body>
</html>