<?php 
	include "connect_db.php";
	session_start();
	$login_error = ''; 
		
	if(isset($_POST['submit_login'])) {
		$email = $_POST['email_login'];
		$password = $_POST['password_login'];
		
		connectToMySQLDatabase();	
		$username = substr($email,0,strrpos($email,"@"));
		$query = "SELECT * from user_login_info where username='$username'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) == 1) {
			$row=mysqli_fetch_array($result);
			if($password == $row['password']) {
				//Login succesful! time to set session :)
				$_SESSION['login_user'] = $row['username']; //initializing session
				$_SESSION['login_id'] = $row['id'];
				header("location: event_page.php"); // Redirecting to profile page
			} else {
				$login_error = 'Incorrect password!';
			}
		} else {
			$login_error = "Invalid e-mail address!";
		}
		mysqli_close($conn);
	}
?>