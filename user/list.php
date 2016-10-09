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

    $second_hand = 0;
    if (isset($_POST["second_hand"])) $second_hand = 1;

    $price = 0;
    if (strlen($_POST["price"]) > 0) $price = $_POST["price"];

    $item = array(
      "type" => $_POST["type"],
      "name" => $_POST["name"],
      "price" => $price,
      "second_hand" => $second_hand,
      "description" => $_POST["description"]);
    $added = addUserListItem($loggedInUser->user_id, $item);

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
<script>
  function submiter(item_id)
  {
    document.getElementById("item_" + item_id).submit();
  }
</script>
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
            <th><?= lang("TYPE") ?></th>
            <th><?= lang("NAME") ?></th>
            <th><?= lang("PRICE") ?></th>
            <th><?= lang("SECOND_HAND") ?></th>
            <th><?= lang("DESCRIPTION") ?></th>
          </tr>
<?php

//Cycle through users data
foreach ($items as $item) {

?>

  <tr>
    <td>
      <form name='deleteItem' id='item_<?= $item['id'] ?>'
            action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
        <input type='hidden' name='form' value='deleteItem' />
        <input type='hidden' name='item_id' value='<?=$item['id'] ?>' />
        <button type="button" class="btn btn-danger"
                onClick="submiter('<?= $item['id'] ?>');">
          <span class="icon-cancel"></span>
        </button>
      </form>

    </td>
    <td>
      <? if ($item['type'] != null) { echo lang(strtoupper($item['type'])); } ?>
    </td>
    <td><?=$item['name'] ?></td>
    <td><?=$item['price'] ?></td>
    <td>
      <span class="icon icon-<? if ($item['second_hand'] >= 1) { echo "check"; } else { echo "cancel"; } ?>">
      </span>
    </td>
    <td><?=$item['description'] ?></td>
  </tr>

<?php } ?>
</table>
<?php } else { ?>
<div><?= lang("USERLIST_EMPTY") ?></div>
<?php } ?>

        <div id='regbox' class='add-item-box'>

          <div class="small_title"><?= lang("BOX_ITEM_ADD_NAME") ?></div>

          <form name='addItem' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>

            <input type='hidden' name='form' value='addItem' />

            <p>
              <label><?= lang("TYPE") ?></label>
              <select name="type">
                <option value="">-</option>
                <option value="food"><?= lang("FOOD") ?></option>
                <option value="item_book"><?= lang("ITEM_BOOK") ?></option>
                <option value="music"><?= lang("MUSIC") ?></option>
                <option value="movie"><?= lang("MOVIE") ?></option>
                <option value="game"><?= lang("GAME") ?></option>
                <option value="high-tech"><?= lang("HIGH-TECH") ?></option>
                <option value="home-appliance"><?= lang("HOME-APPLIANCE") ?></option>
                <option value="clothes"><?= lang("CLOTHES") ?></option>
                <option value="accessory"><?= lang("ACCESSORY") ?></option>
                <option value="decoration"><?= lang("DECORATION") ?></option>
                <option value="other"><?= lang("OTHER") ?></option>
              </select>
            </p>

            <p>
              <label><?= lang("NAME") ?></label>
              <input type='text' class="form-control" name='name' />
            </p>

            <p>
              <label><?= lang("PRICE") ?></label>
              <input type='number' class="form-control" name='price'
                     min="0" placeholder="0" />
            </p>

            <p>
              <label><?= lang("SECOND_HAND") ?></label>
              <input type='checkbox' name='second_hand' value="1" />
            </p>


            <p>
              <label><?= lang("DESCRIPTION") ?></label>
              <input type='text' class="form-control" name='description' />
            </p>

            <p>
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
