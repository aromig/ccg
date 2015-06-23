<?php
	$page_title = 'Register Your Account - The Cold Callers Guild';

    include_once('./tpl/header.php');

    $joined = false;
    // Form Submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $stmt = $db->insert("ccg_users", array(
                "mcf_userid"=>$current_user['userid'],
                "mcf_username"=>$_SESSION['user'],
                "reg_date"=>date('Y-m-d'),
                "reg_ip"=>$_SERVER['REMOTE_ADDR']
            ));
        }
        catch (PDOException $e) {
            $error[] = $e->getMessage();
        }

        if ($stmt > 0) {
            $joined = true;
        }
    }


    if (!$joined) {
?>

<!-- Content goes here -->
<div class="row">
    <?php if ($_SESSION['registered'] == false) { ?>
    <div class="col-xs-12"><h3>Register Your Account</h3></div>
    <div class="col-xs-12"><p>Please confirm your account name below to register your MMOCentralForums.com account with the Cold Callers Guild site.</p></div>
    <div class="col-xs-12">
        <form role="form" method="post" action="" autocomplete="off" id="registration">
            <div class="form-group col-sm-6">
                <label for="username" title="MMOCentralForums.com Username" class="control-label">MMOCentralForums.com Username:</label>
                <input type="text" name="username" id="username" class="form-control input-lg" value="<?php if (isset($_SESSION['user'])) { echo $_SESSION['user']; } ?>" readonly>
            </div>
            <?php if (!isset($_SESSION['user'])) { ?>
            <div class="form-group col-sm-12">
                <h5>Why is this blank?</h5>
                <p>You must be logged into <a href="http://mmocentralforums.com/">MMOCentralForums</a> and part of the proper <a href="http://www.mmocentralforums.com/forums/profile.php?do=editusergroups">CCG usergroup</a> in order to register on this site.</p>
            </div>
            <?php } else { ?>
            <div class="col-sm-6">
                <?php
                    if (isset($error)) {
                        foreach ($error as $err) {
                            echo '<label class="input-lg bg-danger error">'.$err.'</label>';
                        }
                    }
                ?>
            </div>
            <div class="form-group col-xs-12">
                <div class="col-xs-6 col-sm-4">
                    <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg"><span class="glyphicon glyphicon-pencil"></span> Register Account</button>
                </div>
            </div>
            <?php } ?>
        </form>
    </div>
    <?php } else { ?>

    <div class="col-xs-12"><h3>You're Already Registered</h3></div>
    <div class="col-xs-12"><p>Your MMOCentralForums account is already registered on this site.</p></div>

    <?php }

    } else {
    ?>

<!-- Alternate content after registering -->
<div class="row">
    <div class="col-xs-12"><h3>Account Registered</h3></div>
    <div class="col-xs-12 col-sm-6">
        <p>Thank you for registering your MMOCentralForums account! You should now be able to access your <a href="profile.php">Profile</a>.</p>
    </div>
    <div class="col-xs-12 col-sm-6 centered"><img src="images/ttFlippy.png" alt="Flippy" /></div>
<?php } ?>
</div>

<!-- footer -->
	</div>
    </div>

<?php include_once('./tpl/footer.php'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>