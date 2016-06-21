<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("$path/models/header.php");

$location = "/user/index.php";

?>

<body>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2>Account</h2>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>
        Hey, <?=$loggedInUser->displayname ?>.
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
