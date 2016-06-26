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
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="images/logo.png">
    <script src="js/jquery-2.2.4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            timezone();
        });
            function logout() {
                $.ajax({
                    type: 'GET',
                    url: 'php/logout.php',
                    success: function (response) {
                        if (response == 1) {
                            window.open("login.php", "_self");
                        }
                    }
                });
            }

            function timezone() {
                $('#cont5').html("Loading...");
                $('#timezone').addClass('active');
                $.getJSON('php/data.php', {url: escape(4)}, function (data) {

                    var mapData = Highcharts.geojson(Highcharts.maps['custom/world']);
                    // console.log();
                    // Correct UK to GB in data
                    $.each(data, function () {
                        if (this.code === 'UK') {
                            this.code = 'GB';
                        }
                    });

                    $('#cont5').highcharts('Map', {
                        chart: {
                            borderWidth: 1
                        },

                        title: {
                            text: 'Users in Different Timezone'
                        },

                        subtitle: {
                            text: ''
                        },

                        legend: {
                            enabled: false
                        },

                        mapNavigation: {
                            enabled: true,
                            buttonOptions: {
                                verticalAlign: 'bottom'
                            }
                        },

                        series: [{
                            name: 'Countries',
                            mapData: mapData,
                            color: '#E0E0E0',
                            enableMouseTracking: false
                        }, {
                            type: 'mapbubble',
                            mapData: mapData,
                            name: 'Total Users',
                            joinBy: ['iso-a2', 'code'],
                            data: data,
                            minSize: 4,
                            maxSize: '12%',
                            tooltip: {
                                pointFormat: '{point.country}: {point.z} users'
                            }
                        }]
                    });
                });
            }
    </script>
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
            <a class="navbar-brand" href="index.php">Perfmon.io</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Profile<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li style="font-size: 25px;"><a><span
                                    class="glyphicon glyphicon-user"></span>&nbsp;<span><?php echo $_SESSION['email'] ?></span></a>
                        </li>
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
                <li id="userstats"><a href="index.php">Home Page</a></li>
                <li id="timezone" onclick="timezone()" class="active"><a>User by TimeZone</a></li>
                <li id="logout" onclick="logout()"><a>Logout</a></li>
            </ul>
        </div>
        <div id="graph" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" align="center">
            <div id="cont5" style="height: 500px; min-width: 310px; max-width: 800px; margin: 0 auto"></div>
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
<script>
    function passwordscreen() {
        var html = '<form id="changepasswordform" autocomplete="off" style="max-width:400px;margin-top: 20%"><div id="error" class="alert alert-danger"></div><div class="input-group input-group-lg"><span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span><input id="password" type="password" class="form-control" placeholder="New Password" required></div><br><div class="input-group input-group-lg"><span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span><input id="cpassword" type="password" class="form-control" placeholder="Confirm Password" required></div><br><div class="btn-group"><button id="changepassword" type="button" class="btn btn-primary btn-lg" onclick="checkpassword()">Change Password</button></div></form>';
        $('#cont5').html(html);
        $('#error').hide();
        $('#timezone').removeClass('active');
    }

    function checkpassword() {
        var password = $('#password').val();
        var cpassword = $('#cpassword').val();
        if (password == "" || cpassword == "") {
            $('#error').html("<strong>Please Enter your Password</strong>");
            $('#error').show();
            $('#password').val("");
            $('#cpassword').val("");
        }
        else if (password != cpassword) {
            $('#error').html("<strong>Passwords don't match</strong>");
            $('#error').show();
            $('#password').val("");
            $('#cpassword').val("");
        }
        else {
            $.ajax({
                type: 'POST',
                url: 'php/changeadminpassword.php',
                data: {password: password},
                success: function (response) {
                    if (response == 1) {
                        $('#modal-title').html("Important Information");
                        $('#modal-body').html("Password Updated Sucessfully");
                        $('#myModal').modal('show');
                        timezone();
                    }
                }
            });
        }
    }
</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/highmaps.js"></script>
<script src="js/data.js"></script>
<script src="js/world.js"></script>

</body>
</html>
