<?php
/*
   UserCake Version: 2.0.2
   http://usercake.com
 */

/*
   %m1% - Dymamic markers which are replaced at run time by the relevant index.
 */

$lang = array();

//Account
$lang = array_merge($lang,array(
  "ACCOUNT_SPECIFY_USERNAME" 		=> "Please enter your username",
  "ACCOUNT_SPECIFY_PASSWORD" 		=> "Please enter your password",
  "ACCOUNT_SPECIFY_EMAIL"		=> "Please enter your email address",
  "ACCOUNT_INVALID_EMAIL"		=> "Invalid email address",
  "ACCOUNT_USER_OR_EMAIL_INVALID"	=> "Username or email address is invalid",
  "ACCOUNT_USER_OR_PASS_INVALID"	=> "Username or password is invalid",
  "ACCOUNT_ALREADY_ACTIVE"		=> "Your account is already activated",
  "ACCOUNT_INACTIVE"			=> "Your account is in-active. Check your emails / spam folder for account activation instructions",
  "ACCOUNT_USER_CHAR_LIMIT"		=> "Your username must be between %m1% and %m2% characters in length",
  "ACCOUNT_DISPLAY_CHAR_LIMIT"		=> "Your display name must be between %m1% and %m2% characters in length",
  "ACCOUNT_PASS_CHAR_LIMIT"		=> "Your password must be between %m1% and %m2% characters in length",
  "ACCOUNT_TITLE_CHAR_LIMIT"		=> "Titles must be between %m1% and %m2% characters in length",
  "ACCOUNT_PASS_MISMATCH"		=> "Your password and confirmation password must match",
  "ACCOUNT_DISPLAY_INVALID_CHARACTERS"	=> "Display name can only include alpha-numeric characters",
  "ACCOUNT_USERNAME_IN_USE"		=> "Username %m1% is already in use",
  "ACCOUNT_DISPLAYNAME_IN_USE"		=> "Display name %m1% is already in use",
  "ACCOUNT_EMAIL_IN_USE"		=> "Email %m1% is already in use",
  "ACCOUNT_LINK_ALREADY_SENT"		=> "An activation email has already been sent to this email address in the last %m1% hour(s)",
  "ACCOUNT_NEW_ACTIVATION_SENT"		=> "We have emailed you a new activation link, please check your email",
  "ACCOUNT_SPECIFY_NEW_PASSWORD"	=> "Please enter your new password",	
  "ACCOUNT_SPECIFY_CONFIRM_PASSWORD"	=> "Please confirm your new password",
  "ACCOUNT_NEW_PASSWORD_LENGTH"		=> "New password must be between %m1% and %m2% characters in length",	
  "ACCOUNT_PASSWORD_INVALID"		=> "Current password doesn't match the one we have on record",	
  "ACCOUNT_DETAILS_UPDATED"		=> "Account details updated",
  "ACCOUNT_ACTIVATION_MESSAGE"		=> "You will need to activate your account before you can login. Please follow the link below to activate your account. \n\n
	%m1%activate-account.php?token=%m2%",
  "ACCOUNT_ACTIVATION_COMPLETE"		=> "You have successfully activated your account. You can now login <a href=\"login.php\">here</a>.",
  "ACCOUNT_REGISTRATION_COMPLETE_TYPE1"	=> "You have successfully registered. You can now login <a href=\"login.php\">here</a>.",
  "ACCOUNT_REGISTRATION_COMPLETE_TYPE2"	=> "You have successfully registered. You will soon receive an activation email. 
	You must activate your account before logging in.",
  "ACCOUNT_PASSWORD_NOTHING_TO_UPDATE"	=> "You cannot update with the same password",
  "ACCOUNT_PASSWORD_UPDATED"		=> "Account password updated",
  "ACCOUNT_EMAIL_UPDATED"		=> "Account email updated",
  "ACCOUNT_TOKEN_NOT_FOUND"		=> "Token does not exist / Account is already activated",
  "ACCOUNT_USER_INVALID_CHARACTERS"	=> "Username can only include alpha-numeric characters",
  "ACCOUNT_DELETIONS_SUCCESSFUL"	=> "You have successfully deleted %m1% users",
  "ACCOUNT_MANUALLY_ACTIVATED"		=> "%m1%'s account has been manually activated",
  "ACCOUNT_DISPLAYNAME_UPDATED"		=> "Displayname changed to %m1%",
  "ACCOUNT_TITLE_UPDATED"		=> "%m1%'s title changed to %m2%",
  "ACCOUNT_PERMISSION_ADDED"		=> "Added access to %m1% permission levels",
  "ACCOUNT_PERMISSION_REMOVED"		=> "Removed access from %m1% permission levels",
  "ACCOUNT_INVALID_USERNAME"		=> "Invalid username",
));

