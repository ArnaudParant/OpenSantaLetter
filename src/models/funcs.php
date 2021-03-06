<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

$root = preg_replace("/\/+/", "/", $_SERVER['DOCUMENT_ROOT']);
$models = dirname(__FILE__);

//Functions that do not interact with DB
//------------------------------------------------------------------------------

//Retrieve a list of all .php files in models/languages
function getLanguageFiles()
{
  $models = $GLOBALS["models"];
  $root = $GLOBALS["root"];

  $directory = "$models/languages/";
  $languages = glob($directory . "*.php");

  //print each file name
  foreach ($languages as $language){
    $row[$language] = str_replace($root, "", $language);
  }
  return $row;
}

//Retrieve a list of all .css files in models/site-templates 
function getTemplateFiles()
{
  $models = $GLOBALS["models"];
  $root = $GLOBALS["root"];

  $directory = "$models/site-templates/";
  $templates = glob($directory . "*.css");

  //print each file name
  foreach ($templates as $template){
    $row[$template] = str_replace($root, "", $template);
  }
  return $row;
}

//Retrieve a list of all .php files in root files folder
function getPageFiles()
{
  $models = $GLOBALS["models"];
  $root = $GLOBALS["root"];

  $public_pages = glob("$root/*.php");
  $admin_pages = glob("$root/admin/*.php");
  $user_pages = glob("$root/user/*.php");

  $pages = array_merge($public_pages, $admin_pages, $user_pages);

  //print each file name
  foreach ($pages as $page){
    $row[$page] = str_replace($root, "", $page);
  }
  return $row;
}

//Destroys a session as part of logout
function destroySession($name)
{
  if(isset($_SESSION[$name]))
  {
    $_SESSION[$name] = NULL;
    unset($_SESSION[$name]);
  }
}

//Generate a unique code
function getUniqueCode($length = "")
{	
 $code = md5(uniqid(rand(), true));
 if ($length != "") return substr($code, 0, $length);
 else return $code;
}

//Generate an activation key
function generateActivationToken($gen = null)
{
  do
  {
    $gen = md5(uniqid(mt_rand(), false));
  }
  while(validateActivationToken($gen));
  return $gen;
}

//@ Thanks to - http://phpsec.org
function generateHash($plainText, $salt = null)
{
  if ($salt === null)
  {
    $salt = substr(md5(uniqid(rand(), true)), 0, 25);
  }
  else
  {
    $salt = substr($salt, 0, 25);
  }
  
  return $salt . sha1($salt . $plainText);
}

//Checks if an email is valid
function isValidEmail($email)
{
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
  }
  else {
    return false;
  }
}

//Inputs language strings from selected language.
function lang($key,$markers = NULL)
{
  global $lang;
  if($markers == NULL)
  {
    $str = $lang[$key];
  }
  else
  {
    //Replace any dyamic markers
    $str = $lang[$key];
    $iteration = 1;
    foreach($markers as $marker)
    {
      $str = str_replace("%m".$iteration."%",$marker,$str);
      $iteration++;
    }
  }
  //Ensure we have something to return
  if($str == "")
  {
    return ("No language key found");
  }
  else
  {
    return $str;
  }
}

//Checks if a string is within a min and max length
function minMaxRange($min, $max, $what)
{
  if(strlen(trim($what)) < $min)
    return true;
  else if(strlen(trim($what)) > $max)
    return true;
  else
    return false;
}

//Replaces hooks with specified text
function replaceDefaultHook($str)
{
  global $default_hooks,$default_replace;	
  return (str_replace($default_hooks,$default_replace,$str));
}

//Displays error and success messages
function resultBlock($errors,$successes){
  //Error block
  if(count($errors) > 0)
  {
    echo "<div id='error' class='alert alert-danger'>
		<a href='#' onclick=\"showHide('error');\">[X]</a>
                <strong>".lang("ERROR")."!</strong> ";
    foreach($errors as $error)
    {
      echo "<span>".$error."</span>";
    }
    echo "</div>";
  }
  //Success block
  if(count($successes) > 0)
  {
    echo "<div id='success' class='alert alert-success'>
		<a href='#' onclick=\"showHide('success');\">[X]</a>
                <strong>".lang("SUCCESS")."!</strong> ";
    foreach($successes as $success)
    {
      echo "<span>".$success."</span>";
    }
    echo "</div>";
  }
}

