<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

$path = dirname(__FILE__);
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

$location = "/register.php";

//Forms posted
if(!empty($_POST))
{
  $errors = array();
  $email = trim($_POST["email"]);
  $username = trim($_POST["username"]);
  $displayname = trim($_POST["displayname"]);
  $password = trim($_POST["password"]);
  $confirm_pass = trim($_POST["passwordc"]);
  $captcha = md5($_POST["captcha"]);
  
  
  if ($captcha != $_SESSION['captcha'])
  {
    $errors[] = lang("CAPTCHA_FAIL");
  }
  if(minMaxRange(5,25,$username))
  {
    $errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
  }
  if(!ctype_alnum($username)){
    $errors[] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
  }
  if(minMaxRange(5,25,$displayname))
  {
    $errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
  }
  if(!ctype_alnum($displayname)){
    $errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
  }
  if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
  {
    $errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
  }
  else if($password != $confirm_pass)
  {
    $errors[] = lang("ACCOUNT_PASS_MISMATCH");
  }
  if(!isValidEmail($email))
  {
    $errors[] = lang("ACCOUNT_INVALID_EMAIL");
  }
  //End data validation
  if(count($errors) == 0)
  {	
   //Construct a user object
   $user = new User($username,$displayname,$password,$email);
   
   //Checking this flag tells us whether there were any errors such as possible data duplication occured
   if(!$user->status)
   {
    if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
    if($user->displayname_taken) $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
    if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
   }
   else
   {
    //Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
    if(!$user->userCakeAddUser())
    {
      if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
      if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
    }
   }
  }
  if(count($errors) == 0) {
    $successes[] = $user->success;
  }
}

require_once("$path/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$path/common/top.php"); ?>
    <div id='content'>
      <?php include("$path/common/title.php"); ?>
      <h2><?= lang("NAV_REGISTER") ?></h2>

      <div id='left-nav'><?php include("$path/common/left-nav.php"); ?></div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <div id='regbox'>
          <form name='newUser' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>

            <p>
              <label><?= lang("USERNAME") ?>:</label>
              <input type='text' class="form-control" name='username' />
            </p>
            <p>
              <label><?= lang("DISPLAY_NAME") ?>:</label>
              <input type='text' class="form-control" name='displayname' />
            </p>
            <p>
              <label><?= lang("PASSWORD") ?>:</label>
              <input type='password' class="form-control" name='password' />
            </p>
            <p>
              <label><?= lang("CONFIRM_PASSWORD") ?>:</label>
              <input type='password' class="form-control" name='passwordc' />
            </p>
            <p>
              <label><?= lang("EMAIL") ?>:</label>
              <input type='text' class="form-control" name='email' />
            </p>
            <p>
              <label><?= lang("SECURITY_CODE") ?>:</label>
              <img src='/models/captcha.php'>
            </p>
            <label><?= lang("ENTER") ?> <?= lang("SECURITY_CODE") ?>:</label>
            <input name='captcha' class="form-control" type='text'>
            </p>
            <label>&nbsp;<br>
              <input type='submit' class="btn btn-success" value='Register'/>
            </p>

          </form>
        </div>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
