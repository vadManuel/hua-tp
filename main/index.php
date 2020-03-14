<?php

include 'util.php';

session_start();

// redirect to login if not authed
if (!isset($_SESSION['loggedin'])) {
    header('Location: ./');
    exit;
}

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
        <title>Home Page</title>
        <link href='./css/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body class='loggedin'>
        <nav class='navtop'>
            <div>
                <h1>Hua!</h1>
                <a href='./profile'>Profile</a>
                <a href='./logout'>Logout</a>
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