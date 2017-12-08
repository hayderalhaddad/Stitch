<?php
  include "connect_db.php";
  session_start();
  $user = ""; $user_id = "";
  if(isset($_SESSION['login_user'])){
    $user = $_SESSION['login_user'];
    $user_id = $_SESSION['login_id'];
    extractEventData();
    extractUserEventData($user_id);
  }
  
?>
<html>
<!--- Google Material Design API-->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.green-amber.min.css">
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<head>
<style>
.profile-body {
	margin-left: 50px;
}
</style>
<class="mdl-layout mdl-js-layout">
  <header class="mdl-layout__header mdl-layout__header--scroll">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title" href="index.html" id="header">Stitch</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation -->
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php">Home</a>
        <a class="mdl-navigation__link" href="event_page.php">View Events</a>
        <a class="mdl-navigation__link" id ="profile" href="about.html">About</a>
        <a id="sign_in" class="mdl-navigation__link" href="sign_in.php">Sign In</a>
      </nav>
    </div>
  </header>
  <main class="mdl-layout__content">
    <div id="page-content" class="page-content">
      <!-- Your content goes here -->
    </div>
  </main>
</div>
</head>
<body>
<div class="profile-body" id="profile-body">
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="http://autocompletejs.com/releases/0.3.0/autocomplete-0.3.0.min.js"></script>
  <link href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="Stylesheet"></link>
  <script
        src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="utility.js"></script>
<script type="text/javascript">
	var user = <?php echo json_encode($user); ?>;
	var user_id= <?php echo json_encode($user_id); ?>;
	if(!checkUserLoggedIn(user)) {
      document.getElementById("message").innerHTML = "Must be logged in with valid Mason credentials to view profile!";
	}
	document.getElementById("profile-body").innerHTML += "<h2>" + user + "</h2>";
	document.getElementById("profile-body").innerHTML += "<h4>George Mason University</h4><br /><br /><br />";
	document.getElementById("profile-body").innerHTML += "<h3>" + user + " has joined these events: <br /></h3>";	
	
    var event_data = <?php echo json_encode($event_data); ?>;
    var event_ids = <?php echo json_encode($user_events); ?>;
	
	for(i in event_data) {
      if($.inArray(event_data[i].id,event_ids) != -1) {
        //current user has joined this event
        //console.log("current user has joined this event: "+event_data[i].name);
		document.getElementById("profile-body").innerHTML += "<h5>" + event_data[i].name + "</h5>";
      }
    }
</script>
</body>
</html>