<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/user/list.php";

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if(!empty($_POST))
{
  
  $errors = array();
  $successes = array();
  $form = $_POST["form"];

  if ($form == "addItem")
  {

    $item = $_POST["item"];
    $description = $_POST["description"];
    $added = addUserListItem($loggedInUser->user_id, $item, $description);

    if ($added) {
      $successes[] = lang("USERLIST_ITEM_ADDED");
    } else {
      $errors[] = lang("USERLIST_ITEM_ADD_FAILED");
    }


  }
  else if ($form == "deleteItem")
  {
    $item_id = $_POST["item_id"];

    $deleted = deleteUserListItem($loggedInUser->user_id, $item_id);

    if ($deleted) {
      $successes[] = lang("USERLIST_ITEM_DELETED");
    } else {
      $errors[] = lang("USERLIST_ITEM_DELETE_FAILED");
    }

  }

}

$items = fetchUserList($loggedInUser->user_id);

require_once("$path/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2><?= lang("NAV_MY_LIST") ?></h2>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

<?php

if (count($items) > 0)
{

?>
        <table class="table table-striped">
          <tr>
            <th><?= lang("DELETE") ?></th>
            <th><?= lang("ITEM") ?></th>
            <th><?= lang("DESCRIPTION") ?></th>
          </tr>
<?php

//Cycle through users data
foreach ($items as $item) {

?>

  <tr>
    <td>
      <form name='deleteItem' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
        <input type='hidden' name='form' value='deleteItem' />
        <input type='hidden' name='item_id' value='<?=$item['id'] ?>' />
        <input type='submit' class="btn btn-danger" value='X' class='submit' />
      </form>

    </td>
    <td><?=$item['name'] ?></td>
    <td><?=$item['description'] ?></td>
  </tr>

<?php } ?>
</table>
<?php } else { ?>
<div><?= lang("USERLIST_EMPTY") ?></div>
<?php } ?>

        <div id='regbox'>

          <form name='addItem' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
            <p>
              <input type='hidden' name='form' value='addItem' />
              <input type='text' class="form-control" name='item'
                     placeholder="<?= lang("PLACEHOLDER_ITEM_NAME") ?>" />
              <input type='text' class="form-control" name='description'
                     placeholder="<?= lang("PLACEHOLDER_DESCRIPTION") ?>" />
              <input type='submit' class="btn btn-success"
                     value='<?= lang("ADD") ?>'
                     class='submit' />
            </p>
          </form>

        </div>


      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
