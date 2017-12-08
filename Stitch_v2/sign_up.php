<?php
  $signup_message = '';
  $success_message = '';
  include "connect_db.php";
  if(isset($_POST['submit_signup'])) {
    //Retrieve data from form
    #$firstname = $_POST["firstname"];
    #$lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = substr($email,0,strrpos($email,"@"));
    $password = $_POST['password'];
    $password_encrypted = md5($_POST['password']);
    $table_name = 'user_login_info';
    //Insert data into table if it doe not already exist
    $query = "SELECT * from $table_name where username ='$username'";
    $result = mysqli_query($conn, $query);
    #var_dump($result);
    if(!$result) {
      $signup_message = "Error accessing table $table_name: ".mysqli_error($conn);
    } else if (mysqli_num_rows($result) > 0) {
      $signup_message = "There is already an acocunt associated with this e-mail address: $email";
    } else {
      $query = "INSERT INTO $table_name (username,password) 
           VALUES ('$username','$password')";
    $result = mysqli_query($conn, $query);
    if(!$result) {
      $signup_message = "Error inserting user info into database: ".mysqli_error($conn);
    } else {
      $signup_message = "";
      $success_message = "Sign up successful!";
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
  #error {
    color: red;
  }
  #success {
    color: green;
  }
</style>
<script type="text/javascript">
  function validateSignupForm() {
    //validate email address
    if(!validateEmail(document.getElementById("email").value))
    {
      alert("You have entered an invalid/non-Mason email address!");
      return false;
    }
    //validate password
    var password1 = document.getElementById("password").value;
    var password2 = document.getElementById("confirm_password").value;
    if(password1 != password2) {
      alert("Passwords do not match!");
      return false;
    }
    if(!checkPassword(password1)) {
      alert('Invalid password! Must be  between 6 to 20 characters with at least one numeric digit, one uppercase, and one lowercase letter');
      return false;
    }
    return true;
  }
  
  function validateEmail(email_address)   {
    var email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return email_regex.test(email_address) && email_address.includes("@gmu.edu");
  }  
  
  function checkPassword(password) {
    var passw_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;  
    return password.match(passw_regex);
    //return true; //for debugging purposes
  }
</script>
<class="mdl-layout mdl-js-layout">
  <header class="mdl-layout__header mdl-layout__header--scroll">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title">Stitch</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation -->
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php">Home</a>
        <a class="mdl-navigation__link" href="event_page.php">View Events</a>
        <a class="mdl-navigation__link" id="profile" href="about.html">About</a>
        <a id="sign_in" class="mdl-navigation__link" href="sign_in.php">Sign In</a>
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
  <h1>Create an Account</h1>
  <h5> Sign up with your university email to see what's going on around campus. </h5>
    
    <!-- Simple Textfield -->
    <form action="sign_up.php" method="post" onsubmit="return validateSignupForm()">
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="email" name="email">
        <label class="mdl-textfield__label" for="email">GMU email</label>
      </div>
      <br>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" id="password" name="password">
        <label class="mdl-textfield__label" for="password">password</label>
        <span class="mdl-textfield__error">Input is not a valid password</span>
      </div>
      <br>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" id="confirm_password" name="confirm_password">
        <label class="mdl-textfield__label" for="confirm_password">confirm password</label>
        <span class="mdl-textfield__error">Input is not a valid password</span>
      </div>
      <br>
    <div id="error"><?php echo $signup_message ?> </div>
    <div id="success"><?php echo $success_message ?> </div>
    <!-- Colored FAB button -->
    <!-- Accent-colored raised button -->
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" id="submit_signup" name="submit_signup" type="submit">
      Register
    </button>
    <br>
    </form>
  </div>
</body>
</html>