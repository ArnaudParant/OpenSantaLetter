<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

$root = preg_replace("/\/+/", "/", $_SERVER['DOCUMENT_ROOT']);
$uri = str_replace($root, "", dirname(dirname(__FILE__)));
$path = dirname(dirname(__FILE__));
require_once("$path/models/funcs.php");

if (!securePage($_SERVER['PHP_SELF'])){die();}

function liGenerator($href, $icon, $name)
{
  $classes = "";
  $location = $GLOBALS["location"];
  $icon = "<span class='icon $icon'></span>";
  if (isset($location) and $location == $href) $classes = "active";
  echo "<li class='$classes'><a href='$href'>$icon$name</a></li>";
}

function ulGenerator($links)
{
  echo "<ul class='nav nav-pills nav-stacked'>";
  foreach ($links as $link) liGenerator($link["href"], $link["icon"], $link["name"]);
  echo "</ul>";
}

$loggedLinks = array(
  array("href" => "$uri/user/index.php",
        "icon" => "icon-home",
        "name" => lang("NAV_MY_GROUPS")),

  array("href" => "$uri/user/list.php",
        "icon" => "fa fa-gift",
        "name" => lang("NAV_MY_LIST")),

  array("href" => "$uri/user/settings.php",
        "icon" => "icon-cog",
        "name" => lang("NAV_USER_SETTINGS")),

  array("href" => "$uri/user/logout.php",
        "icon" => "icon-logout",
        "name" => lang("NAV_LOGOUT"))
);

$adminLinks = array(
  array("href" => "$uri/admin/configuration.php",
        "icon" => "icon-cog",
        "name"=>lang("NAV_ADMIN_SETTINGS")),

  array("href" => "$uri/admin/users.php",
        "icon" => "icon-users",
        "name" => lang("NAV_ADMIN_USERS")),

  array("href" => "$uri/admin/permissions.php",
        "icon" => "icon-key",
        "name"=>lang("NAV_ADMIN_PERMISSIONS")),

  array("href" => "$uri/admin/pages.php",
        "icon" => "icon-doc-text-inv",
        "name" => lang("NAV_ADMIN_PAGES"))
);

$notLoggedLinks = array(
  array("href" => "$uri/index.php",
        "icon" => "icon-home",
        "name" => lang("NAV_HOME")),

  array("href" => "$uri/login.php",
        "icon" => "icon-login",
        "name" => lang("NAV_LOGIN")),

  array("href" => "$uri/register.php",
        "icon" => "icon-pencil",
        "name" => lang("NAV_REGISTER")),

  array("href" => "$uri/forgot-password.php",
        "icon" => "icon-help-circled",
        "name" => lang("NAV_FORGOT_PASSWORD"))
);
if ($emailActivation)
  $notLoggedLinks[] = array("href" => "$uri/resend-activation.php",
                            "icon" => "icon-paper-plane",
                            "name" => lang("NAV_RESEND_ACTIVATION_EMAIL"));

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
