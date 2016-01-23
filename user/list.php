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

require_once("$root/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$root/common/top.php") ?>
    <div id='content'>
      <?php include("$root/common/title.php") ?>
      <h2>My List</h2>
      <div id='left-nav'> <?php include("$root/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <table>
          <tr>
            <th>Delete</th><th>Item</th><th>Description</th>
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
        <input type='submit' value='X' class='submit' />
      </form>

    </td>
    <td><?=$item['name'] ?></td>
    <td><?=$item['description'] ?></td>
  </tr>

<?php

}

?>
        </table>

        <div id='regbox'>

          <form name='addItem' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
            <p>
              <input type='hidden' name='form' value='addItem' />
              <input type='text' name='item' placeholder="item name" />
              <input type='text' name='description' placeholder="description" />
              <input type='submit' value='Add' class='submit' />
            </p>
          </form>

        </div>


      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
