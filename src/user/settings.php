<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/user/settings.php";

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if(!empty($_POST))
{
  $errors = array();
  $successes = array();
  $password = $_POST["password"];
  $password_new = $_POST["passwordc"];
  $password_confirm = $_POST["passwordcheck"];
  $email = $_POST["email"];
  
  //Perform some validation
  //Feel free to edit / change as required
  
  //Confirm the hashes match before updating a users password
  $entered_pass = generateHash($password,$loggedInUser->hash_pw);
  
  if (trim($password) == ""){
    $errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
  }
  else if($entered_pass != $loggedInUser->hash_pw)
  {
    //No match
    $errors[] = lang("ACCOUNT_PASSWORD_INVALID");
  }	
  if($email != $loggedInUser->email)
  {
    if(trim($email) == "")
    {
      $errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
    }
    else if(!isValidEmail($email))
    {
      $errors[] = lang("ACCOUNT_INVALID_EMAIL");
    }
    else if(emailExists($email))
    {
      $errors[] = lang("ACCOUNT_EMAIL_IN_USE", array($email));	
    }
    
    //End data validation
    if(count($errors) == 0)
    {
      $loggedInUser->updateEmail($email);
      $successes[] = lang("ACCOUNT_EMAIL_UPDATED");
    }
  }
  
  if ($password_new != "" OR $password_confirm != "")
  {
    if(trim($password_new) == "")
    {
      $errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
    }
    else if(trim($password_confirm) == "")
    {
      $errors[] = lang("ACCOUNT_SPECIFY_CONFIRM_PASSWORD");
    }
    else if(minMaxRange(8,50,$password_new))
    {	
     $errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
    }
    else if($password_new != $password_confirm)
    {
      $errors[] = lang("ACCOUNT_PASS_MISMATCH");
    }
    
    //End data validation
    if(count($errors) == 0)
    {
      //Also prevent updating if someone attempts to update with the same password
      $entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);
      
      if($entered_pass_new == $loggedInUser->hash_pw)
      {
	//Don't update, this fool is trying to update with the same password Â¬Â¬
	$errors[] = lang("ACCOUNT_PASSWORD_NOTHING_TO_UPDATE");
      }
      else
      {
	//This function will create the new hash and update the hash_pw property.
	$loggedInUser->updatePassword($password_new);
	$successes[] = lang("ACCOUNT_PASSWORD_UPDATED");
      }
    }
  }
  if(count($errors) == 0 AND count($successes) == 0){
    $errors[] = lang("NOTHING_TO_UPDATE");
  }
}

require_once("$path/models/header.php");

?>

<body>
  <div id='wrapper'>
    <? include("$path/common/top.php") ?>
    <div id='content'>
      <? include("$path/common/title.php") ?>
      <h2><?= lang("NAV_USER_SETTINGS") ?></h2>
      <div id='left-nav'> <? include("$path/common/left-nav.php"); ?>
      </div>
      <div id='main'> <?= resultBlock($errors,$successes); ?>

        <div id='regbox'>
          <form name='updateAccount' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
            <p>
              <label><?= lang("PASSWORD") ?></label>
              <input type='password' class="form-control" name='password' />
            </p>
            <p>
              <label><?= lang("EMAIL") ?></label>
              <input type='text' class="form-control" name='email' value='<?= $loggedInUser->email ?>' />
            </p>
            <p>
              <label><?= lang("NEW_PASSWORD") ?></label>
              <input type='password' class="form-control" name='passwordc' />
            </p>
            <p>
              <label><?= lang("CONFIRM_PASSWORD") ?></label>
              <input type='password' class="form-control" name='passwordcheck' />
            </p>
            <p>
              <label>&nbsp;</label>
              <input type='submit' class="btn btn-success" value='Update' class='submit' />
            </p>
          </form>
        </div>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
