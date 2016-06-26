<?php
/**
 * Created by PhpStorm.
 * User: Manish Bisht
 * Date: 6/13/2016
 * Time: 10:31 AM
 */
$url=$_GET['url'];
$newurl = str_replace(array('http://','https://'), '', $url);
$last = substr($url, -1);
if($last=='/'){
    $newurl=substr($newurl, 0, -1);
}
$ip=gethostbyname($newurl);
if($newurl==$ip){
    $ip="NA";
}
$rows = dns_get_record($newurl)[0];
$rows['ip']=$ip;
echo json_encode($rows, JSON_PRETTY_PRINT);
?>