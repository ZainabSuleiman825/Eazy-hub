<?php


if (isset($_POST['submit'])) {

	include 'dbh.php';

	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	//error handlers
	//check if inputs are empty

	if (empty($uid) || empty($pwd)) {
		
	}else{
		$sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);

		if ($resultCheck < 1) {
			header("Location: ../login.html?login=error");
			exit();
		}else{
			if ($row = mysqli_fetch_assoc($result)) {
				//de-hashing the password

				$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
				if ($hashedPwdCheck == false) {
					header("Location: ../index.php?login=error");
					exit();
				}elseif ($hashedPwdCheck == true) {
					//Log in the user here
					$_SESSION['id'] = $row['user_id'];
					$_SESSION['first'] = $row['user_first'];
					$_SESSION['last'] = $row['user_last'];
					$_SESSION['email'] = $row['user_email'];
					$_SESSION['uid'] = $row['user_uid'];

					header("Location: ../index.html?login=success");
					exit();
				}
			}
		}
	}
}else {
	header("Location: ../login.html?login=error");
	exit();
}