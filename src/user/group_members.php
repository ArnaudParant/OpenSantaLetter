<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/user/index.php";

$groupId = $_GET['id'];

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

//Fetch member of specific group
$permissions_id = fetchMemberPermission($groupId, $loggedInUser->user_id);
$admin = false;
if ($permissions_id == 2) { $admin = true; }

if($admin and !empty($_POST))
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

require_once("$path/models/header.php");

?>

<body>
<script>
  function submiter(user_id)
  {
    document.getElementById("user_" + user_id).submit();
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
          <a href="group_list.php?id=<?=$groupId?>">
            <button class="btn btn-info"><?= lang("NAV_GROUP_LIST") ?></button>
          </a>
        </p>

        <?php if ($admin) { ?>
        <div id='regbox'>

          <form name='addUser' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId ?>' method='post'>
            <p>
              <input type='hidden' name='form' value='addUser' />
              <input type='text' class="form-control" name='email' placeholder="<?= lang("PLACEHOLDER_USER_EMAIL") ?>" />
              <input type='submit' class="btn btn-success" value='<?= lang("INVITE") ?>' class='submit' />
            </p>
          </form>

        </div>
        <?php } ?>

        <table class="table table-striped">
          <tr>
            <?php if ($admin) { echo "<th>". lang("UNSUBSCRIBE") ."</th>"; } ?>
            <th><?= lang("NAME") ?></th><th><?= lang("PERMISSIONS") ?></th>
          </tr>
<?php

//Cycle through users data
foreach ($memberData as $member) {

?>

  <tr>
    <?php if ($admin) { ?>
    <td>
      <form name='deleteUser' id='user_<?= $member['id'] ?>'
            action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId ?>' method='post'>
        <input type='hidden' name='form' value='deleteUser' />
        <input type='hidden' name='userId' value='<?=$member['id'] ?>' />
        <button type="button" class="btn btn-danger"
                onClick="submiter('<?= $member['id'] ?>');">
          <span class="icon-cancel"></span>
        </button>
      </form>
    </td>
    <?php } ?>
    <td><?=$member['name'] ?></td>
    <td><?=$member['permissions'] ?></td>
  </tr>

<?php

}

?>
        </table>

        <?php if ($admin) { ?>
        <div id='regbox'>

          <form name='deleteGroup' action='<?= $_SERVER['PHP_SELF'] ?>?id=<?=$groupId ?>' method='post'>
            <p>
              <input type='hidden' name='form' value='deleteGroup' />
              <input type='submit' class="btn btn-danger" value='<?= lang("DELETE")?>' class='submit' /> the group definitively.
            </p>
          </form>

        </div>
        <?php } ?>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
