<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$location = "/user/list.php";

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if(!empty($_POST))
{

  $errors = array();
  $successes = array();
  $form = $_POST["form"];

  if ($form == "addItem")
  {

    $second_hand = 0;
    if (isset($_POST["second_hand"])) $second_hand = 1;

    $price = 0;
    if (strlen($_POST["price"]) > 0) $price = $_POST["price"];

    $item = array(
      "type" => $_POST["type"],
      "name" => $_POST["name"],
      "price" => $price,
      "second_hand" => $second_hand,
      "description" => $_POST["description"]);
    $added = addUserListItem($loggedInUser->user_id, $item);

    if ($added) {
      $successes[] = lang("USERLIST_ITEM_ADDED");
    } else {
      $errors[] = lang("USERLIST_ITEM_ADD_FAILED");
    }


  }
  else if ($form == "deleteItem")
  {
    $item_id = $_POST["item_id"];

    $deleted = deleteUserListItem($loggedInUser->user_id, $item_id);

    if ($deleted) {
      $successes[] = lang("USERLIST_ITEM_DELETED");
    } else {
      $errors[] = lang("USERLIST_ITEM_DELETE_FAILED");
    }

  }

}

class Utils
{
  static function icon($name)
  {
    return "<span class=\"icon icon-$name\"></span>";
  }

  static function icon_fa($name)
  {
    return "<span class=\"icon fa fa-$name\"></span>";
  }

  static function table_line($header, $cols)
  {
    $balise = "td";
    if ($header == true) { $balise = "th"; }

    $line = "<tr>";
    foreach ($cols as $col)
    {
      $line .= "<$balise>$col</$balise>";
    }
    $line .= "</tr>";
    return $line;
  }

  static function select($name, $options)
  {
    $select = "<select name='$name'>";
    foreach ($options as $option)
    {
      $name = $option["name"];
      $value = $option["value"];
      $select .= "<option value='$value'>$name</option>";
    }
    $select .= "</select>";
    return $select;
  }
}

class ItemUtils
{
  static function type($type)
  {
    if ($type == null) { return ""; }
    return lang(strtoupper($type));
  }

  static function second_hand($second_hand)
  {
    if ($second_hand >= 1) { return Utils::icon("check"); }
    return Utils::icon("cancel");
  }

}

class Item
{
  private static function delete_action($id)
  {
    $php_self = $_SERVER['PHP_SELF'];
    $icon_cancel = Utils::icon("cancel");
    return (
      "<form name='deleteItem' id='item_$id' action='$php_self' method='post'>
         <input type='hidden' name='form' value='deleteItem' />
         <input type='hidden' name='item_id' value='$id' />
         <button type='button' class='btn btn-danger' onClick='submiter('$id');'>
           $icon_cancel
         </button>
       </form>");
  }

  private static function header()
  {
    $cols = [lang("DELETE"),
             lang("TYPE"),
             lang("NAME"),
             lang("PRICE"),
             lang("SECOND_HAND"),
             lang("DESCRIPTION")];
    echo Utils::table_line(true, $cols);
  }

  private static function display($item)
  {
    $cols = [Item::delete_action($item["id"]),
             ItemUtils::type($item["type"]),
             $item['name'],
             $item['price'],
             ItemUtils::second_hand($item["second_hand"]),
             $item['description']];
    echo Utils::table_line(false, $cols);
  }

  static function table($items)
  {
    if (count($items) > 0)
    {
      echo "<table class='table table-striped'>";
      Item::header();
      foreach ($items as $item) { Item::display($item); }
      echo "</table>";
    }
    else
    {
      echo ("<div>" .lang("USERLIST_EMPTY") . "</div>");
    }
  }

  static function select()
  {
    $options = [
       array("value" => "", "name" => "-"),
       array("value" => "food", "name" => lang("FOOD")),
       array("value" => "item_book", "name" => lang("ITEM_BOOK")),
       array("value" => "music", "name" => lang("MUSIC")),
       array("value" => "movie", "name" => lang("MOVIE")),
       array("value" => "game", "name" => lang("GAME")),
       array("value" => "high-tech", "name" => lang("HIGH-TECH")),
       array("value" => "home-appliance", "name" => lang("HOME-APPLIANCE")),
       array("value" => "clothes", "name" => lang("CLOTHES")),
       array("value" => "accessory", "name" => lang("ACCESSORY")),
       array("value" => "decoration", "name" => lang("DECORATION")),
       array("value" => "other", "name" => lang("OTHER"))
    ];
    return Utils::select("type", $options);
  }
}

$items = fetchUserList($loggedInUser->user_id);

?>

<? require_once("$path/models/header.php"); ?>
<body>
  <script>
   function submiter(item_id)
   {
     document.getElementById("item_" + item_id).submit();
   }
  </script>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2><?= lang("NAV_MY_LIST") ?></h2>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>

        <?= resultBlock($errors,$successes); ?>

        <?= Item::table($items) ?>

        <div id='regbox' class='add-item-box'>

          <div class="small_title"><?= lang("BOX_ITEM_ADD_NAME") ?></div>

          <form name='addItem' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>

            <input type='hidden' name='form' value='addItem' />

            <p>
              <label><?= lang("TYPE") ?></label>
              <?= Item::select() ?>
            </p>

            <p>
              <label><?= lang("NAME") ?></label>
              <input type='text' class="form-control" name='name' />
            </p>

            <p>
              <label><?= lang("PRICE") ?></label>
              <input type='number' class="form-control" name='price'
                     min="0" placeholder="0" />
            </p>

            <p>
              <label><?= lang("SECOND_HAND") ?></label>
              <input type='checkbox' name='second_hand' value="1" />
            </p>


            <p>
              <label><?= lang("DESCRIPTION") ?></label>
              <input type='text' class="form-control" name='description' />
            </p>

            <p>
              <input type='submit' class="btn btn-success"
                     value='<?= lang("ADD") ?>'
                     class='submit' />
            </p>

          </form>

        </div>


      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
