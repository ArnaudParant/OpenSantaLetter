<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

$location = "/user/groups.php";

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

//Fetch information of specific group
$groupId = $_GET['id'];
$groupData = fetchGroupDetail($loggedInUser->user_id, $groupId);
$lists = fetchGroupMemberLists($loggedInUser->user_id, $groupData['id']);

require_once("$path/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2>Group <?=$groupData['name'] ?></h2>
      <center><h3><?=$groupData['description'] ?></h3></center>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>

<?php

 if (!$groupData)
 {
  echo "<div class='error'>Invalid group id</div>";
  die();
 }

?>

        <?= resultBlock($errors,$successes); ?>

        <p>
          <a href="group_members.php?id=<?=$groupId?>">
            <button class="btn btn-info">Group Members</button>
          </a>
        </p>

<?php

//Cycle through users' list
foreach ($lists as $list) {

?>

  <div>
    <h3><?=$list['name'] ?></h3>
    <table class="table table-striped">
      <tr>
        <th>Action</th><th>Item</th><th>Description</th>
      </tr>

      <?php

      //Cycle through user' list
      foreach ($list['list'] as $item) {

      ?>

        <tr>
          <td>
            <?php

            if (strlen($item['booked']['id']) > 0)
            {
              if ($item['booked']['id'] != $loggedInUser->user_id)
              {
                echo "<div class='booked'>Booked</div>";
              }
              else
              {
              ?>
                <form name='unbookItem' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId?>' method='post'>
                  <input type='hidden' name='form' value='unbookItem' />
                  <input type='hidden' name='user_id' value='<?=$list['id'] ?>' />
                  <input type='hidden' name='item_id' value='<?=$item['id'] ?>' />
                  <input type='submit' class="btn btn-warning" value='Unbook' class='submit' />
                </form>
              <?php
              }
            }
            else
            {

            ?>
              <form name='bookItem' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId?>' method='post'>
                <input type='hidden' name='form' value='bookItem' />
                <input type='hidden' name='user_id' value='<?=$list['id'] ?>' />
                <input type='hidden' name='item_id' value='<?=$item['id'] ?>' />
                <input type='submit' class="btn btn-success" value='Book' class='submit' />
              </form>
            <?php } ?>
          </td>
          <td><?=$item['name'] ?></td>
          <td><?=$item['description'] ?></td>
        </tr>

      <?php } ?>

    </table>
  </div>

<?php } ?>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
