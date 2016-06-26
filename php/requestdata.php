<?php
/**
 * Created by PhpStorm.
 * User: Manish Bisht
 * Date: 6/20/2016
 * Time: 4:40 PM
 */
session_start();
include('connection.php');
$name=$_SESSION['name'];
$email = $_SESSION['email'];
$data =$_POST['data'];
$query = "INSERT INTO `requested_data` (`name`, `email`, `data`) VALUES ('".$name."', '".$email."', '".$data."')";
if(mysqli_query($conn, $query)){
    echo 1;
}
else {
    echo 0;
}