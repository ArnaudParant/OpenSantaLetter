<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("$root/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php require_once("$root/common/top.php"); ?>
    <div id='content'>

      <?php require_once("$root/common/title.php"); ?>
      <h2>version 0.01</h2>

      <div id='left-nav'>
        <?php include("$root/common/left-nav.php"); ?>
      </div>

      <div id='main'>
        <p>OpenSantaLetter is an open source and free of charge project.</p>
        <p>The goal is to offer an easy way to manager Chritmas (or birthday) wishes list into a familly or a group of friends.</p>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
