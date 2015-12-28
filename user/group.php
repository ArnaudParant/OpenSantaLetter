<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$groupId = $_GET['id'];

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
        <table>
          <tr>
            <th>Delete</th><th>Name</th><th>Permissions</th>
          </tr>
<?php

//Cycle through users data
foreach ($memberData as $v1) {
  echo "
   <tr>
   <td><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></td>
   <td>".$v1['name']."</a></td>
   <td>".$v1['permissions']."</td>
   </tr>";
}

?>
        </table>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
