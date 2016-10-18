<?php

/* ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL); */

$path = dirname(dirname(__FILE__));
$root = preg_replace("/\/+/", "/", $_SERVER['DOCUMENT_ROOT']);
$uri = str_replace($root, "", $path);

require_once("$path/models/config.php");
require_once("$path/common/utils.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$location = "/user/list.php";

//Prevent the user visiting the logged in page if he is not logged in
UserUtils::redirect_if_not_logged_in($uri);

class FormManager
{
  static function sender($user_id, $post)
  {
    if(empty($post)) return null;

    $messages = array("errors" => array(), "successes" => array());

    if ($post["form"] == "addItem") return self::add_item($user_id, $post);
    else if ($post["form"] == "deleteItem") return self::delete_item($user_id, $post);

    return null;
  }

  static function add_item($user_id, $post)
  {
    $second_hand = 0;
    if (isset($post["second_hand"])) $second_hand = 1;

    $price = 0;
    if (strlen($post["price"]) > 0) $price = $post["price"];

    $item = array(
      "type" => $post["type"],
      "name" => $post["name"],
      "price" => $price,
      "second_hand" => $second_hand,
      "description" => $post["description"]);
    $added = addUserListItem($user_id, $item);

    if ($added) return array("successes" => array(lang("USERLIST_ITEM_ADDED")));
    return array("errors" => array(lang("USERLIST_ITEM_ADD_FAILED")));
  }

  static function delete_item($user_id, $post)
  {
    $deleted = deleteUserListItem($user_id, $post["item_id"]);

    if ($deleted) return array("successes" => array(lang("USERLIST_ITEM_DELETED")));
    return array("errors" => array(lang("USERLIST_ITEM_DELETE_FAILED")));
  }
}

class Item
{
  static function table($items)
  {
    if (count($items) > 0)
    {
      echo "<table class='table table-striped item-user-list'>";
      self::header();
      foreach ($items as $item) { Item::display($item); }
      echo "</table>";
    }
    else
    {
      echo ("<div>" .lang("USERLIST_EMPTY") . "</div>");
    }
  }

  private static function header()
  {
    $cols = [lang("ACTION"),
             lang("TYPE"),
             lang("NAME"),
             lang("PRICE"),
             lang("SECOND_HAND"),
             lang("DESCRIPTION"),
             lang("DELETE")];
    echo Utils::table_line(true, $cols);
  }

  private static function display($item)
  {
    $cols = [self::edit($item["id"]),
             ItemUtils::type($item["type"]),
             $item['name'],
             $item['price'],
             ItemUtils::second_hand($item["second_hand"]),
             $item['description'],
             self::delete($item["id"])];
    echo Utils::table_line(false, $cols);
  }

  private static function edit($id)
  {
    $php_self = $_SERVER['PHP_SELF'];
    $icon = Utils::icon("pencil edit");
    return "<div>$icon</div>";
  }

  private static function delete($id)
  {
    $php_self = $_SERVER['PHP_SELF'];
    $icon = Utils::icon("erase delete", "submiter('$id')");
    return (
      "<form name='deleteItem' id='item_$id' action='$php_self' method='post'>
         <input type='hidden' name='form' value='deleteItem' />
         <input type='hidden' name='item_id' value='$id' />
         $icon
       </form>");
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

  static function form()
  {
    $name = "addItem";
    $class = "add-item-box";
    $title = lang("BOX_ITEM_ADD_NAME");
    $submit_text = lang("ADD");

    $fields = array(
       array("name" => lang("TYPE"), "value" => self::select()),
       array("name" => lang("NAME"), "value" => FormUtils::text("name")),
       array("name" => lang("PRICE"), "value" => FormUtils::number("price")),
       array("name" => lang("SECOND_HAND"),
             "value" => FormUtils::checkbox("second_hand", 1)),
       array("name" => lang("DECORATION"), "value" => FormUtils::text("description")),
       array("value" => FormUtils::submit($submit_text))
    );

    return FormUtils::generator($name, $class, $title, $fields);
  }

}

$messages = FormManager::sender($loggedInUser->user_id, $_POST);
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

        <?= Utils::message_block($messages) ?>

        <?= Item::table($items) ?>

        <?= Item::form() ?>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
