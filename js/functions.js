/**
 * Created by Manish Bisht on 6/10/2016.
 */
$(document).ready(function () {
    userstats();
    $('#userstats').click(function () {
        userstats();
    });
    $('#websitestats').click(function () {
        websitestats();
    });
    $('#systemstats').click(function () {
        systemstats();
    });
    $('#requestdata').click(function () {
        showdataform();
    });
    $('#logout').click(function () {
        logout();
    });
});

function userstats(){
    $('#userstats').addClass('active');
    $('#websitestats').removeClass('active');
    $('#systemstats').removeClass('active');
    $('#requestdata').removeClass('active');
    $('#content').html("Loading...");
    $.ajax({
        type: 'GET',
        url: 'php/userStatsAction.php',
        success: function (response) {
            if (response != 0) {
                var html = '<table id="table1" class="table table-striped table-bordered"><thead><tr><th>Name</th><th>Joined Date</th><th>Last Updated</th><th>Last Login</th><th>No. of Sites</th><th>Plan Type</th><th>Down Websites</th></tr></thead><tbody>';
                response = JSON.parse(response);
                for (var i = 0; i < response.length; i++) {
                    var s = i + 1;
                    html+="<tr><td><a href='mailto:"+response[i].userEmail+"'>"+response[i].name+"</a></td><td>"+response[i].joinedDate+"<br>"+response[i].joinedTime+"</td><td>" +response[i].last_updatedDate+"<br>"+response[i].last_updatedTime+ "</td><td></td><td>" +response[i].no_of_sites_down+ "</td><td>Free</td><td><button type='button' class='btn btn-warning btn-info btn-block' onclick=getDownWebsites('"+response[i].userEmail+"')>Down Websites</button></td></tr>";
                }
                html+='</tbody></table>';
                $('#content').html(html);
                $('#table1').DataTable();
            }
            else {
                var html = "";
                $('#content').html(html);
            }
        }
    });


}

function getDownWebsites(userEmail){
    $('#modal-title').html("URL of Down Websites");
        $.ajax({
            type:'GET',
            url: 'php/getDownWebsites.php',
            data: { 'userEmail': userEmail },
            success: function (response) {
                html="";
                if(response!="NONE"){
                    response=JSON.parse(response);
                    html+='<table id="table3" class="table table-striped table-bordered"><thead><tr><th>URL</th><th>Down Time</th><th>Status</th></tr></thead><tbody>';
                    for(i=0;i<response.length;i++){
                        html+="<tr><td><a target='_blank' href='"+response[i].url+"'>"+response[i].url+"</a></td><td>"+response[i].downTime+"</td><td>"+response[i].status+"</td></tr>";
                    }
                    html+="</table>";
                }
                else{
                    html+='<p>No sites are down. Enjoy!!</p>';
                }
                $('#modal-body').html(html);
                $('#table3').DataTable({
                    pageLength:8
                });
                $('#myModal').modal('show');

            }
        });
}


function websitestats(){
    $('#userstats').removeClass('active');
    $('#websitestats').addClass('active');
    $('#systemstats').removeClass('active');
    $('#requestdata').removeClass('active');
    $('#content').html("Loading...");
    $.ajax({
        type:'GET',
        url:'php/websitestats.php',
        success: function (response) {
            response=JSON.parse(response);
            html="<table id='table2' class='table table-striped table-bordered'><thead><th>URL</th><th>Added On</th><th>Updated On</th><th>By</th><th>Down %</th><th>WhoIS</th></thead><tbody>";
            for(var i=0;i<response.length;i++){
                html+="<tr><td><a target='_blank' href='"+response[i].url+"'>"+response[i].url+"</a></td><td>"+response[i].date+"<br>"+response[i].time+"</td><td></td><td><a href='mailto:"+response[i].user+"'>"+response[i].user+"</a></td><td>"+response[i].downpercent+"%</td><td><button type='button' class='btn btn-primary btn-info btn-block' onclick=whois('"+response[i].url+"')>View</button></td></tr>";
            }
            html+="</tbody></table>";
            $('#content').html(html);
            $('#table2').DataTable();
        }
    });
}

function whois(url){
    $('#modal-title').html("Website Details");
    $('#modal-body').html("Loading...");
    $('#myModal').modal('show');
    $.ajax({
        type:'GET',
        url:'php/whois.php',
        data:{url:url},
        success: function (response) {
            response=JSON.parse(response);
            var html="<ul>";
            html+="<li>Host : "+response.host+"</li>";
            html+="<li>Class : "+response.class+"</li>";
            html+="<li>TTL : "+response.ttl+"</li>";
            html+="<li>Type : "+response.type+"</li>";
            html+="<li>Target : "+response.target+"</li>";
            html+="<li>IP : "+response.ip+"</li>";
            html+="</ul>";
            $('#modal-body').html(html);
            $('#myModal').modal('show');
        }
    });

}