//Completely sanitizes text
function sanitize($str)
{
  return strtolower(strip_tags(trim(($str))));
}

//Functions that interact mainly with .users table
//------------------------------------------------------------------------------

//Delete a defined array of users
function deleteUsers($users) {
  global $mysqli,$db_table_prefix; 
  $i = 0;
  $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."users 
		WHERE id = ?");
  $stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE user_id = ?");
  foreach($users as $id){
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $i++;
  }
  $stmt->close();
  $stmt2->close();
  return $i;
}

//Check if a display name exists in the DB
function displayNameExists($displayname)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT active
		            FROM ".$db_table_prefix."users
		WHERE
		display_name = ?
		LIMIT 1");
  $stmt->bind_param("s", $displayname);	
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Check if an email exists in the DB
function emailExists($email)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT active
		            FROM ".$db_table_prefix."users
		WHERE
		email = ?
		LIMIT 1");
  $stmt->bind_param("s", $email);	
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Receive user id from email
function userIdOfEmail($email)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
                                id,
                                active
		            FROM ".$db_table_prefix."users
		WHERE
		email = ?
		LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($id, $active);
  while ($stmt->fetch()){
    $row[] = array('id' => $id, 'active' => $active);
  }
  $stmt->close();

  return ($row[0]["id"]);
}


//Check if a user name and email belong to the same user
function emailUsernameLinked($email,$username)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT active
		            FROM ".$db_table_prefix."users
		WHERE user_name = ?
		AND
		email = ?
		LIMIT 1
		");
  $stmt->bind_param("ss", $username, $email);	
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Retrieve information for all users
function fetchAllUsers()
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                user_name,
		                display_name,
		                password,
		                email,
		                activation_token,
		                last_activation_request,
		                lost_password_request,
		                active,
		                title,
		                sign_up_stamp,
		                last_sign_in_stamp
		            FROM ".$db_table_prefix."users");
  $stmt->execute();
  $stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);
  
  while ($stmt->fetch()){
    $row[] = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
  }
  $stmt->close();
  return ($row);
}

//Retrieve complete user information by username, token or ID
function fetchUserDetails($username=NULL,$token=NULL, $id=NULL)
{
  if($username!=NULL) {
    $column = "user_name";
    $data = $username;
  }
  elseif($token!=NULL) {
    $column = "activation_token";
    $data = $token;
  }
  elseif($id!=NULL) {
    $column = "id";
    $data = $id;
  }
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                user_name,
		                display_name,
		                password,
		                email,
		                activation_token,
		                last_activation_request,
		                lost_password_request,
		                active,
		                title,
		                sign_up_stamp,
		                last_sign_in_stamp
		            FROM ".$db_table_prefix."users
		WHERE
		$column = ?
		LIMIT 1");
  $stmt->bind_param("s", $data);
  
  $stmt->execute();
  $stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);
  while ($stmt->fetch()){
    $row = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
  }
  $stmt->close();
  return ($row);
}

//Retrieve information of groups where the user is member
function fetchGroups($id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
		                ".$db_table_prefix."groups.id,
		".$db_table_prefix."groups.name,
                description,
                permissions.name AS permissions
		FROM ".$db_table_prefix."groups
                LEFT JOIN ".$db_table_prefix."group_member member
                ON id = member.group_id
                RIGHT JOIN ".$db_table_prefix."permissions permissions
                ON member.permissions_id = permissions.id
                WHERE user_id = ".$id."
                ");
  $stmt->execute();
  $stmt->bind_result($id, $name, $description, $permissions);
  
  while ($stmt->fetch()){
    $row[] = array('id' => $id, 'name' => $name,
                   'description' => $description,
                   'permissions' => $permissions);
  }
  $stmt->close();
  return ($row);
}

