<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

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
  array("href" => "/user/index.php", "name" => "Account Home"),
  array("href" => "/user/settings.php", "name" => "User Settings"),
  array("href" => "/user/list.php", "name" => "My List"),
  array("href" => "/user/groups.php", "name" => "My Groups"),
  array("href" => "/user/logout.php", "name" => "Logout")
);

$adminLinks = array(
  array("href" => "/admin/configuration.php", "name" => "Admin Configuration"),
  array("href" => "/admin/users.php", "name" => "Admin Users"),
  array("href" => "/admin/permissions.php", "name" => "Admin Permissions"),
  array("href" => "/admin/pages.php", "name" => "Admin Pages")
);

$notLoggedLinks = array(
  array("href" => "/index.php", "name" => "Home"),
  array("href" => "/login.php", "name" => "Login"),
  array("href" => "/register.php", "name" => "Register"),
  array("href" => "/forgot-password.php", "name" => "Forgot Password")
);
if ($emailActivation)
  $notLoggedLinks[] = array("href" => "/resend-activation.php",
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
