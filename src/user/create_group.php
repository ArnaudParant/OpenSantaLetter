<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/user/index.php";

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


require_once("$path/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2><?= lang("NAV_GROUP_CREATION") ?></h2>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <div id='regbox'>

          <form name='createGroup' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
            <p>
              <label><?= lang("NAME") ?>:</label>
              <input type='text' class="form-control" name='name' />
            </p>
            <p>
              <label><?= lang("DESCRIPTION") ?>:</label>
              <input type='text' class="form-control" name='description' />
            </p>
            <p>
              <label>&nbsp;</label>
              <input type='submit' class="btn btn-success" value='Create' class='submit' />
            </p>
          </form>

        </div>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
