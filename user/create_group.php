<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if(!empty($_POST))
{
	$errors = array();
	$successes = array();
	$name = $_POST["name"];
	$description = $_POST["description"];

        if (empty($name))
        {
          $errors[] = lang("GROUP_SPECIFY_NAME");
        }

        if (empty($description))
        {
          $errors[] = lang("GROUP_SPECIFY_DESCRIPTION");
        }
	
        if(count($errors) == 0)
        {
          $id = createGroup($loggedInUser->user_id, $name, $description);
          if ($id) {
            $successes[] = lang("GROUP_CREATED");
          } else {
            $errors[] = lang("GROUP_CREATION_FAILED");
          }
        }

	if(count($errors) == 0 AND count($successes) == 0){
		$errors[] = lang("NOTHING_TO_UPDATE");
	}
}


require_once("$root/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$root/common/top.php") ?>
    <div id='content'>
      <?php include("$root/common/title.php") ?>
      <h2>Create a Group</h2>
      <div id='left-nav'> <?php include("$root/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <div id='regbox'>

          <form name='createGroup' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
            <p>
              <label>Name:</label>
              <input type='text' name='name' />
            </p>
            <p>
              <label>Description:</label>
              <input type='text' name='description' />
            </p>
            <p>
              <label>&nbsp;</label>
              <input type='submit' value='Create' class='submit' />
            </p>
          </form>

        </div>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
