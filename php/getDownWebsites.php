<?php
session_start();
include('connection.php');
//$email = $_SESSION['email'];
$myuserEmail=$_GET['userEmail'];
$query = "SELECT `currently_down`.`url`, TIMEDIFF( `currently_down`.`till` , `currently_down`.`start` ) AS downTime, `currently_down`.`status` FROM `currently_down` NATURAL JOIN `user_url` WHERE USER LIKE '%".$myuserEmail."%'";
$result = mysqli_query($conn, $query);
//echo mysqli_num_rows($result);
if (mysqli_num_rows($result) != 0) {
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    echo json_encode($rows, JSON_PRETTY_PRINT);
}
else {
    echo "NONE";
}
?>