<?php

include 'util.php';

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ./');
    exit;
}

$con = open_connection();

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

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
        <link href='./css/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <nav>
            <div>
                <h1>Website Title</h1>
                <a href='./home'>Home</a>
                <a href='./logout'>Logout</a>
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