//Retrieve information of a specific group
function fetchGroupDetail($user_id, $group_id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
		                ".$db_table_prefix."groups.id,
		".$db_table_prefix."groups.name,
                description,
                permissions.name AS permissions
		FROM ".$db_table_prefix."groups
                LEFT JOIN ".$db_table_prefix."group_member member
                ON id = member.group_id
                RIGHT JOIN ".$db_table_prefix."permissions permissions
                ON member.permissions_id = permissions.id
                WHERE user_id = ".$user_id."
                AND group_id = ".$group_id."
                LIMIT 1
                ");
  $stmt->execute();
  $stmt->bind_result($id, $name, $description, $permissions);

  while ($stmt->fetch()){
    $row[] = array('id' => $id,
                   'name' => $name,
                   'description' => $description,
                   'permissions' => $permissions);
  }
  $stmt->close();
  return ($row[0]);
}


//Retrieve group permissions of a specific member
function fetchMemberPermission($group_id, $user_id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
                                permissions_id
		            FROM ".$db_table_prefix."group_member
                WHERE group_id = ".$group_id."
                AND user_id = ".$user_id."
                ");
  $stmt->execute();
  $stmt->bind_result($permissions_id);

  while ($stmt->fetch()) {
    $pid = $permissions_id;
  }
  $stmt->close();
  return ($pid);
}


//Retrieve member of a specific group
function fetchGroupMember($group_id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
                                user.id,
                                user.display_name AS name,
                                permissions.name AS permissions
		            FROM ".$db_table_prefix."group_member
                LEFT JOIN ".$db_table_prefix."users user
                ON user_id = user.id
                LEFT JOIN ".$db_table_prefix."permissions permissions
                ON permissions_id = permissions.id
                WHERE group_id = ".$group_id."
                ");
  $stmt->execute();
  $stmt->bind_result($id, $name, $permissions);

  $row = [];
  while ($stmt->fetch()){
    $row[] = array('id' => $id, 'name' => $name,
                   'permissions' => $permissions);
  }
  $stmt->close();
  return ($row);
}

