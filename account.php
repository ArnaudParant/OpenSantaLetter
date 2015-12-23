<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("common/top.php") ?>
    <div id='content'>
      <?php include("common/title.php") ?>
      <h2>Account</h2>
      <div id='left-nav'> <?php include("left-nav.php"); ?> </div>

      <div id='main'>
        Hey, <?=$loggedInUser->displayname ?>. Your title <?=$loggedInUser->title ?>. Registered this account on <?= date("M d, Y", $loggedInUser->signupTimeStamp()) ?>.
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
