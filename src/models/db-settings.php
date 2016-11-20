<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

$path = dirname(dirname(__FILE__));

//Database Information
$db_host = "mysql"; //Host address (most likely localhost)
$db_name = "santa"; //Name of Database
$db_user = "santa"; //Name of database user
$db_pass = "santa"; //Password for database user
$db_table_prefix = "santa_";

GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
  echo "Data base connection failed: " . mysqli_connect_errno();
  exit();
}

//Direct to install directory, if it exists
if(is_dir("$path/install/"))
{
  header("Location: install/");
  die();
}

?>