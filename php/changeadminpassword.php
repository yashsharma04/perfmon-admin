<?php
/**
 * Created by PhpStorm.
 * User: Manish Bisht
 * Date: 6/15/2016
 * Time: 2:32 PM
 */
session_start();
include('connection.php');
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);
$query = "UPDATE `admin` SET `password` = '".$password."' WHERE `admin`.`email` = '".$_SESSION['email']."'";
if(mysqli_query($conn, $query)){
   echo 1;
}
else {
    echo 0;
}