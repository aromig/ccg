<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $page_title ?></title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css" rel="stylesheet">

    <!-- jQueryUI -->
    <link href="http://code.jquery.com/ui/1.11.4/themes/redmond/jquery-ui.css" rel="stylesheet">

    <!-- Main Stylesheet -->
    <link href="css/ccg.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div id="wrapper">
    
    <div class="container" id="banner">
        <div class="row">
            <div class="col-xs-12 text-center" id="logo">
                <img src="images/ccg_logo.png" title="Cold Callers Guild" alt="Cold Callers Guild" />
            </div>
        </div>
    </div>
      
    <nav class="navbar navbar-default navbar-static-top container" role="navigation" id="topnavbar">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                    
            </button>
            <?php if ($ccg->is_admin($_SESSION['user'])) { ?>
                <a class="navbar-brand" style="padding-top: 10px;" href="admincp.php">
            <?php } else { ?>
                <a class="navbar-brand" style="padding-top: 10px;">
            <?php } ?>
            <img src="images/cog_35x35.png" alt="CCG" /></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li>
                    <?php if($_SESSION['registered']){ ?>
                    <a href="profile.php">Profile</a>
                    <?php } else { ?>
                    <a href="register.php">Register</a>
                    <?php } ?>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ToonTown Rewritten <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="http://www.toontownrewritten.com/login" target="_blank">Play TTR</a></li>
                        <li><a href="members.php">Member List</a></li>
                        <li><a href="schedule.php">Run &amp; Event Schedules</a></li>
                        <li><a href="guidelines.php">Guidelines &amp; Strategies</a></li>
                        <li><a href="report_run.php">Report a Run</a></li>
                        <li><a href="victories.php">Victories</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Wizard101 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="https://www.wizard101.com/game" target="_blank">Play W101</a></li>
                        <!--li><a href="#">Member List</a></li-->
                    </ul>
                </li>
                <li><a href="http://www.mmocentralforums.com/forums/forumdisplay.php?f=168">Forums</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" id="content">