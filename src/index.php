<?php

/* ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL); */

$path = dirname(__FILE__);
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("$path/models/header.php");

$location = "/index.php";

?>

<body>
  <div id='wrapper'>
    <?php require_once("$path/common/top.php"); ?>
    <div id='content'>

      <?php require_once("$path/common/title.php"); ?>
      <h2><?= lang("VERSION") ?> 0.01</h2>

      <div id='left-nav'>
        <?php include("$path/common/left-nav.php"); ?>
      </div>

      <div id='main'>
        <p><?= lang("CONTENT_PRESENTATION") ?></p>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
