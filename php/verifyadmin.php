<?php
/**
 * Created by PhpStorm.
 * User: Manish Bisht
 * Date: 6/10/2016
 * Time: 10:38 AM
 */
include('connection.php');
$email = $_POST['email'];
$password = $_POST['password'];
$query = "SELECT * FROM admin WHERE email='" . $email . "'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) != 0) {
    $result = mysqli_fetch_array($result);
    session_start();
    if (password_verify($password, $result['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $result['name'];
        $_SESSION['lastlogin'] = $result['last_login'];
        echo 1;
        $query = "UPDATE `admin` SET `last_login` = NOW() WHERE `admin`.`email` = '" . $_SESSION['email'] . "'";
        $result = mysqli_query($conn, $query);
    } else {
        echo 0;
    }
} else {
    echo 0;
}