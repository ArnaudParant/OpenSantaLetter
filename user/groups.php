<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

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
        
        <table>
          <tr>
            <th>Unsubscribe</th><th>Name</th><th>Description</th><th>Permissions</th>
          </tr>
<?php

//Cycle through groups
foreach ($groupData as $v1) {
	echo "
	<tr>
	<td><input type='checkbox' name='unsubscribe[".$v1['id']."]' id='unsubscribe[".$v1['id']."]' value='".$v1['id']."'></td>
	<td><a href='group.php?id=".$v1['id']."'>".$v1['name']."</a></td>
	<td>".$v1['description']."</td>
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
