<?php

include '../../utility/util.php';
$con = open_connection();

if (isset($_GET['email'], $_GET['code'])) {

	if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
		$stmt->execute();
        $stmt->store_result();
        
		if ($stmt->num_rows > 0) {
			if ($stmt = $con->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
				// Sets activation_code to activated
				$newcode = 'activated';
				$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
                
				echo 'Your account is now activated, go ahead and login!<br><a href="/">Login</a>';
			}
		} else {
			echo 'The account is already activated or doesn\'t exist!';
		}
	}
}
?>