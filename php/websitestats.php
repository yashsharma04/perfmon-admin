<?php
/**
 * Created by PhpStorm.
 * User: Manish Bisht
 * Date: 6/10/2016
 * Time: 12:18 PM
 */
include('connection.php');
$query = "SELECT `user_url`.`url` AS `url`, DATE_FORMAT(`user_url`.`date`, '%d %b %Y') AS `date` ,DATE_FORMAT(`user_url`.`date`, '%h:%i %p') AS `time`, `user_url`.`user` AS `user`, ROUND(((SUM(`down_history`.`till` - `down_history`.`start`)) / (NOW() - `user_url`.`date`))*100, 2) AS `downpercent` FROM `user_url`,`down_history` WHERE `user_url`.`url`=`down_history`.`url` GROUP BY `user_url`.`url`";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) != 0) {
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    echo json_encode($rows, JSON_PRETTY_PRINT);
}
else {
    echo 0;
}
//print_r(dns_get_record("google.co.in"));
?>