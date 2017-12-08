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
.demo-card-wide.mdl-card {
  width: 300px;
  margin-left: 50px;
}
.demo-card-wide > .mdl-card__title {
  color: #fff;
  height: 176px;
  background: url('http://i0.kym-cdn.com/entries/icons/original/000/013/564/doge.jpg') center / cover;
}
.demo-card-wide > .mdl-card__menu {
  color: #fff;
}
.event-check {
  color: green;
}
.events-heading {
	margin-left: 50px;
}
.join-button {
	margin-left: 70px;
}
.mdl-grid {
	margin-bottom: 50px;
}
.message {
  margin-left: 50px;
}
</style>

<class="mdl-layout mdl-js-layout">
  <header class="mdl-layout__header mdl-layout__header--scroll">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span id="header" class="mdl-layout-title" href="index.html" id="header">Stitch</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation -->
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php">Home</a>
        <a class="mdl-navigation__link" href="event_page.php">View Events</a>
        <a id="profile" class="mdl-navigation__link" id="profile" href="about.html">About</a>
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
<div id="debug"> 
</div>
<div>
	<div class="events-heading">
	<h1>Events
	<button class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored add-event-button" onclick="window.location.href='create_event.php'">
	<i class="material-icons">add</i>
	</button>
	</h1>
	</div>
	<div id="events-body"> 	</div>
  <div class="message" id="message"></div>
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
  //console.log(user);
  checkUserLoggedIn(user);
  if(!checkUserLoggedIn(user)) {
    document.getElementById("message").innerHTML = "<h4>Must be logged in with valid Mason credentials to view Events!</h4>";
  }
  
  var event_data = <?php echo json_encode($event_data); ?>;
  var event_ids = <?php echo json_encode($user_events); ?>;



  var current_div = 0;
  console.log(event_data);
  for(obj in event_data) {
	console.log(obj);
	if(obj % 4 === 0 || current_div === 0) {
		current_div += 1;
		document.getElementById("message").innerHTML += "<div id=\"event-div-" + current_div + "\" class=\"mdl-grid\"></div>";
	}
	cardDiv = "<div class=\"mdl-cell mdl-cell--3-col mdl-cell--1-col-phone\" id=\"event-card-" + obj + "\"> <div class=\"demo-card-wide mdl-card mdl-shadow--2dp\"> <div class=\"mdl-card__title\"> </div> <div class=\"mdl-card__supporting-text\" id=\"event-text-" + obj + "\"> </div> <div class=\"mdl-card__actions mdl-card--border\" id=\"event-actions-" + obj + "\"> <button id=\"expand-btn-" + obj + "\" onClick=\"showDetails(this)\"class=\"mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect \" value=\"" + obj + "\"> <i class=\"material-icons\">expand_more</i></button></div> <div class=\"mdl-card__menu\"> <button class=\"mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect\"> <i class=\"material-icons\">share</i> </button> </div> </div> </div>";
	document.getElementById("event-div-" + current_div).innerHTML += cardDiv;
	cardText = "event-text-" + obj;
	document.getElementById(cardText).innerHTML += event_data[obj].name + " | " + event_data[obj].month + "/" + event_data[obj].day + "/" + event_data[obj].year;
  }
  
  function showDetails(element) {
	//console.log("Card number: " + element.value);
	document.getElementById("expand-btn-" + element.value).style.display = 'none';
	expandLess = "<button id=\"expand-less-btn-" + element.value + "\" onClick=\"hideDetails(this)\"class=\"mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect \" value=\"" + element.value + "\"> <i class=\"material-icons\">expand_less</i></button>";
	document.getElementById("event-actions-" + element.value).innerHTML += "Details:" + '<br>' + event_data[element.value].description + '<br><br>' + expandLess + "<button id=\"join-"+element.value+"\" value=\""+element.value+"\"onClick=\"joinEvent("+element.value+")\"class=\"join-button mdl-button mdl-js-button mdl-button--accent mdl-button--raised mdl-js-ripple-effect\"> Join </button>";
    //console.log("join-"+element.value);
    if($.inArray(event_data[element.value].id,event_ids) != -1) {
      document.getElementById("join-"+element.value).disabled = true;
    }
  }
  
  function hideDetails(element) {
	console.log(element.value);
	expandMore = "<button id=\"expand-btn-" + element.value + "\" onClick=\"showDetails(this)\"class=\"mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect \" value=\"" + element.value + "\"> <i class=\"material-icons\">expand_more</i></button>";
	document.getElementById("event-actions-" + element.value).innerHTML = expandMore;
  }

  for(i in event_data) {
    if($.inArray(event_data[i].id,event_ids) != -1) {
      //current user has joined this event
      //console.log("current user has joined this event: "+event_data[i].name);
    }
  }

  function joinEvent(val){
    console.log(val);
    // Make sure to only add the check mark once
    if(!document.getElementById("event-check-" + val)) {
      document.getElementById("event-text-" + val).innerHTML += "<div class=\"event-check\" id=\"event-check-" + val + "\"> &#10004 Event successfully joined</div>";
    }
    console.log(event_data[val].id);
    var eventId = event_data[val].id;
    $.ajax({
      type: "POST",
      url: "join_event.php",
      data: { event_id: event_data[val].id}
    }).done(function( msg ) {
      console.log("event joined! " + msg);
      $("#message").innerHTML = "Succesfsully joined event! " + msg;
      document.getElementById("join-"+val).disabled = true;
      if($.inArray(eventId,event_ids) == -1) {
        event_ids.push(eventId);
      }
  });    
  }
</script> 
</body> 
</html>