<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/user/groups.php";

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
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2>Groups</h2>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <div><a href="create_group.php">
          <button class="btn btn-info">Create a group</button>
        </a></div>
        <br />

        <table class="table table-striped">
          <tr>
            <th>Unsubscribe</th><th>Name</th><th>Description</th><th>Permissions</th>
          </tr>
<?php

//Cycle through groups
foreach ($groupData as $group) {

?>
  <tr>
    <td>
      <form name='unsubscribe' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
        <input type='hidden' name='groupId' value='<?= $group['id'] ?>' />
        <input type='submit' class="btn btn-danger" value='X' class='submit' />
      </form>
    </td>
    <td><a href='group_list.php?id=<?= $group['id'] ?>'><?= $group['name'] ?></a></td>
    <td><?= $group['description'] ?></td>
    <td><?= $group['permissions'] ?></td>
  </tr>

<?php

}

?>
        </table>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
