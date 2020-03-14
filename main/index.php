<?php

include 'utility/util.php';

session_start();

$con = open_connection();

$stmt = $con->prepare('SELECT activation_code FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($activation_code);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='image/png' href='media/favicon.png' />
        <link rel='manifest' href='manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Home Page</title>
        <link href='style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body class='loggedin'>
        <nav class='navtop'>
            <div>
                <h1>Hua!</h1>
                <a href='profile'>Profile</a>
                <a href='authentication/calls/logout.php'>Logout</a>
            </div>
        </nav>
        <div>
            <h2>Welcome To Hua!</h2>
            <?php
                if ($activation_code == 'activated') {
                    echo '<p>Welcome mah guy, '.ucfirst($_SESSION['username']).'!</p>';
                } else {
                    echo '<p>An activation link was sent to your email, '.ucfirst($_SESSION['username']).'. Please activate your account!</p>';
                }
            ?>
        </div>
    </body>
</html>