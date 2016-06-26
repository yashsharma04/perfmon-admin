<?php
session_start();
include('connection.php');
$email = $_SESSION['email'];
$query = "SELECT `user_details`.`email` AS `userEmail`, `user_details`.`name` AS `name`, DATE_FORMAT( `user_details`.`account_created_on`, '%d %b %Y' ) AS `joinedDate`, DATE_FORMAT( `user_details`.`account_created_on`, '%h:%i %p' ) AS `joinedTime`, DATE_FORMAT( `user_details`.`last_modification_date`, '%d %b %Y' ) AS `last_updatedDate`, DATE_FORMAT( `user_details`.`last_modification_date`, '%h:%i %p' ) AS `last_updatedTime`, COUNT(`user_url`.`url`) AS `no_of_sites_down` FROM `user_details` LEFT JOIN `user_url` ON `user_details`.`email` = `user_url`.`user` GROUP BY `user_details`.`email` ORDER BY `user_details`.`name`";
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