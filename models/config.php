<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/db-settings.php"); //Require DB connection

//Retrieve settings
$stmt = $mysqli->prepare("SELECT id, name, value
	FROM ".$db_table_prefix."configuration");	
$stmt->execute();
$stmt->bind_result($id, $name, $value);

while ($stmt->fetch()){
	$settings[$name] = array('id' => $id, 'name' => $name, 'value' => $value);
}
$stmt->close();

//Set Settings
$emailActivation = $settings['activation']['value'];
$mail_templates_dir = "$root/models/mail-templates/";
$websiteName = $settings['website_name']['value'];
$websiteUrl = $settings['website_url']['value'];
$emailAddress = $settings['email']['value'];
$resend_activation_threshold = $settings['resend_activation_threshold']['value'];
$emailDate = date('dmy');
$language = $settings['language']['value'];
$template = $settings['template']['value'];

$master_account = -1;

$default_hooks = array("#WEBSITENAME#","#WEBSITEURL#","#DATE#");
$default_replace = array($websiteName,$websiteUrl,$emailDate);

if (!file_exists($language)) {
	$language = "$root/models/languages/en.php";
}

if(!isset($language)) $language = "$root/models/languages/en.php";

//Pages to require
require_once($language);
require_once("$root/models/class.mail.php");
require_once("$root/models/class.user.php");
require_once("$root/models/class.newuser.php");
require_once("$root/models/funcs.php");

session_start();

//Global User Object Var
//loggedInUser can be used globally if constructed
if(isset($_SESSION["userCakeUser"]) && is_object($_SESSION["userCakeUser"]))
{
	$loggedInUser = $_SESSION["userCakeUser"];
}

?>
