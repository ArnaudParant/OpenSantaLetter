<?php

$path = dirname(__FILE__);
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/login.php";

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
  $errors = array();
  $username = sanitize(trim($_POST["username"]));
  $password = trim($_POST["password"]);

  //Perform some validation
  //Feel free to edit / change as required
  if($username == "")
  {
    $errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
  }
  if($password == "")
  {
    $errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
  }

  if(count($errors) == 0)
  {
    //A security note here, never tell the user which credential was incorrect
    if(!usernameExists($username))
    {
      $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
    }
    else
    {
      $userdetails = fetchUserDetails($username);
      //See if the user's account is activated
      if($userdetails["active"]==0)
      {
	$errors[] = lang("ACCOUNT_INACTIVE");
      }
      else
      {
	//Hash the password and use the salt from the database to compare the password.
	$entered_pass = generateHash($password,$userdetails["password"]);
	
	if($entered_pass != $userdetails["password"])
	{
	  //Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
	  $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
	}
	else
	{
	  //Passwords match! we're good to go'
	  
	  //Construct a new logged in user object
	  //Transfer some db data to the session object
	  $loggedInUser = new loggedInUser();
	  $loggedInUser->email = $userdetails["email"];
	  $loggedInUser->user_id = $userdetails["id"];
	  $loggedInUser->hash_pw = $userdetails["password"];
	  $loggedInUser->title = $userdetails["title"];
	  $loggedInUser->displayname = $userdetails["display_name"];
	  $loggedInUser->username = $userdetails["user_name"];
	  
	  //Update last sign in
	  $loggedInUser->updateLastSignIn();
	  $_SESSION["userCakeUser"] = $loggedInUser;
	  
	  //Redirect to user account page
	  header("Location: user");
	  die();
	}
      }
    }
  }
}

require_once("$path/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2><?= lang("NAV_LOGIN") ?></h2>
      <div id='left-nav'> <?php include("$path/common/left-nav.php") ?> </div>
      <div id='main'>

        <?= resultBlock($errors,$successes) ?>

        <div id='regbox'>
          <form name='login' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
            <p>
              <label><?= lang("USERNAME") ?>:</label>
              <input type='text' class="form-control" name='username' />
            </p>
            <p>
              <label><?= lang("PASSWORD") ?>:</label>
              <input type='password' class="form-control" name='password' />
            </p>
            <p>
              <label>&nbsp;</label>
              <input type='submit' class="btn btn-success" value='Login' class='submit' />
            </p>
          </form>
        </div>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
