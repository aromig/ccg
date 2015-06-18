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
        // Edit Users

        // Edit Run Reports

        // Edit Other Things
?>

<!-- Content goes here -->
<div class="row">

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
    
    <script type="text/javascript" src="js/login.js"></script>

  </body>
</html>