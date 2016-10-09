<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
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

//Fetch information of specific group
$groupId = $_GET['id'];
$groupData = fetchGroupDetail($loggedInUser->user_id, $groupId);
$lists = fetchGroupMemberLists($loggedInUser->user_id, $groupData['id']);

require_once("$path/models/header.php");

?>

<body>
  <script>

   OPENED = {}

   function open_icon(list_id)
   {
     OPENED[list_id] = !OPENED[list_id]
     var dom = $("#open_icon_"+ list_id)[0]

     if (OPENED[list_id]) dom.className = "icon-minus"
     else dom.className = "icon-plus"
   }

   function open_icon_manager(list_id)
   {
     var dom = $("#list_"+ list_id)
     if (!dom || dom.length == 0) return null;
     dom = dom[0]

     if (OPENED[list_id] == undefined) OPENED[list_id] = false

     if (dom.className.indexOf("collapsing") > 0) return ;

     for (var id in OPENED) { if (id != list_id && OPENED[id]) open_icon(id) }
     open_icon(list_id)
   }

  </script>
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

        <p>
          <a href="group_members.php?id=<?=$groupId?>">
            <button class="btn btn-info"><?= lang("NAV_GROUP_MEMBERS") ?></button>
          </a>
        </p>

        <div class="panel-group" id="group_list" role="tablist" aria-multiselectable="true">
<?php

$list_id = -1;
$length = 0;

//Cycle through users' list
foreach ($lists as $list) {
  $list_id += 1;
  $length = count($list['list']);
?>

  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading_<?=$list_id ?>">
      <h3 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#group_list"
           href="#list_<?=$list_id ?>" aria-expanded="false"
           aria-controls="list_<?=$list_id ?>"
           onclick="open_icon_manager(<?=$list_id ?>)">
          <?php if ($length > 0) echo "<span id='open_icon_$list_id' class='icon-plus'></span>"; ?>
          <?=$list['name'] ?> - <?=count($list['list']) ?> <?=lang("ITEM") ?>s
        </a>
      </h3>
    </div>
<?php if ($length > 0) { ?>
    <div id="list_<?=$list_id ?>" class="panel-collapse collapse"
         role="tabpanel" aria-labelledby="heading_<?=$list_id ?>">
      <div class="panel-body">
        <table class="table table-striped">
          <tr>
            <th><?= lang("ACTION") ?></th>
            <th><?= lang("TYPE") ?></th>
            <th><?= lang("NAME") ?></th>
            <th><?= lang("PRICE") ?></th>
            <th><?= lang("SECOND_HAND") ?></th>
            <th><?= lang("DESCRIPTION") ?></th>
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
                echo "<div class='booked'>". lang("BOOKED") ."</div>";
              }
              else
              {
              ?>
                <form name='unbookItem' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId?>' method='post'>
                  <input type='hidden' name='form' value='unbookItem' />
                  <input type='hidden' name='user_id' value='<?=$list['id'] ?>' />
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
                <input type='hidden' name='user_id' value='<?=$list['id'] ?>' />
                <input type='hidden' name='item_id' value='<?=$item['id'] ?>' />
                <input type='submit' class="btn btn-success" value='<?= lang("BOOK") ?>' class='submit' />
              </form>
            <?php } ?>
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
      </div>
    </div>
<?php }  ?>
  </div>

<?php } ?>

        </div>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
