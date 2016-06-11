<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

//Fetch information of specific group
$groupId = $_GET['id'];
$groupData = fetchGroupDetail($loggedInUser->user_id, $groupId);
$lists = fetchGroupMemberLists($loggedInUser->user_id, $groupData['id']);

require_once("$root/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$root/common/top.php") ?>
    <div id='content'>
      <?php include("$root/common/title.php") ?>
      <h2>Group <?=$groupData['name'] ?></h2>
      <center><h3><?=$groupData['description'] ?></h3></center>
      <div id='left-nav'> <?php include("$root/common/left-nav.php"); ?> </div>

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
          <a href="group_members.php?id=<?=$groupId?>">Group Members</a>
        </p>

<?php

//Cycle through users' list
foreach ($lists as $list) {

?>

  <br />
  <div>
    <h3><?=$list['name'] ?></h3>
    <table>

      <?php

      //Cycle through user' list
      foreach ($list['list'] as $item) {

      ?>

        <tr>
          <td>
            <?php

            if (strlen($item['reserved']['id']) > 0)
            {
              echo ("Reserved by ".$item['reserved']['name']);
            }
            else
            {

            ?>
              <form name='reserveItem' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId?>' method='post'>
                <input type='hidden' name='form' value='reserveItem' />
                <input type='hidden' name='user_id' value='<?=$list['id'] ?>' />
                <input type='hidden' name='item_id' value='<?=$item['id'] ?>' />
                <input type='submit' value='Reserve' class='submit' />
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
