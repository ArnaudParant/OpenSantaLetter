<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
require_once("$path/common/utils.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

$location = "/user/index.php";

if(!empty($_POST))
{

  $errors = array();
  $successes = array();
  $form = $_POST["form"];

  $user_id = $_POST["user_id"];
  $item_id = $_POST["item_id"];

  if ($form == "bookItem")
  {
    $booked = bookItem($user_id, $item_id, $loggedInUser->user_id, $loggedInUser->username);
    if ($booked) {
      $successes[] = lang("USERLIST_ITEM_BOOKED");
    } else {
      $errors[] = lang("USERLIST_ITEM_BOOK_FAILED");
    }
  }
  else if ($form == "unbookItem")
  {
    $unbooked = unbookItem($user_id, $item_id, $loggedInUser->user_id, $loggedInUser->username);
    if ($unbooked) {
      $successes[] = lang("USERLIST_ITEM_UNBOOKED");
    } else {
      $errors[] = lang("USERLIST_ITEM_UNBOOK_FAILED");
    }
  }
}

class Search
{
  static function user_select($user_id, $members)
  {
    $options = [array("value"=>"","name"=>"-")];
    foreach ($members as $member)
    {
      if ($member["id"] != $user_id)
        $options[] = array("value" => $member["name"],
                           "name" => $member["name"]);
    }
    return Utils::select("username", $options);
  }

  static function type_select()
  {
    return Utils::select("type", ItemUtils::types_options());
  }

  static function second_hand_select()
  {
    $options = array(
      array("value"=>"", "name"=>"-"),
      array("value"=>"1", "name"=>lang("YES")),
      array("value"=>"0", "name"=>lang("NO"))
    );
    return Utils::select("second_hand", $options);
  }

  static function price_select()
  {
    return FormUtils::number("price");
  }
}

$groupId = $_GET['id'];
$groupData = fetchGroupDetail($loggedInUser->user_id, $groupId);
$members = fetchGroupMember($groupId);
$list = fetchGroupList($loggedInUser->user_id, $groupData['id']);

require_once("$path/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2><?= lang("GROUP") ?> <?=$groupData['name'] ?></h2>
      <center><h3><?=$groupData['description'] ?></h3></center>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>

<?php

 if (!$groupData)
 {
  echo "<div class='error'>". lang("GROUP_INVALID_ID") ."</div>";
  die();
 }

?>

        <?= resultBlock($errors,$successes); ?>

        <p class="right">
          <a href="group_members.php?id=<?=$groupId?>">
            <button class="btn btn-info"><?= lang("NAV_GROUP_MEMBERS") ?></button>
          </a>
        </p>

        <div class="panel-group" id="group_list" role="tablist" aria-multiselectable="true">

        <table class="table table-striped group-list-table">
          <tr class="header">
            <th><?= lang("USERNAME") ?></th>
            <th><?= lang("TYPE") ?></th>
            <th><?= lang("NAME") ?></th>
            <th><?= lang("PRICE") ?></th>
            <th><?= lang("SECOND_HAND") ?></th>
            <th><?= lang("DESCRIPTION") ?></th>
            <th class="text-right"><?= lang("ACTION") ?></th>
          </tr>
          <tr class="search-line">
            <th><?=Search::user_select($loggedInUser->user_id, $members); ?></th>
            <th><?=Search::type_select(); ?></th>
            <th></th>
            <th><?=Search::price_select() ?></th>
            <th><?=Search::second_hand_select(); ?></th>
            <th></th>
            <th class="text-right">
              <button class="btn btn-info"><?= Utils::icon("search") ?><?= lang("SEARCH") ?></button>
            </th>
          </tr>

       <?php

      //Cycle through the group list
      foreach ($list as $item) {

      ?>

         <tr>
          <td><?=$item['user']["name"] ?></td>
          <td><?=ItemUtils::type($item["type"]) ?></td>
          <td><?=$item['name'] ?></td>
          <td><?=$item['price'] ?></td>
          <td><?=ItemUtils::second_hand($item["second_hand"]) ?></td>
          <td><?=$item['description'] ?></td>
          <td class="text-right">
            <?php

            if (strlen($item['booked']['id']) > 0)
            {
              if ($item['booked']['id'] != $loggedInUser->user_id)
              {
                echo "<div class='booked'>". lang("BOOKED") ."</div>";
              }
              else
              {
              ?>
                <form name='unbookItem' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId?>' method='post'>
                  <input type='hidden' name='form' value='unbookItem' />
                  <input type='hidden' name='user_id' value='<?=$item['user']["id"] ?>' />
                  <input type='hidden' name='item_id' value='<?=$item['id'] ?>' />
                  <input type='submit' class="btn btn-warning" value='<?= lang("UNBOOK") ?>' class='submit' />
                </form>
              <?php
              }
            }
            else
            {

            ?>
              <form name='bookItem' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId?>' method='post'>
                <input type='hidden' name='form' value='bookItem' />
                <input type='hidden' name='user_id' value='<?=$item['user']["id"] ?>' />
                <input type='hidden' name='item_id' value='<?=$item['id'] ?>' />
                <input type='submit' class="btn btn-success" value='<?= lang("BOOK") ?>' class='submit' />
              </form>
            <?php } ?>
          </td>
        </tr>

      <?php } ?>

        </table>

        </div>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
