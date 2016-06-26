<?php
/**
 * Created by PhpStorm.
 * User: Manish Bisht
 * Date: 6/10/2016
 * Time: 5:30 PM
 */
session_start();
session_unset();
session_destroy();
if(isset($_SESSION['email'])){
    echo 0;
}
else{
    echo 1;
}
?>