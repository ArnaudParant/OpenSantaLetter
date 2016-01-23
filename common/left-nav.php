<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

if (!securePage($_SERVER['PHP_SELF'])){die();}

//Links for logged in user
if(isUserLoggedIn()) {
	echo "
	<ul>
	<li><a href='/user/index.php'>Account Home</a></li>
	<li><a href='/user/settings.php'>User Settings</a></li>
	<li><a href='/user/list.php'>My List</a></li>
	<li><a href='/user/groups.php'>My Groups</a></li>
	<li><a href='/user/logout.php'>Logout</a></li>
	</ul>";

	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(2)))
        {
          echo "
	  <ul>
	  <li><a href='/admin/configuration.php'>Admin Configuration</a></li>
	  <li><a href='/admin/users.php'>Admin Users</a></li>
	  <li><a href='/admin/permissions.php'>Admin Permissions</a></li>
	  <li><a href='/admin/pages.php'>Admin Pages</a></li>
	  </ul>";
	}
}

//Links for users not logged in
else {
	echo "
	<ul>
	<li><a href='/index.php'>Home</a></li>
	<li><a href='/login.php'>Login</a></li>
	<li><a href='/register.php'>Register</a></li>
	<li><a href='/forgot-password.php'>Forgot Password</a></li>";
	if ($emailActivation)
	{
	echo "<li><a href='/resend-activation.php'>Resend Activation Email</a></li>";
	}
	echo "</ul>";
}

?>
