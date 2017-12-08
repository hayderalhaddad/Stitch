function checkUserLoggedIn(username) 
{
	if(username.length > 0) {
    document.getElementById("header").innerHTML += ": "+username;
    document.getElementById("sign_in").innerHTML = "Log out";
    document.getElementById("sign_in").href = "logout.php";
	  document.getElementById("profile").innerHTML = "My Profile";
    document.getElementById("profile").href = "user_profile.php";
  } 
  return username.length > 0;
}