//Add group member
function addGroupMember($group_id, $user_id, $permissions_id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("INSERT
                                INTO ".$db_table_prefix."group_member
                (group_id, user_id, permissions_id)
                VALUES (".$group_id.",".$user_id.",".$permissions_id.")
                ");
  $added = $stmt->execute();
  $stmt->close();

  return $added;
}

//Create a group
function createGroup($user_id, $name, $description)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("INSERT
                INTO ".$db_table_prefix."groups
                (name, description)
                VALUES (\"".$name."\",\"".$description."\")
                ");
  $stmt->execute();
  $group_id = $mysqli->insert_id;
  $stmt->close();

  addGroupMember($group_id, $user_id, 2);

  return ($group_id);
}

//Delete a specific or all group member
function deleteGroupMember($group_id, $user_id = null)
{
  $and = "";
  if ($user_id) $and = "AND user_id = ". $user_id;

  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("DELETE
                            FROM ".$db_table_prefix."group_member
                WHERE group_id = ".$group_id."
                ".$and."
                ");
  $deleted = $stmt->execute();
  $stmt->close();

  return $deleted;
}

//Delete a group
function deleteGroup($group_id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("DELETE
                            FROM ".$db_table_prefix."groups
                WHERE id = ".$group_id."
                LIMIT 1
                ");
  $deleted = $stmt->execute();
  $stmt->close();

  deleteGroupMember($group_id, null);

  return ($deleted);
}

//Retrieve information of a specific user list
function fetchUserList($user_id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
		id,
                type,
		name,
                price,
                second_hand,
                description
		FROM ".$db_table_prefix."list
                WHERE user_id = ".$user_id."
                ");
  $stmt->execute();
  $stmt->bind_result($id, $type, $name, $price, $second_hand, $description);

  $row = [];
  while ($stmt->fetch()){
    $row[] = array('id' => $id,
                   'type' => $type,
                   'name' => $name,
                   'price' => $price,
                   'second_hand' => $second_hand,
                   'description' => $description);
  }
  $stmt->close();
  return ($row);
}

//Add a user list Item
function addUserListItem($user_id, $item)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("INSERT
                INTO ".$db_table_prefix."list
                (user_id, type, name, price, second_hand, description)
                VALUES (".$user_id.",\"".$item["type"]."\",\"".$item["name"]."\",".$item["price"].",".$item["second_hand"].",\"".$item["description"]."\")
                ");
  $added = $stmt->execute();
  $stmt->close();
  return $added;
}

//Edit a user list Item
function editUserListItem($user_id, $item_id, $item)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE {$db_table_prefix}list SET
                type=\"{$item['type']}\",
                name=\"{$item['name']}\",
                price={$item['price']},
                second_hand={$item['second_hand']},
                description=\"{$item['description']}\"
                WHERE id=$item_id AND user_id=$user_id
                ");
  $edited = $stmt->execute();
  $stmt->close();
  return $edited;
}

//Delete a user list Item
function deleteUserListItem($user_id, $item_id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("DELETE
                            FROM ".$db_table_prefix."list
                WHERE user_id = ".$user_id."
                AND id = ".$item_id."
                LIMIT 1
                ");
  $deleted = $stmt->execute();
  $stmt->close();

  return ($deleted);
}

//Item is booked
function itemIsBooked($user_id, $item_id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT
                                user_id,
                                item_id
                            FROM ".$db_table_prefix."book
     WHERE user_id = ".$user_id."
     AND item_id = ".$item_id."
     LIMIT 1
     ");
  $stmt->execute();
  $stmt->bind_result($user_id, $item_id);

  $booked = array();
  while ($stmt->fetch()) {
    $booked[] = array('user_id' => $user_id,
                      'item_id' => $item_id);
  }
  $stmt->close();

  return (count($booked) > 0);
}

//Book an item
function bookItem($user_id, $item_id, $booked_by_id, $booked_by_name)
{
  global $mysqli,$db_table_prefix;

  if (itemIsBooked($user_id, $item_id)) return false;

  $stmt = $mysqli->prepare("INSERT
                                INTO ".$db_table_prefix."book
                (user_id, item_id, booked_by_id, booked_by_name)
                VALUES ('".$user_id."','".$item_id."','".$booked_by_id."','".$booked_by_name."')
                ");
  $booked = $stmt->execute();
  $stmt->close();

  return ($booked);
}

//Unbook an item
function unbookItem($user_id, $item_id, $booked_by_id, $booked_by_name)
{
  global $mysqli,$db_table_prefix;

  $stmt = $mysqli->prepare("DELETE
                            FROM ".$db_table_prefix."book
     WHERE user_id = ".$user_id."
     AND item_id = ".$item_id."
     AND booked_by_id = ".$booked_by_id."
     AND booked_by_name = '".$booked_by_name."'
     LIMIT 1
  ");
  $unbooked = $stmt->execute();
  $stmt->close();

  return ($unbooked);
}

//Retrieve information of a group member's lists
function fetchGroupList($user_id, $group_id, $search)
{
  global $mysqli, $db_table_prefix;

  $filters = "";
  if ($search["username"] != NULL)
    $filters .= " AND users.display_name = '". $search["username"] ."'";
  if ($search["type"] != NULL)
    $filters .= " AND list.type = '". $search["type"] ."'";
  if ($search["price"] != NULL)
  {
    $min = 0;
    $max = $search["price"] + 10;
    $filters .= " AND list.price >= $min AND list.price <= $max";
  }
  if ($search["second_hand"] != NULL)
    $filters .= " AND list.second_hand = ". $search["second_hand"];

  $stmt = $mysqli->prepare("SELECT
                users.id AS 'user_id',
                users.display_name,
		        list.id,
		        list.type,
		        list.name,
		        list.price,
		        list.second_hand,
                list.description,
                book.booked_by_id,
                book.booked_by_name
                FROM ".$db_table_prefix."group_member
                LEFT JOIN ".$db_table_prefix."users AS users
                ON ".$db_table_prefix."group_member.user_id = users.id
                LEFT JOIN ".$db_table_prefix."list AS list
                ON ".$db_table_prefix."group_member.user_id = list.user_id
                LEFT JOIN ".$db_table_prefix."book AS book
                ON list.id = book.item_id
                WHERE group_id = ".$group_id."
                AND ".$db_table_prefix."group_member.user_id != ".$user_id."
                ". $filters);
  $stmt->execute();
  $stmt->bind_result($user_id, $display_name, $item_id, $type, $item_name, $price, $second_hand, $description, $booked_by_id, $booked_by_name);

  $lists = array();
  while ($stmt->fetch())
  {
    if ($item_id != "")
    {
      array_push($lists, array(
        "user" => array(
          "id" => $user_id,
          "name" => $display_name),
        'id' => $item_id,
        "type" => $type,
        'name' => $item_name,
        "price" => $price,
        "second_hand" => $second_hand,
        'description' => $description,
        'booked' => array(
          'id' => $booked_by_id,
          'name' => $booked_by_name
        )));
    }
  }

  $stmt->close();
  return ($lists);
}

//Toggle if lost password request flag on or off
function flagLostPasswordRequest($username,$value)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET lost_password_request = ?
		WHERE
		user_name = ?
		LIMIT 1
		");
  $stmt->bind_param("ss", $value, $username);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

//Check if a user is logged in
function isUserLoggedIn()
{
  global $loggedInUser,$mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                password
		            FROM ".$db_table_prefix."users
		WHERE
		id = ?
		AND 
		password = ? 
		AND
		active = 1
		LIMIT 1");
  $stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);	
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if($loggedInUser == NULL)
  {
    return false;
  }
  else
  {
    if ($num_returns > 0)
    {
      return true;
    }
    else
    {
      destroySession("userCakeUser");
      return false;	
    }
  }
}

//Change a user from inactive to active
function setUserActive($token)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET active = 1
		WHERE
		activation_token = ?
		LIMIT 1");
  $stmt->bind_param("s", $token);
  $result = $stmt->execute();
  $stmt->close();	
  return $result;
}

//Change a user's display name
function updateDisplayName($id, $display)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET display_name = ?
		WHERE
		id = ?
		LIMIT 1");
  $stmt->bind_param("si", $display, $id);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

//Update a user's email
function updateEmail($id, $email)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		email = ?
		WHERE
		id = ?");
  $stmt->bind_param("si", $email, $id);
  $result = $stmt->execute();
  $stmt->close();	
  return $result;
}

//Input new activation token, and update the time of the most recent activation request
function updateLastActivationRequest($new_activation_token,$username,$email)
{
  global $mysqli,$db_table_prefix; 	
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET activation_token = ?,
		last_activation_request = ?
		WHERE email = ?
		AND
		user_name = ?");
  $stmt->bind_param("ssss", $new_activation_token, time(), $email, $username);
  $result = $stmt->execute();
  $stmt->close();	
  return $result;
}

//Generate a random password, and new token
function updatePasswordFromToken($pass,$token)
{
  global $mysqli,$db_table_prefix;
  $new_activation_token = generateActivationToken();
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET password = ?,
		activation_token = ?
		WHERE
		activation_token = ?");
  $stmt->bind_param("sss", $pass, $new_activation_token, $token);
  $result = $stmt->execute();
  $stmt->close();	
  return $result;
}

//Update a user's title
function updateTitle($id, $title)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		title = ?
		WHERE
		id = ?");
  $stmt->bind_param("si", $title, $id);
  $result = $stmt->execute();
  $stmt->close();	
  return $result;	
}

//Check if a user ID exists in the DB
function userIdExists($id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT active
		            FROM ".$db_table_prefix."users
		WHERE
		id = ?
		LIMIT 1");
  $stmt->bind_param("i", $id);	
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Checks if a username exists in the DB
function usernameExists($username)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT active
		            FROM ".$db_table_prefix."users
		WHERE
		user_name = ?
		LIMIT 1");
  $stmt->bind_param("s", $username);	
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Check if activation token exists in DB
function validateActivationToken($token,$lostpass=NULL)
{
  global $mysqli,$db_table_prefix;
  if($lostpass == NULL) 
  {	
   $stmt = $mysqli->prepare("SELECT active
			     FROM ".$db_table_prefix."users
			WHERE active = 0
			AND
			activation_token = ?
			LIMIT 1");
  }
  else 
  {
    $stmt = $mysqli->prepare("SELECT active
			      FROM ".$db_table_prefix."users
			WHERE active = 1
			AND
			activation_token = ?
			AND
			lost_password_request = 1 
			LIMIT 1");
  }
  $stmt->bind_param("s", $token);
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Functions that interact mainly with .permissions table
//------------------------------------------------------------------------------

//Create a permission level in DB
function createPermission($permission) {
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permissions (
		name
		)
		VALUES (
		?
		)");
  $stmt->bind_param("s", $permission);
  $result = $stmt->execute();
  $stmt->close();	
  return $result;
}

//Delete a permission level from the DB
function deletePermission($permission) {
  global $mysqli,$db_table_prefix,$errors; 
  $i = 0;
  $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permissions 
		WHERE id = ?");
  $stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?");
  $stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE permission_id = ?");
  foreach($permission as $id){
    if ($id == 1){
      $errors[] = lang("CANNOT_DELETE_NEWUSERS");
    }
    elseif ($id == 2){
      $errors[] = lang("CANNOT_DELETE_ADMIN");
    }
    else{
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt2->bind_param("i", $id);
      $stmt2->execute();
      $stmt3->bind_param("i", $id);
      $stmt3->execute();
      $i++;
    }
  }
  $stmt->close();
  $stmt2->close();
  $stmt3->close();
  return $i;
}

//Retrieve information for all permission levels
function fetchAllPermissions()
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                name
		            FROM ".$db_table_prefix."permissions");
  $stmt->execute();
  $stmt->bind_result($id, $name);
  while ($stmt->fetch()){
    $row[] = array('id' => $id, 'name' => $name);
  }
  $stmt->close();
  return ($row);
}

//Retrieve information for a single permission level
function fetchPermissionDetails($id)
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                name
		            FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->bind_result($id, $name);
  while ($stmt->fetch()){
    $row = array('id' => $id, 'name' => $name);
  }
  $stmt->close();
  return ($row);
}

//Check if a permission level ID exists in the DB
function permissionIdExists($id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT id
		            FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
  $stmt->bind_param("i", $id);	
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Check if a permission level name exists in the DB
function permissionNameExists($permission)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT id
		            FROM ".$db_table_prefix."permissions
		WHERE
		name = ?
		LIMIT 1");
  $stmt->bind_param("s", $permission);	
  $stmt->execute();
  $stmt->store_result();
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Change a permission level's name
function updatePermissionName($id, $name)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."permissions
		SET name = ?
		WHERE
		id = ?
		LIMIT 1");
  $stmt->bind_param("si", $name, $id);
  $result = $stmt->execute();
  $stmt->close();	
  return $result;	
}

//Functions that interact mainly with .user_permission_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with user(s)
function addPermission($permission, $user) {
  global $mysqli,$db_table_prefix; 
  $i = 0;
  $stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches (
		permission_id,
		user_id
		)
		VALUES (
		?,
		?
		)");
  if (is_array($permission)){
    foreach($permission as $id){
      $stmt->bind_param("ii", $id, $user);
      $stmt->execute();
      $i++;
    }
  }
  elseif (is_array($user)){
    foreach($user as $id){
      $stmt->bind_param("ii", $permission, $id);
      $stmt->execute();
      $i++;
    }
  }
  else {
    $stmt->bind_param("ii", $permission, $user);
    $stmt->execute();
    $i++;
  }
  $stmt->close();
  return $i;
}

//Retrieve information for all user/permission level matches
function fetchAllMatches()
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                user_id,
		                permission_id
		            FROM ".$db_table_prefix."user_permission_matches");
  $stmt->execute();
  $stmt->bind_result($id, $user, $permission);
  while ($stmt->fetch()){
    $row[] = array('id' => $id, 'user_id' => $user, 'permission_id' => $permission);
  }
  $stmt->close();
  return ($row);	
}

//Retrieve list of permission levels a user has
function fetchUserPermissions($user_id)
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT
		                id,
		                permission_id
		            FROM ".$db_table_prefix."user_permission_matches
		WHERE user_id = ?
		");
  $stmt->bind_param("i", $user_id);	
  $stmt->execute();
  $stmt->bind_result($id, $permission);
  while ($stmt->fetch()){
    $row[$permission] = array('id' => $id, 'permission_id' => $permission);
  }
  $stmt->close();
  if (isset($row)){
    return ($row);
  }
}

//Retrieve list of users who have a permission level
function fetchPermissionUsers($permission_id)
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT id, user_id
		            FROM ".$db_table_prefix."user_permission_matches
		WHERE permission_id = ?
		");
  $stmt->bind_param("i", $permission_id);	
  $stmt->execute();
  $stmt->bind_result($id, $user);
  while ($stmt->fetch()){
    $row[$user] = array('id' => $id, 'user_id' => $user);
  }
  $stmt->close();
  if (isset($row)){
    return ($row);
  }
}

//Unmatch permission level(s) from user(s)
function removePermission($permission, $user) {
  global $mysqli,$db_table_prefix; 
  $i = 0;
  $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?
		AND user_id =?");
  if (is_array($permission)){
    foreach($permission as $id){
      $stmt->bind_param("ii", $id, $user);
      $stmt->execute();
      $i++;
    }
  }
  elseif (is_array($user)){
    foreach($user as $id){
      $stmt->bind_param("ii", $permission, $id);
      $stmt->execute();
      $i++;
    }
  }
  else {
    $stmt->bind_param("ii", $permission, $user);
    $stmt->execute();
    $i++;
  }
  $stmt->close();
  return $i;
}

//Functions that interact mainly with .configuration table
//------------------------------------------------------------------------------

//Update configuration table
function updateConfig($id, $value)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."configuration
		SET 
		value = ?
		WHERE
		id = ?");
  foreach ($id as $cfg){
    $stmt->bind_param("si", $value[$cfg], $cfg);
    $stmt->execute();
  }
  $stmt->close();	
}

//Functions that interact mainly with .pages table
//------------------------------------------------------------------------------

//Add a page to the DB
function createPages($pages) {
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."pages (
		page
		)
		VALUES (
		?
		)");
  foreach($pages as $page){
    $stmt->bind_param("s", $page);
    $stmt->execute();
  }
  $stmt->close();
}

//Delete a page from the DB
function deletePages($pages) {
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."pages 
		WHERE id = ?");
  $stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?");
  foreach($pages as $id){
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
  }
  $stmt->close();
  $stmt2->close();
}

//Fetch information on all pages
function fetchAllPages()
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                page,
		                private
		            FROM ".$db_table_prefix."pages");
  $stmt->execute();
  $stmt->bind_result($id, $page, $private);
  while ($stmt->fetch()){
    $row[$page] = array('id' => $id, 'page' => $page, 'private' => $private);
  }
  $stmt->close();
  if (isset($row)){
    return ($row);
  }
}

