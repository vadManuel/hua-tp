<?php

include '../../utility/util.php';

session_start();

$con = open_connection();

if ( !isset($_POST['email'], $_POST['password']) ) {
	header('Location: ../signin');
	exit;
}

if ($stmt = $con->prepare('SELECT user_id, password, username FROM users WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    
	$stmt->store_result();
	if ($stmt->num_rows > 0) {  // check if account actually exists
		$stmt->bind_result($id, $password, $username);
        $stmt->fetch();
        
		if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();

            unset($_SESSION['display_error']);
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['username'] = $username;
            $_SESSION['id'] = $id;

            header('Location: ../../');
		} else {
            $_SESSION['display_error'] = 'Wrong password. Try again or click Forgot password to reset it.';
            header('Location: ../signin');
		}
	} else {
        $_SESSION['display_error'] = 'Couldn\'t find your Hua! Account';
        header('Location: ../signin');
	}

	$stmt->close();
} else {
    echo 'Error building login statement.';
}
