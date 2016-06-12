<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/user/groups.php";

$groupId = $_GET['id'];

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if(!empty($_POST))
{

  $errors = array();
  $successes = array();
  $form = $_POST["form"];

  if ($form == "addUser")
  {

    $email = trim($_POST["email"]);

    if(!isValidEmail($email))
    {
      $errors[] = lang("ACCOUNT_INVALID_EMAIL");
    }

    if(count($errors) == 0)
    {
      $user_id = userIdOfEmail($email);
      if (empty($user_id))
      {
        $errors[] = lang("GROUP_UNKNOWN_EMAIL");
      }
      else
      {
        $added = addGroupMember($groupId, $user_id, 1);

        if ($added) {
          $successes[] = lang("GROUP_USER_ADDED");
        } else {
          $errors[] = lang("GROUP_USER_ADD_FAILED");
        }
      }
    }

  }
  else if ($form == "deleteUser")
  {
    $user_id = $_POST["userId"];
    $deleted = deleteGroupMember($groupId, $user_id);

    if ($deleted) {
      $successes[] = lang("GROUP_USER_UNSUBSCRIBE");
    } else {
      $errors[] = lang("GROUP_USER_UNSUBSCRIBE_FAILED");
    }
  }
  else if ($form == "deleteGroup")
  {
    $deleted = deleteGroup($groupId);

    if ($deleted) {
      $successes[] = lang("GROUP_DELETED");
    } else {
      $errors[] = lang("GROUP_DELETE_FAILED");
    }
  }

}

//Fetch information of specific group
$groupData = fetchGroupDetail($loggedInUser->user_id, $groupId);

//Fetch member of specific group
$memberData = fetchGroupMember($groupId);

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
          <a href="group_list.php?id=<?=$groupId?>">Group List</a>
        </p>

        <div id='regbox'>

          <form name='addUser' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId ?>' method='post'>
            <p>
              <input type='hidden' name='form' value='addUser' />
              <input type='text' class="form-control" name='email' placeholder="user email" />
              <input type='submit' class="btn btn-success" value='Invite' class='submit' />
            </p>
          </form>

        </div>


        <table class="table table-striped">
          <tr>
            <th>Unsubscribe</th><th>Name</th><th>Permissions</th>
          </tr>
<?php

//Cycle through users data
foreach ($memberData as $member) {

?>

  <tr>
    <td>
      <form name='deleteUser' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId ?>' method='post'>
        <input type='hidden' name='form' value='deleteUser' />
        <input type='hidden' name='userId' value='<?=$member['id'] ?>' />
        <input type='submit' class="btn btn-danger" value='X' class='submit' />
      </form>
    </td>
    <td><?=$member['name'] ?></td>
    <td><?=$member['permissions'] ?></td>
  </tr>

<?php

}

?>
        </table>

        <div id='regbox'>

          <form name='deleteGroup' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId ?>' method='post'>
            <p>
              <input type='hidden' name='form' value='deleteGroup' />
              <input type='submit' class="btn btn-danger" value='Delete' class='submit' /> the group definitively.
            </p>
          </form>

        </div>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
