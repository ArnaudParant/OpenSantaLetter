<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

$items = fetchList($loggedInUser->user_id);

require_once("$root/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$root/common/top.php") ?>
    <div id='content'>
      <?php include("$root/common/title.php") ?>
      <h2>My List</h2>
      <div id='left-nav'> <?php include("$root/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <table>
          <tr>
            <th>Delete</th><th>Item</th><th>Description</th>
          </tr>
<?php

//Cycle through users data
foreach ($items as $item) {

?>

  <tr>
    <td></td>
    <td><?=$item['name'] ?></td>
    <td><?=$item['description'] ?></td>
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
