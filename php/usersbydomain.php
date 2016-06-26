<?php
/**
 * Created by PhpStorm.
 * User: Manish Bisht
 * Date: 6/14/2016
 * Time: 3:43 PM
 */
include('connection.php');
$query = "SELECT `user_url`.`url` AS `url` , COUNT(`user_url`.`user`) AS `users` FROM `user_url` GROUP BY `user_url`.`url` ORDER BY `user_url`.url";
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
?>