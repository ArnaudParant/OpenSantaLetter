<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

$root = preg_replace("/\/+/", "/", $_SERVER['DOCUMENT_ROOT']);
$uri = str_replace($root, "", dirname(dirname(__FILE__)));

if (!securePage($_SERVER['PHP_SELF'])){die();}

function liGenerator($href, $name)
{
  $classes = "";
  $location = $GLOBALS["location"];
  if (isset($location) and $location == $href) $classes = "active";
  echo ("<li class='".$classes."'><a href='".$href."'>".$name."</a></li>");
}

function ulGenerator($links)
{
  echo "<ul class='nav nav-pills nav-stacked'>";
  foreach ($links as $link) liGenerator($link["href"], $link["name"]);
  echo "</ul>";
}

$loggedLinks = array(
  array("href" => "$uri/user/index.php", "name" => "Account Home"),
  array("href" => "$uri/user/settings.php", "name" => "User Settings"),
  array("href" => "$uri/user/list.php", "name" => "My List"),
  array("href" => "$uri/user/groups.php", "name" => "My Groups"),
  array("href" => "$uri/user/logout.php", "name" => "Logout")
);

$adminLinks = array(
  array("href" => "$uri/admin/configuration.php", "name" => "Admin Configuration"),
  array("href" => "$uri/admin/users.php", "name" => "Admin Users"),
  array("href" => "$uri/admin/permissions.php", "name" => "Admin Permissions"),
  array("href" => "$uri/admin/pages.php", "name" => "Admin Pages")
);

$notLoggedLinks = array(
  array("href" => "$uri/index.php", "name" => "Home"),
  array("href" => "$uri/login.php", "name" => "Login"),
  array("href" => "$uri/register.php", "name" => "Register"),
  array("href" => "$uri/forgot-password.php", "name" => "Forgot Password")
);
if ($emailActivation)
  $notLoggedLinks[] = array("href" => "$uri/resend-activation.php",
                            "name" => "Resend Activation Email");

//Links for logged in user
if(isUserLoggedIn())
{
  ulGenerator($loggedLinks);

    //Links for permission level 2 (default admin)
    if ($loggedInUser->checkPermission(array(2)))
      ulGenerator($adminLinks);
}
else //Links for users not logged in
{
  ulGenerator($notLoggedLinks);
}

?>
