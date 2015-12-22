<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

?>

<body>
  <div id='wrapper'>
    <div id='top'><div id='logo'></div></div>
    <div id='content'>

      <h1>OpenSantaLeter</h1>
      <h2>0.01</h2>

      <div id='left-nav'>
        <?php include("left-nav.php"); ?>
      </div>

      <div id='main'>
        <p>OpenSantaLetter is an open source and free of charge project.</p>
        <p>The goal is to offer an easy way to manager Chritmas (or birthday) wishes list into a familly or a group of friends.</p>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
