<?php
  $signup_message = '';
  include "connect_db.php";
  connectToMySQLDatabase();
 
  session_start();
  $user = "";
  if(isset($_SESSION['login_user'])){
    $user = $_SESSION['login_user'];
    $user_id = $_SESSION['login_id']; //get user_id
  }
  $table_name = 'user_events';
  $event_id = $_POST['event_id'];
  $query = "SELECT * from $table_name where user_id ='$user_id' and event_id='$event_id'";
  $result = mysqli_query($conn, $query);
if(!$result) {
      $message = "Error accessing table $table_name: ".mysqli_error($conn);
  } else if (mysqli_num_rows($result) > 0)
  {
    $message = "You have already joined this event";
  } else {
    $query = "INSERT INTO $table_name (user_id,event_id) 
          VALUES ('$user_id','$event_id')";
  
    $result = mysqli_query($conn, $query);
    if(!$result) {
      die("error in query: ".mysqli_error($conn));
    } else {
      $message = "Event joined successfully!";
    }
  }
  
  mysqli_close($conn);
  return "php message testing";
?>  