<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

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

require_once("$root/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$root/common/top.php") ?>
    <div id='content'>
      <?php include("$root/common/title.php") ?>
      <h2>Groups</h2>
      <div id='left-nav'> <?php include("$root/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <div><a href="create_group.php">Create a group</a></div><br />

        <table>
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
        <input type='submit' value='X' class='submit' />
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
