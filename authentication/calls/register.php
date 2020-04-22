<?php

include '../../utility/util.php';

session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='image/png' href='../../media/favicon.png' />
        <link rel='manifest' href='../../manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Account Creation</title>
        <link href='../../style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body class='outer'>
        <div class='middle'>
            <div class='d-flex flex-column align-items-center justify-content-center flex-nowrap' style='height:100%'>
                <!-- Judge the professor for not letting me use bootstrap -->
                <a href='../../'>
                    <img style='height:140px;' src='../../media/hua_logo.png' alt='' />
                </a>
                <!-- <div class='fs-14' style='padding-top:1rem;color:#8F9BB3;font-weight:bold;'>Sign In</div> -->
                <a href='../signin.php'>
                <?php
                    $con = open_connection();

                    if (!isset($_POST['username'], $_POST['password'], $_POST['email'])
                        || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])
                        ) {
                        // this shouldn't really happen unless someone goes directly to /register.php
                        header('Location: ../signup');
                        exit;
                    }

                    // Checking if email is taken
                    if ($stmt = $con->prepare('SELECT user_id, password FROM users WHERE email = ?')) {

                        $stmt->bind_param('s', $_POST['email']);
                        $stmt->execute();
                        $stmt->store_result();
                        
                        if ($stmt->num_rows > 0) {
                            // TODO: Pass error to screen
                            echo '<p class="auth-input" style="text-align:center; font-weight:bold; font-size: 36px">'. 'Account already exists! <br><br> Please Sign In.'.'</p>';
                        } else {
                            if ($stmt = $con->prepare('INSERT INTO users (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                                $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $activation_code);
                                $stmt->execute();

                                $_SESSION['loggedin'] = TRUE;
                                $_SESSION['username'] = $_POST['username'];
                                $_SESSION['id'] = $con->insert_id;

                                header('Location: ../../');
                            } else {
                                echo 'Error building registration statement';
                            }
                        }
                        $stmt->close();
                    } else {
                        echo 'Error building user exists check statement.';
                    }

                    $con->close();
                ?>
                </p>
                <!-- Account Already Exists! Please <a href='../signin.php'>Sign In</a>. -->
            </div>
        </div>
    </body>
</html>
