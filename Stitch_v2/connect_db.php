<?php
	$dbname = "stich_db1";
	$servername = "localhost";
	$username = "root";
	$password_root = "";
	// Create connection
	$conn = NULL;
	$emails = Array();
	$event_data = Array();
	$event_names = Array();
	$event_dates = Array();
	$event_desc = Array();
	$user_events = Array();

	connectToMySQLDatabase();
	
	function extractEmailsFromDB() {
		global $conn, $emails, $dbname;
		$result = mysqli_query($conn,"SELECT username FROM user_login_info");
		if(!$result) {
			die("Error with mysqli query: "+mysqli_error($conn));
		}
		while($row=mysqli_fetch_assoc($result)) {
			$emails[] = $row['username']."@gmu.edu";
		}
	}

	function extractEventData() {
		global $dbname, $conn, $event_data, $event_names, $event_dates, $event_desc;
		$result = mysqli_query($conn,"SELECT * FROM events");
		if(!$result) {
			return;
		}
		// die("Error with mysqli query"); }
		// $result = mysqli_fetch_all($result);
		while($row=mysqli_fetch_assoc($result)) {
			$event_data[] = $row;
			$event_names[] = $row['name'];
			$event_desc[] = $row['description'];
		}

	}

	function extractUserEventData($user_id) {
		global $dbname, $conn, $user_events;
		$result = mysqli_query($conn,"SELECT event_id FROM user_events WHERE user_id='$user_id'");
		if(!$result) {
			die("Error with mysqli query: "+mysqli_error($conn));
		} else {
			// die("Error with mysqli query"); }
			// $result = mysqli_fetch_all($result);
			while($row=mysqli_fetch_assoc($result)) {
				$user_events[] = $row['event_id'];
			}
		}
	}

	function connectToMySQLDatabase() {
		global $conn, $dbname, $servername, $username, $password_root;
		$conn = mysqli_connect($servername,$username,$password_root);
		//Check connection
		if (!$conn) {
			die("Connection failed: ".mysqli_connect_error());
		}
		// Create database if it does not exist
		$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
		if (!mysqli_query($conn, $sql)) {
			die("Error creating database: ".mysqli_error($conn).'<br>');
		}
		//Select database
		if (!mysqli_select_db($conn,$dbname)) {
			die("Connection to database failed: ".mysqli_error($conn));
		} 
	}
?>