//Fetch information for a specific page
function fetchPageDetails($id)
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                page,
		                private
		            FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->bind_result($id, $page, $private);
  while ($stmt->fetch()){
    $row = array('id' => $id, 'page' => $page, 'private' => $private);
  }
  $stmt->close();
  return ($row);
}

//Check if a page ID exists
function pageIdExists($id)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("SELECT private
		            FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
  $stmt->bind_param("i", $id);	
  $stmt->execute();
  $stmt->store_result();	
  $num_returns = $stmt->num_rows;
  $stmt->close();
  
  if ($num_returns > 0)
  {
    return true;
  }
  else
  {
    return false;	
  }
}

//Toggle private/public setting of a page
function updatePrivate($id, $private)
{
  global $mysqli,$db_table_prefix;
  $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."pages
		SET 
		private = ?
		WHERE
		id = ?");
  $stmt->bind_param("ii", $private, $id);
  $result = $stmt->execute();
  $stmt->close();	
  return $result;	
}

//Functions that interact mainly with .permission_page_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with page(s)
function addPage($page, $permission) {
  global $mysqli,$db_table_prefix; 
  $i = 0;
  $stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permission_page_matches (
		permission_id,
		page_id
		)
		VALUES (
		?,
		?
		)");
  if (is_array($permission)){
    foreach($permission as $id){
      $stmt->bind_param("ii", $id, $page);
      $stmt->execute();
      $i++;
    }
  }
  elseif (is_array($page)){
    foreach($page as $id){
      $stmt->bind_param("ii", $permission, $id);
      $stmt->execute();
      $i++;
    }
  }
  else {
    $stmt->bind_param("ii", $permission, $page);
    $stmt->execute();
    $i++;
  }
  $stmt->close();
  return $i;
}