//Group
$lang = array_merge($lang,array(
  "GROUP_INVALID_ID"                      => "Invalid group id",
  "GROUP_SPECIFY_NAME"                    => "Please enter a group name",
  "GROUP_SPECIFY_DESCRIPTION"             => "Please enter a group description",
  "GROUP_CREATED"                         => "Group successfuly created",
  "GROUP_CREATION_FAILED"                 => "Failed to create the group",
  "GROUP_DELETED"                         => "Group successfuly deleted",
  "GROUP_DELETE_FAILED"                   => "Failed to delete the group",
  "GROUP_UNKNOWN_EMAIL"                   => "Unknown email",
  "GROUP_USER_ADDED"                      => "User successfuly added",
  "GROUP_USER_ADD_FAILED"                 => "Failed to add user",
  "GROUP_USER_UNSUBSCRIBE"                => "User successfuly unsubscribe",
  "GROUP_USER_UNSUBSCRIBE_FAILED"         => "Failed to unsubscribe user",
));

//User List
$lang = array_merge($lang,array(
  "USERLIST_ITEM_ADDED"                   => "Item successlufy added",
  "USERLIST_ITEM_ADD_FAILED"              => "Failed to add item",
  "USERLIST_ITEM_DELETED"                 => "Item successlufy deleted",
  "USERLIST_ITEM_DELETE_FAILED"           => "Failed to delete item",
  "USERLIST_ITEM_BOOKED"                  => "Item successlufy booked",
  "USERLIST_ITEM_BOOK_FAILED"             => "Failed to book item",
  "USERLIST_ITEM_UNBOOKED"                => "Item successlufy unbooked",
  "USERLIST_ITEM_UNBOOK_FAILED"           => "Failed to unbook item",
  "USERLIST_EMPTY"                        => "You wish list is empty",
));

//Configuration
$lang = array_merge($lang,array(
  "CONFIG_NAME_CHAR_LIMIT"		=> "Site name must be between %m1% and %m2% characters in length",
  "CONFIG_URL_CHAR_LIMIT"		=> "Site url must be between %m1% and %m2% characters in length",
  "CONFIG_EMAIL_CHAR_LIMIT"		=> "Site email must be between %m1% and %m2% characters in length",
  "CONFIG_ACTIVATION_TRUE_FALSE"	=> "Email activation must be either `true` or `false`",
  "CONFIG_ACTIVATION_RESEND_RANGE"	=> "Activation Threshold must be between %m1% and %m2% hours",
  "CONFIG_LANGUAGE_CHAR_LIMIT"		=> "Language path must be between %m1% and %m2% characters in length",
  "CONFIG_LANGUAGE_INVALID"		=> "There is no file for the language key `%m1%`",
  "CONFIG_TEMPLATE_CHAR_LIMIT"		=> "Template path must be between %m1% and %m2% characters in length",
  "CONFIG_TEMPLATE_INVALID"		=> "There is no file for the template key `%m1%`",
  "CONFIG_EMAIL_INVALID"		=> "The email you have entered is not valid",
  "CONFIG_INVALID_URL_END"		=> "Please include the ending / in your site's URL",
  "CONFIG_UPDATE_SUCCESSFUL"		=> "Your site's configuration has been updated. You may need to load a new page for all the settings to take effect",
));

//Forgot Password
$lang = array_merge($lang,array(
  "FORGOTPASS_INVALID_TOKEN"		=> "Your activation token is not valid",
  "FORGOTPASS_NEW_PASS_EMAIL"		=> "We have emailed you a new password",
  "FORGOTPASS_REQUEST_CANNED"		=> "Lost password request cancelled",
  "FORGOTPASS_REQUEST_EXISTS"		=> "There is already a outstanding lost password request on this account",
  "FORGOTPASS_REQUEST_SUCCESS"		=> "We have emailed you instructions on how to regain access to your account",
));

//Mail
$lang = array_merge($lang,array(
  "MAIL_ERROR"				=> "Fatal error attempting mail, contact your server administrator",
  "MAIL_TEMPLATE_BUILD_ERROR"		=> "Error building email template",
  "MAIL_TEMPLATE_DIRECTORY_ERROR"		=> "Unable to open mail-templates directory. Perhaps try setting the mail directory to %m1%",
  "MAIL_TEMPLATE_FILE_EMPTY"		=> "Template file is empty... nothing to send",
));

