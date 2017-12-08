<?php
	session_start();
	if(session_destroy()) // Destroying All Sessions
	{
		header("Location: sign_in.php"); // Redirecting To Home Page
	}
?>