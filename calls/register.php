<?php

include '../utility/util.php';
include '../utility/buildMessage.php';

session_start();

$con = open_connection();

if (!isset($_POST['username'], $_POST['password'], $_POST['email'])
    || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])
    ) {
    // this shouldn't really happen unless someone goes directly to /register.php
    header('Location: ../../signup');
    exit;
}

// Checking if email is taken
if ($stmt = $con->prepare('SELECT user_id, password FROM users WHERE email = ?')) {

    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // TODO: Pass error to screen
        echo 'Account already exists!';
        
        
    } else {
        if ($stmt = $con->prepare('INSERT INTO users (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $activation_code = uniqid();
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $activation_code);

            $stmt->execute();
            $id = $con->insert_id;
            
            session_regenerate_id();

            $_SESSION['display_error'] = null;
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['id'] = $id;

            header('Location: ../index');
            
        } else {
            echo 'Error building registration statement';
        }
    }
    $stmt->close();
} else {
    echo 'Error building user exists check statement.';
}

$con->close();