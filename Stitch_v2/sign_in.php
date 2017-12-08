<?php
  include('login.php'); // Includes Login Script
  
  if(isset($_SESSION['login_user'])){
    header("location: index.php");
  }

  $array = array('apple','orange'); 
  $dbname = 'stich_db1';
  extractEmailsFromDB();
  //echo json_encode($emails);
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
<script type=text/javascript>
  
  function validateLoginForm() {
    var email = document.getElementById("email_login").value;
    var password = document.getElementById("password_login").value;
    if(getCookie(email) != password && confirm("Save password?")) {
      setCookie(email,password,1/24)
    }
    return true;
  }

  function setCookie(cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
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
        <a id="profile" class="mdl-navigation__link" id="profile" href="about.html">About</a>
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
  <h1>Sign in </h1>
    
    <!-- Simple Textfield -->
    <form action="sign_in.php" method="post" onsubmit="return validateLoginForm()"> 
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input"  type="text" id="email_login" name="email_login" required autocomplete="on">
        <label class="mdl-textfield__label" for="email_login">username@gmu.edu</label>
      </div>
      <br>
    <!-- Numeric Textfield -->
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" id ="password_login" name="password_login">
        <label class="mdl-textfield__label" for="password_login">password</label>
        <span class="mdl-textfield__error">Input is not a number!</span>
      </div>
      <br>
        <!-- Colored FAB button -->
    <!-- Accent-colored raised button -->
    <button type="submit" name="submit_login" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
      Log In
    </button>
    <br> 
    Don't have an account? <a href="sign_up.php">Click here </a> to sign up! 
    <br> 
    <div> <?php echo $login_error ?> </div>
    </form>
    
    
  </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="http://autocompletejs.com/releases/0.3.0/autocomplete-0.3.0.min.js"></script>
  <link href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="Stylesheet"></link>
  <script
        src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
  <script type="text/javascript">
    var email_array = <?php echo json_encode($emails); ?>;
    $("#email_login").autocomplete({
        source:email_array,
        select:function(event,ui) {
          var email = ui.item.label;
          var password = getCookie(email);
          if(password != "") {
            $("#password_login").val(password);
          }
        }
      });
  </script>
</body>
</html>