//Miscellaneous
$lang = array_merge($lang,array(
  "CAPTCHA_FAIL"			=> "Failed security question",
  "CONFIRM"				=> "Confirm",
  "DENY"				=> "Deny",
  "SUCCESS"				=> "Success",
  "ERROR"				=> "Error",
  "NOTHING_TO_UPDATE"			=> "Nothing to update",
  "SQL_ERROR"				=> "Fatal SQL error",
  "FEATURE_DISABLED"			=> "This feature is currently disabled",
  "PAGE_PRIVATE_TOGGLED"		=> "This page is now %m1%",
  "PAGE_ACCESS_REMOVED"			=> "Page access removed for %m1% permission level(s)",
  "PAGE_ACCESS_ADDED"			=> "Page access added for %m1% permission level(s)",
));

//Permissions
$lang = array_merge($lang,array(
  "PERMISSION_CHAR_LIMIT"		=> "Permission names must be between %m1% and %m2% characters in length",
  "PERMISSION_NAME_IN_USE"		=> "Permission name %m1% is already in use",
  "PERMISSION_DELETIONS_SUCCESSFUL"	=> "Successfully deleted %m1% permission level(s)",
  "PERMISSION_CREATION_SUCCESSFUL"	=> "Successfully created the permission level `%m1%`",
  "PERMISSION_NAME_UPDATE"		=> "Permission level name changed to `%m1%`",
  "PERMISSION_REMOVE_PAGES"		=> "Successfully removed access to %m1% page(s)",
  "PERMISSION_ADD_PAGES"		=> "Successfully added access to %m1% page(s)",
  "PERMISSION_REMOVE_USERS"		=> "Successfully removed %m1% user(s)",
  "PERMISSION_ADD_USERS"		=> "Successfully added %m1% user(s)",
  "CANNOT_DELETE_NEWUSERS"		=> "You cannot delete the default 'new user' group",
  "CANNOT_DELETE_ADMIN"			=> "You cannot delete the default 'admin' group",
));

//Naviguation
$lang = array_merge($lang,array(
  "NAV_HOME"			=> "Home",
  "NAV_LOGIN"			=> "Login",
  "NAV_REGISTER"		=> "Registrer",
  "NAV_FORGOT_PASSWORD"		=> "Forgot password",
  "NAV_RESEND_ACTIVATION_EMAIL"	=> "Resend activation",
  "NAV_ACCOUNT_HOME"		=> "Account home",
  "NAV_USER_SETTINGS"		=> "User settings",
  "NAV_MY_LIST"   		=> "My list",
  "NAV_MY_GROUPS"   		=> "My groups",
  "NAV_GROUP_CREATION" 		=> "Group creation",
  "NAV_GROUP_MEMBERS"	        => "Group members",
  "NAV_GROUP_LIST"	        => "Group list",
  "NAV_LOGOUT"       		=> "Logout",
  "NAV_ADMIN_SETTINGS"   	=> "Admin settings",
  "NAV_ADMIN_USERS"   		=> "Admin users",
  "NAV_ADMIN_PERMISSIONS"	=> "Admin permissions",
  "NAV_ADMIN_PAGES"		=> "Admin pages",
));

//Words
$lang = array_merge($lang,array(
  "HEY" 		=> "Hey",
  "VERSION"		=> "Version",
  "NAME"		=> "Name",
  "DESCRIPTION"		=> "Description",
  "USERNAME"		=> "Username",
  "DISPLAY_NAME"	=> "Display Name",
  "EMAIL"  		=> "Email",
  "PASSWORD"  		=> "Password",
  "NEW_PASSWORD"  	=> "New password",
  "CONFIRM_PASSWORD"  	=> "Confirm password",
  "SECURITY_CODE"  	=> "Security Code",
  "ENTER"               => "Enter",
  "GROUP"		=> "Group",
  "ACTION"              => "Action",
  "DELETE"              => "Delete",
  "ADD"                 => "Add",
  "ITEM"                => "Item",
  "BOOK"                => "Book",
  "UNBOOK"              => "Unbook",
  "BOOKED"              => "Booked",
  "INVITE"              => "Invite",
  "UNSUBSCRIBE"         => "Unsubscribe",
  "PERMISSIONS"         => "Permissions"
));

//Place Holder
$lang = array_merge($lang,array(
  "PLACEHOLDER_USER_EMAIL"         => "user email",
  "PLACEHOLDER_ITEM_NAME"          => "item name",
  "PLACEHOLDER_DESCRIPTION"        => "description",
));

//Content
$lang = array_merge($lang,array(
  "CONTENT_PRESENTATION"	=> "SantaLetter is an open source and free of charge project. The goal is to offer an easy way to manager Chritmas (or birthday) wishes list into a familly or a group of friends.",
));

?>