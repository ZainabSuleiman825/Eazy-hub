<?php

if (isset($_POST['submit'])) {
	
	include_once 'comments.inc.php';


	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$subject = mysqli_real_escape_string($conn, $_POST['subject']);
	$comments = mysqli_real_escape_string($conn, $_POST['comments']);
	

	//Error handlers
	//Check for empty fields

	if (empty($username) || empty($subject) || empty($comments)) {
		header("Location: ../comments.php?comment=empty");
		exit();
	}else{
		
				$sql = "SELECT * FROM comments WHERE comments='$comments'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);

				if ($resultCheck > 0) {
					header("Location: ../comments.php?username=wrong user");
					exit();
				}else {
					
					//Insert the comments into database
					$sql = "INSERT INTO comments(username, subject, comments) VALUES ('$username', '$subject', '$comments');";
					mysqli_query($conn, $sql);
					header("Location: ../comments.php?signup=success");
				    exit();
				

			}

	}

} else {
	header("Location: ../comments.php");
	exit();
}
?>