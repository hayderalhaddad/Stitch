<?php
  include "connect_db.php";
  session_start();
  $user = ""; $user_id = "";
  if(isset($_SESSION['login_user'])){
    $user = $_SESSION['login_user'];
    $user_id = $_SESSION['login_id'];
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
<class="mdl-layout mdl-js-layout">
  <header class="mdl-layout__header mdl-layout__header--scroll">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title" id="header">Stitch</span>
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
  <div class="div1" id="div1">
  <h1>Stitching GMU Together</h1>
  <h4>Stitch is an event management system to help you connect with other students at George Mason University.</h4>
  <h5> As a commuter school, many people feel left out of the loop. </h5>
  <h5> We've created a way for you to include others in your events, no matter how formal or informal.</h5>
      <!-- Colored FAB button -->
    <!-- Accent-colored raised button -->
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" id="get-started" onclick="window.location.href='sign_up.php'">
      Get Started
    </button>
  </div>
</body>
<script type="text/javascript" src="utility.js"></script>
<script type="text/javascript">
  var user = <?php echo json_encode($user); ?>;
  var user_id= <?php echo json_encode($user_id); ?>;
  if(checkUserLoggedIn(user)) {
    document.getElementById("get-started").remove();
	document.getElementById("div1").innerHTML = "<h1> Hello, " + user + "!</h1>"; 
	document.getElementById("div1").innerHTML += "<h4>Check out what other students are doing and join some events.</h4>";
	joinEvents = "<button onClick=\"window.location.href=\'event_page.php\'\"class=\"mdl-button mdl-js-button mdl-button--raised mdl-button--accent \">View Events</button>";
	document.getElementById("div1").innerHTML += joinEvents;
  }
</script>
</html>