//Retrieve list of permission levels that can access a page
function fetchPagePermissions($page_id)
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT
		                id,
		                permission_id
		            FROM ".$db_table_prefix."permission_page_matches
		WHERE page_id = ?
		");
  $stmt->bind_param("i", $page_id);	
  $stmt->execute();
  $stmt->bind_result($id, $permission);
  while ($stmt->fetch()){
    $row[$permission] = array('id' => $id, 'permission_id' => $permission);
  }
  $stmt->close();
  if (isset($row)){
    return ($row);
  }
}

//Retrieve list of pages that a permission level can access
function fetchPermissionPages($permission_id)
{
  global $mysqli,$db_table_prefix; 
  $stmt = $mysqli->prepare("SELECT
		                id,
		                page_id
		            FROM ".$db_table_prefix."permission_page_matches
		WHERE permission_id = ?
		");
  $stmt->bind_param("i", $permission_id);	
  $stmt->execute();
  $stmt->bind_result($id, $page);
  while ($stmt->fetch()){
    $row[$page] = array('id' => $id, 'permission_id' => $page);
  }
  $stmt->close();
  if (isset($row)){
    return ($row);
  }
}

//Unmatched permission and page
function removePage($page, $permission) {
  global $mysqli,$db_table_prefix; 
  $i = 0;
  $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?
		AND permission_id =?");
  if (is_array($page)){
    foreach($page as $id){
      $stmt->bind_param("ii", $id, $permission);
      $stmt->execute();
      $i++;
    }
  }
  elseif (is_array($permission)){
    foreach($permission as $id){
      $stmt->bind_param("ii", $page, $id);
      $stmt->execute();
      $i++;
    }
  }
  else {
    $stmt->bind_param("ii", $permission, $user);
    $stmt->execute();
    $i++;
  }
  $stmt->close();
  return $i;
}

//Check if a user has access to a page
function securePage($uri){
  
  //Separate document name from uri
  $tokens = explode('/', $uri);
  $page = $tokens[sizeof($tokens)-1];
  global $mysqli,$db_table_prefix,$loggedInUser;
  //retrieve page details
  $stmt = $mysqli->prepare("SELECT 
		                id,
		                page,
		                private
		            FROM ".$db_table_prefix."pages
		WHERE
		page = ?
		LIMIT 1");
  $stmt->bind_param("s", $page);
  $stmt->execute();
  $stmt->bind_result($id, $page, $private);
  while ($stmt->fetch()){
    $pageDetails = array('id' => $id, 'page' => $page, 'private' => $private);
  }
  $stmt->close();
  //If page does not exist in DB, allow access
  if (empty($pageDetails)){
    return true;
  }
  //If page is public, allow access
  elseif ($pageDetails['private'] == 0) {
    return true;	
  }
  //If user is not logged in, deny access
  elseif(!isUserLoggedIn()) 
  {
    header("Location: login.php");
    return false;
  }
  else {
    //Retrieve list of permission levels with access to page
    $stmt = $mysqli->prepare("SELECT
			          permission_id
			      FROM ".$db_table_prefix."permission_page_matches
			WHERE page_id = ?
			");
    $stmt->bind_param("i", $pageDetails['id']);	
    $stmt->execute();
    $stmt->bind_result($permission);
    while ($stmt->fetch()){
      $pagePermissions[] = $permission;
    }
    $stmt->close();
    //Check if user's permission levels allow access to page
    if ($loggedInUser->checkPermission($pagePermissions)){ 
      return true;
    }
    //Grant access if master user
    elseif ($loggedInUser->user_id == $master_account){
      return true;
    }
    else {
      header("Location: account.php");
      return false;	
    }
  }
}

?>
