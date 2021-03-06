<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/user/index.php";

if(!empty($_POST))
{

  $errors = array();
  $successes = array();
  $group_id = $_POST["groupId"];
  $deleted = deleteGroupMember($group_id, $loggedInUser->user_id);

  if ($deleted) {
    $successes[] = lang("GROUP_USER_UNSUBSCRIBE");
  } else {
    $errors[] = lang("GROUP_USER_UNSUBSCRIBE_FAILED");
  }
}

//Fetch information of groups where the user is member
$groupData = fetchGroups($loggedInUser->user_id);

require_once("$path/models/header.php");

?>

<body>
<script>
  function submiter(group_id)
  {
    document.getElementById("group_" + group_id).submit();
  }
</script>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2><?= lang("NAV_MY_GROUPS") ?></h2>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <div><a href="create_group.php">
          <button class="btn btn-info"><?= lang("NAV_GROUP_CREATION") ?></button>
        </a></div>
        <br />

<?php if (count($groupData) > 0) { ?>

        <table class="table table-striped">
          <tr>
            <th><?= lang("UNSUBSCRIBE") ?></th>
            <th><?= lang("NAME") ?></th>
            <th><?= lang("DESCRIPTION") ?></th>
            <th><?= lang("PERMISSIONS") ?></th>
          </tr>
<?php

//Cycle through groups
foreach ($groupData as $group) {

?>
  <tr>
    <td>
      <form name='unsubscribe' id='group_<?= $group['id'] ?>'
            action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
        <input type='hidden' name='groupId' value='<?= $group['id'] ?>' />
        <button type="button" class="btn btn-danger"
                onClick="submiter('<?= $group['id'] ?>');">
          <span class="icon-cancel"></span>
        </button>
      </form>
    </td>
    <td><a href='group_list.php?id=<?= $group['id'] ?>'><?= $group['name'] ?></a></td>
    <td><?= $group['description'] ?></td>
    <td><?= $group['permissions'] ?></td>
  </tr>

<?php } ?>
        </table>
<?php } else { echo ("<div>".lang("GROUP_LIST_EMPTY")."</div>");} ?>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
