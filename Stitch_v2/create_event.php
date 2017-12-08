<?php
  $signup_message = '';
  
  include "connect_db.php";
  session_start();
  $user = ""; $user_id = "";
  if(isset($_SESSION['login_user'])){
    $user = $_SESSION['login_user'];
    $user_id = $_SESSION['login_id'];
  }
  if(isset($_POST['submit_create'])) {
    connectToMySQLDatabase();
    //Retrieve data from form
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $month = (int) substr($date, 0,2);
    $day = (int) substr($date, 2,2);
    $year = (int) substr($date, 4,4);
    #echo $month,' ',$day,' ',$year,' ';
    $table_name = 'events';
    //Insert data into table if it doe not already exist
    $query = "SELECT * from $table_name where name ='$name'";
    $result = mysqli_query($conn, $query);
    #var_dump($result);
    if(!$result) {
      $signup_message = "Error accessing table $table_name: ".mysqli_error($conn);
    } 
    else if (mysqli_num_rows($result) > 0) {
      $signup_message = "There is already an event with this name: $name";
    } else {
      $query = "INSERT INTO $table_name (name,day,month,year,description) 
          VALUES ('$name','$day','$month','$year','$description')";
      $result = mysqli_query($conn, $query);
      if(!$result) {
        $signup_message = "Error inserting new event into the database: ".mysqli_error($conn);
      } else {
         $signup_message = "Event created successfully!";
        #header("location: event_page.php"); // Redirecting to events page
      }
    }
    mysqli_close($conn);
  }
?>
<html>
<!--- Google Material Design API-->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.green-amber.min.css">
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<head>
  <style>
  .div1 {
    margin-left: 40px;
  }
</style>
<script type="text/javascript">
  function validateEventForm() {
    //validate date
    var date = document.getElementById("date").value;
    if(date.length != 8) {
      alert('Date not valid! (must contain exactly 8 numbers: mmddyyy');
      return false;
    } 
    var month = parseInt(date.substring(0,2));
    if(month < 1 || month > 12) {
      alert('Date not valid! (Invalid month)');
      return false;
    }
    var day = parseInt(date.substring(2,4));
    if(day < 1 || day > 31) {
      alert('Date not valid! (Invalid day)');
      return false;
    }
    var year = parseInt(date.substring(4,8));
    if(year < 2017) {
      alert('Date not valid! (must be a future date)');
      return false;
    }
    return true;
  }
</script>
<class="mdl-layout mdl-js-layout">
  <header class="mdl-layout__header mdl-layout__header--scroll">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span id="header" class="mdl-layout-title">Stitch</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation -->
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php">Home</a>
        <a class="mdl-navigation__link" href="event_page.php">View Events</a>
        <a id="profile" class="mdl-navigation__link" href="about.html">About</a>
        <a  id="sign_in" class="mdl-navigation__link" href="sign_in.php">Sign In</a>
      </nav>
    </div>
  </header>
  <main class="mdl-layout__content">
    <div class="page-content"><!-- Your content goes here --></div>
  </main>
</div>
</head>
<body>
  <div class="div1">
  <h1>Create a New Event</h1>
    
    <!-- Simple Textfield -->
    <form action="create_event.php" method="post" onsubmit="return validateEventForm()">
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="name" name="name">
        <label class="mdl-textfield__label" for="name">Event name </label>
      </div>
      <br>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="date" name="date">
        <label class="mdl-textfield__label" for="date">Event Date (mmddyyyy) </label>
        <span class="mdl-textfield__error">Input is not a valid number!</span>
      </div>
      <br>
      <div class="mdl-textfield mdl-js-textfield">
        <textarea class="mdl-textfield__input" type="text" rows= "3" id="description" name="description"></textarea>
        <label class="mdl-textfield__label" for="description">Description </label>
      </div>
      <br>
       <!-- Colored FAB button -->
    <!-- Accent-colored raised button -->
    <button type="submit" id="submit_create" name="submit_create" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
      Create
    </button>
    <br>
    <div><?php echo $signup_message ?> </div>
    </form>
     
  </div>
</body>
<script type="text/javascript" src="utility.js"></script>
<script type="text/javascript">
  var user = <?php echo json_encode($user); ?>;
  var user_id= <?php echo json_encode($user_id); ?>;
  if(!checkUserLoggedIn(user)) {
    //
  }
</script>
</html>