function systemstats(){
    $('#userstats').removeClass('active');
    $('#websitestats').removeClass('active');
    $('#systemstats').addClass('active');
    $('#requestdata').removeClass('active');
    var html="<div class='col-xs-6 col-sm-6 placeholder'><div id='cont1' style='min-width: 300px; height: 300px; margin: 0 auto'></div></div><div class='col-xs-6 col-sm-6 placeholder'><div id='cont2' style='min-width: 300px; height: 300px; margin: 0 auto'></div></div><div class='col-xs-6 col-sm-6 placeholder'><div id='cont3' style='min-width: 300px; height: 300px; margin: 0 auto'></div></div><div class='col-xs-6 col-sm-6 placeholder'><div id='cont4' style='min-width: 300px; height: 300px; margin: 0 auto'></div></div></div>";
    $('#content').html(html);
    $.getJSON('php/data.php',{ url: escape(0)},function (jsonData){
        $('#cont1').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Signups By Date'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'No of Users'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                type: 'areaspline',
                name: 'No of Users',
                data: jsonData
            }]
        });
    });

    $.getJSON('php/data.php',{ url: escape(1)},function (jsonData){
        $('#cont2').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Websites Added By Date'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'No of Websites'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                type: 'areaspline',
                name: 'No of Websites',
                data: jsonData
            }]
        });
    });

    $.getJSON('php/data.php',{ url: escape(2)},function (jsonData){
        $('#cont3').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Number of Users By Domain'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                title: {
                    text: 'site'
                }
            },
            yAxis: {
                title: {
                    text: 'No of Users'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                type: 'areaspline',
                name: 'No of Users',
                data: jsonData
            }]
        });
    });

    $.getJSON('php/data.php',{ url: escape(3)},function (jsonData){
        $('#cont4').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Number of Websites By Each User'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                title: {
                    text: 'user'
                }
            },
            yAxis: {
                title: {
                    text: 'No of Websites'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                type: 'areaspline',
                name: 'No of Websites',
                data: jsonData
            }]
        });
    });
    usersbydomain();
}

function usersbydomain(){
    $.ajax({
        type: 'GET',
        url: 'php/usersbydomain.php',
        success: function (response) {
            if (response != 0) {
                var html = '<div class="col-md-6 col-sm-6"><table id="table4" class="table table-striped table-bordered"><thead><tr><th>URL</th><th>Number of Users</th></tr></thead><tbody>';
                response = JSON.parse(response);
                for (var i = 0; i < response.length; i++) {
                    var s = i + 1;
                    html+="<tr><td><a target='_blank' href='"+response[i].url+"'>"+response[i].url+"</a></td><td>"+response[i].users+"</td></tr>";
                }
                html+='</tbody></table></div>';
                $('#content').append(html);
                $('#table4').DataTable();
            }
        }
    });
    websitesbyeachuser();
}

function websitesbyeachuser(){
    $.ajax({
        type: 'GET',
        url: 'php/websitesbyeachuser.php',
        success: function (response) {
            if (response != 0) {
                var html = '<div class="col-md-6 col-sm-6"><table id="table5" class="table table-striped table-bordered"><thead><tr><th>Users</th><th>Number of Websites</th></tr></thead><tbody>';
                response = JSON.parse(response);
                for (var i = 0; i < response.length; i++) {
                    var s = i + 1;
                    html+="<tr><td><a href='mailto:"+response[i].user+"'>"+response[i].user+"<a></td><td>"+response[i].websites+"</td></tr>";
                }
                html+='</tbody></table></div>';
                $('#content').append(html);
                $('#table5').DataTable();
            }
        }
    });
}

function passwordscreen(){
    var html='<form id="changepasswordform" autocomplete="off" style="max-width:400px;margin-top: 20%"><div id="error" class="alert alert-danger"></div><div class="input-group input-group-lg"><span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span><input id="password" type="password" class="form-control" placeholder="New Password" required></div><br><div class="input-group input-group-lg"><span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span><input id="cpassword" type="password" class="form-control" placeholder="Confirm Password" required></div><br><div class="btn-group"><button id="changepassword" type="button" class="btn btn-primary btn-lg" onclick="checkpassword()">Change Password</button></div></form>';
    $('#content').html(html);
    $('#error').hide();
}

function checkpassword(){
    var password=$('#password').val();
    var cpassword=$('#cpassword').val();
    if(password =="" || cpassword ==""){
        $('#error').html("<strong>Please Enter your Password</strong>");
        $('#error').show();
        $('#password').val("");
        $('#cpassword').val("");
    }
    else if(password!=cpassword){
        $('#error').html("<strong>Passwords don't match</strong>");
        $('#error').show();
        $('#password').val("");
        $('#cpassword').val("");
    }
    else {
        $.ajax({
            type: 'POST',
            url: 'php/changeadminpassword.php',
            data:{password: password},
            success: function (response) {
                if(response==1){
                    $('#modal-title').html("Important Information");
                    $('#modal-body').html("Password Updated Sucessfully");
                    $('#myModal').modal('show');
                    userstats();
                }
            }
        });
    }
}

function showdataform(){
    $('#userstats').removeClass('active');
    $('#websitestats').removeClass('active');
    $('#systemstats').removeClass('active');
    $('#requestdata').addClass('active');
    var html='<form id="requestdataform" autocomplete="off" style="max-width:400px;margin-top: 10%"><div id="error" class="alert alert-danger"></div><textarea class="form-control" rows="10" id="requesteddata" placeholder="Specify the data you required..."></textarea><br><div class="btn-group" style="width:48%"><button type="button" class="btn btn-lg btn-primary btn-block" onclick="request()">Request Data</button></div>&nbsp;&nbsp;&nbsp;<div class="btn-group" style="width:48%"><button type="reset" class="btn btn-lg btn-primary btn-block">Reset</button></div></form>';
    $('#content').html(html);
    $('#error').hide();
}

function request(){
    var data = $('#requesteddata').val();
    if(data==""){
        $('#error').html("<strong>Specify the data you want to request</strong>");
        $('#error').show();
    }
    else {
        $.ajax({
            type: 'POST',
            url: 'php/requestdata.php',
            data:{data: data},
            success: function (response) {
                if(response==1){
                    $('#modal-title').html("Important Information");
                    $('#modal-body').html("Your Request has been submitted successfully");
                    $('#myModal').modal('show');
                    userstats();
                }
                else {
                    $('#error').html("<strong>Error in sending your request</strong>");
                    $('#error').show();
                    $('#requesteddata').val("")
                }
            }
        });
    }
}

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