<?php

function console_log($string, $encode=TRUE) {
    if ($encode) {
        echo '<script>console.log('.json_encode($string, JSON_HEX_TAG).');</script>';
    } else {
        echo '<script>console.log("'.$string.'");</script>';
    }
    
    return;
}

function open_connection() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'rootpass';
    $DATABASE_NAME = 'test';

    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    return $con;
}
