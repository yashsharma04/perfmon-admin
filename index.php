<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | Perfmon.io</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="images/logo.png">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" onclick="userstats()">Perfmon.io</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li style="font-size: 25px;"><a><span class="glyphicon glyphicon-user"></span>&nbsp;<span><?php echo $_SESSION['name'] ?></span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a>Help</a></li>
                        <li><a onclick="passwordscreen()">Change Password</a></li>
                        <li><a onclick="logout()">Logout</a></li>
                    </ul>
                </li>
                <li><a></a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <span style="text-transform: uppercase"><?php echo '<h4>' . $_SESSION['name'] . '</h4>'; ?></span>
            <ul class="nav nav-sidebar">
                <li id="userstats"><a>User Stats</a></li>
                <li id="websitestats"><a>Website Stats</a></li>
                <li id="systemstats"><a>System Stats</a></li>
                <li id="timezone"><a href="timezone.php">User by TimeZone</a></li>
                <li id="requestdata"><a>Request a Data</a></li>
                <li id="logout"><a>Logout</a></li>
            </ul>
        </div>
        <div id="content" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" align="center">
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div id="modal-body" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/functions.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
</body>
</html>
