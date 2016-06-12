<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("$root/models/header.php");

$location = "/user/index.php";

?>

<body>
  <div id='wrapper'>
    <?php include("$root/common/top.php") ?>
    <div id='content'>
      <?php include("$root/common/title.php") ?>
      <h2>Account</h2>
      <div id='left-nav'> <?php include("$root/common/left-nav.php"); ?> </div>

      <div id='main'>
        Hey, <?=$loggedInUser->displayname ?>.
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
