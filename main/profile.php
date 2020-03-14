<?php

include 'utility/util.php';

session_start();

$con = open_connection();

$stmt = $con->prepare('SELECT password, email, activation_code FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $activation_code);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Profile Page</title>
        <link href='style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <nav>
            <div>
                <h1>Hua</h1>
                <a href='home'>Home</a>
                <a href='logout'>Logout</a>
            </div>
        </nav>
        <div>
            <h2>Profile Page</h2>
            <div>
                <p>Your account details are below:</p>
                <table>
                    <tr>
                        <td>ID:</td>
                        <td><?=$_SESSION['id']?></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><?=$_SESSION['username']?></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><?=$password?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?=$email?></td>
                    </tr>
                    <tr>
                        <td>Activation Code:</td>
                        <td><?=$activation_code?></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>