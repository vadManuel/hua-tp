<?php

function console_log($string, $encode=TRUE) {
    if ($encode) {
        echo '<script>console.log('.json_encode($string, JSON_HEX_TAG).');</script>';
    } else {
        echo '<script>console.log("'.$string.'");</script>';
    }
}

function open_connection() {

    // connection to OG AWS server
    $DATABASE_HOST = 'ec2-3-134-76-37.us-east-2.compute.amazonaws.com:3306';
    $DATABASE_USER = 'actor';
    $DATABASE_PASS = '1UIF2g0IdQfAl4Uf';
    $DATABASE_NAME = 'hua';
    
    
    // $DATABASE_HOST = 'localhost';
    // $DATABASE_USER = 'root';
    // $DATABASE_PASS = 'rootpass';
    // $DATABASE_NAME = 'test';

    if ($con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME)) {
        return $con;
    } else {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
}

?>