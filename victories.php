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
                <div class="form-group">
                    <label for="run_date" class="control-label" title="Run Date">Date</label>
                    <input type="text" name="run_date" id="run_date" tabindex="1" class="run_date form-control datepicker" style="cursor: pointer;" value="<?= date('m/d/Y') ?>" readonly>
                </div>
                <div class="form-group">
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
                <div class="form-group">
                    <label for="battle_by_date" class="control-label" title="Battle">Battle</label>
                    <select name="battle_by_date" id="battle_by_date" tabindex="4" class="run_date form-control">
                        <option value=""></option>
                        <option value="vp">VP</option>
                        <option value="cfo">CFO</option>
                        <option value="cj">CJ</option>
                        <option value="ceo">CEO</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" name="refresh_date" id="refresh_date" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
                </div>
            </div>

            <div id="by_month" class="tab-pane fade form-inline">
                <div class="form-group">
                    <label for="run_month" class="control-label" title="Run Month">Month</label>
                    <input type="text" name="run_month" id="run_month" tabindex="1" class="form-control datepicker" readonly>
                </div>
                <div class="form-group">
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
                <div class="form-group">
                    <label for="battle_by_month" class="control-label" title="Battle">Battle</label>
                    <select name="battle_by_month" id="battle_by_month" tabindex="3" class="run_date form-control">
                        <option value=""></option>
                        <option value="vp">VP</option>
                        <option value="cfo">CFO</option>
                        <option value="cj">CJ</option>
                        <option value="ceo">CEO</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" name="refresh_month" id="refresh_month" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12" id="show_reports" style="margin-top: 6px;">
        <!-- Populate results in this panel via AJAX -->
    </div>
</div>

<?php
    }
?>

<!-- footer -->
	</div>
    </div>

    <footer class="container centered">
        
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="js/victories.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#run_date").datepicker();
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
                    var year = $("#ui-datepicker div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            }).focus(function(){
                $(".ui-datepicker-calendar").hide();
            });
        });
    </script>

  </body>
</html>