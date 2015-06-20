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
                // Edit Users
                $user = array();
                $user['mcf_username'] = $_POST['username'];
                $user['admin'] = isset($_POST['admin']) ? 1 : 0;

                $stmt = $db->update("ccg_users",
                    $user,
                    array("ccg_id"=>$_POST['ccg_id'])
                );

                if ($stmt == 1) { $success = '<label class="input-lg bg-success">User Saved!</label>'; }
            }

        // Edit Toons

        // Edit Run Reports

        // Edit Other Things
        }
?>

<!-- Content goes here -->
<div class="row">
    <div class="col-xs-12"><h3>AdminCP</h3></div>

    <div id="admin_nav" class="col-xs-12 col-sm-3 col-sm-push-9 col-md-2 col-md-push-10">
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#userMgr"><span class="glyphicon glyphicon-user"></span> Users</a></li>
            <li><a data-toggle="pill" href="#toonMgr"><span class="glyphicon glyphicon-sunglasses"></span> Toons</a></li>
            <li><a data-toggle="pill" href="#reportMgr"><span class="glyphicon glyphicon-list-alt"></span> Reports</a></li>
            <li><a data-toggle="pill" href="#optionMgr"><span class="glyphicon glyphicon-cog"></span> Options</a></li>
        </ul>
    </div>

    <div id="admin_panel" class="col-xs-12 col-sm-9 col-sm-pull-3 col-md-10 col-md-pull-2">
        <div class="tab-content">
            <div id="userMgr" class="tab-pane fade in active">
                <h4>Manage Users</h4>
                <div class="col-xs-12 col-sm-8 col-md-6">
                    <div class="input-group">
                        <input type="text" name="search_user" id="search_user" class="form-control" placeholder="User Name">
                        <span class="input-group-btn">
                            <button name="search_user_btn" id="search_user_btn" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </span>
                    </div>
                </div>
                <?php if (isset($success)) { echo'<div class="col-xs-12">'.$success.'</div>'; } ?>
                <div id="user_results" style="margin-top: 12px;"></div>
                <div id="user_details" style="clear: both;">
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
                        <div class="form-group col-xs-6 col-sm-6">
                            <label for="bassie" class="col-xs-12 control-label"><input type="checkbox" id="bassie" name="bassie" value="1" disabled> Ambassador?</label>
                            <input type="hidden" id="bassie_val" name="bassie_val" value="">
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
            </div>
            <div id="reportMgr" class="tab-pane fade">
                <h4>Manage Reports</h4>
            </div>
            <div id="optionMgr" class="tab-pane fade">
                <h4>Manage Options</h4>
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

    <footer class="container centered">
        
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
        $("#user_details").hide();

        $("#search_user").keypress(function(event){
            if (event.which == 13) {
                event.preventDefault();
                $("#search_user_btn").trigger("click");
            }
        });
        $("#search_user_btn").click(function(){
            var query = $("#search_user").val();
            var type = "user";
            $.ajax({
                type: "POST",
                url: "cp_search.php",
                data: "type="+type+"&query="+query,
                success: function(html){
                    $("#user_results").html(html);
                }
            });
        });

        $("#user_results").on('click', '.user_result', function(){
            var userid = $(this).prop('id');
            $.ajax({
                type: "POST",
                url: "cp_user.php",
                data: "userid="+userid,
                success: function(json){
                    // populate form elements from json object
                    var user = $.parseJSON(json);
                    $("#ccg_id").val(user.ccg_id);
                    $("#orig_username").val(user.mcf_username);
                    $("#username").val(user.mcf_username);
                    $("#forum_title").html(user.mcf_title);
                    $("#reg_date").val(user.reg_date);
                    $("#reg_ip").val(user.reg_ip);
                    $("#last_login").val(user.last_login);
                    $("#last_ip").val(user.last_ip);
                    $("#bassie_val").val(user.bassie);
                    if (parseInt(user.bassie) === 1) { $("#bassie").prop('checked', true); } else { $("#bassie").prop('checked', false); }
                    if (parseInt(user.admin) === 1) { $("#admin").prop('checked', true); } else { $("#admin").prop('checked', false); }
                    $("#user_details").show();
                }
            });
        });

        $("#user_form").submit(function(){
            var original_username = $("#username").val();
            var new_username = $("#orig_username").val();

            if (new_username != original_username) {
                var response = confirm("You are about to change this user's username. This only should be done when the user's forum account has been renamed. Doing so otherwise will leave the user unable to access their profile.\r\n\r\nAre you sure you want to do this?");
                if (!response) {
                    return false;
                }
            }
        });
    });
    </script>

  </body>
</html>