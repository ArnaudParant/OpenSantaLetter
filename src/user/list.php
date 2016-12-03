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
    else if ($post["form"] == "editItem") return self::edit_item($user_id, $post);
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

  static function edit_item($user_id, $post)
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
    $added = editUserListItem($user_id, $post["item_id"], $item);

    if ($added) return array("successes" => array(lang("USERLIST_ITEM_EDITED")));
    return array("errors" => array(lang("USERLIST_ITEM_EDIT_FAILED")));
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
      foreach ($items as $item) { self::display($item); }
      echo "</table>";
    }
    else
    {
      echo ("<div>" .lang("USERLIST_EMPTY") . "</div>");
    }
  }

  static function add_form()
  {
    return self::form("addItem", lang("BOX_ITEM_ADD_NAME"), lang("ADD"), false);
  }

  static function edit_form()
  {
    return self::form("editItem", lang("BOX_ITEM_EDIT_NAME"), lang("EDIT"), true);
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
    echo Utils::table_line(true, "", $cols);
  }

  private static function display($item)
  {
    $cols = [self::edit($item),
             ItemUtils::type($item["type"]),
             $item['name'],
             $item['price'],
             ItemUtils::second_hand($item["second_hand"]),
             TextUtils::url_manager($item["description"]),
             self::delete($item["id"])];
    echo Utils::table_line(false, "", $cols);
  }

  private static function edit($item)
  {
    $php_self = $_SERVER['PHP_SELF'];
    $icon = Utils::icon("pencil edit", null);
    $name = Utils::escape_special_char($item['name']);
    $type = Utils::escape_special_char(strtolower($item["type"]));
    $description = Utils::escape_special_char($item['description']);
    $click = "editer('{$item['id']}', '{$type}', '{$name}', '{$item['price']}', '{$item['second_hand']}', '{$description}');";
    return "<div onClick=\"$click\">$icon</div>";
  }

  private static function delete($id)
  {
    $php_self = $_SERVER['PHP_SELF'];
    $icon = Utils::icon("erase delete", "submiter('$id');");
    return (
      "<form name='deleteItem' id='item_$id' action='$php_self' method='post'>
         <input type='hidden' name='form' value='deleteItem' />
         <input type='hidden' name='item_id' value='$id' />
         $icon
       </form>");
  }

  private static function close_control()
  {
    $icon = Utils::icon("cancel-circled action", "close_editer();");
    return "<span class='right'>$icon</span>";
  }

  private static function form($name, $title, $submit_text, $closable)
  {
    $class = "add-item-box";
    if ($closable) { $title .= self::close_control(); }

    $fields = [
       array("name" => lang("TYPE"), "value" => self::type_select()),
       array("name" => lang("NAME"), "value" => FormUtils::text("name")),
       array("name" => lang("PRICE"), "value" => FormUtils::number("price", NULL),
             "description" => lang("DESCRIPTION_ESTIMATED_PRICE")),
       array("name" => lang("SECOND_HAND"),
             "value" => FormUtils::checkbox("second_hand", 1)),
       array("name" => lang("DESCRIPTION"),"value" => FormUtils::text("description")),
       FormUtils::submit("btn-success", $submit_text)];

    return FormUtils::generator(null, $name, $class, $title, $fields);
  }

  private static function type_select()
  {
    return Utils::select("type", ItemUtils::types_options(NULL));
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
   function close_editer()
   {
     var box = document.getElementById("edit-box");
     box.style.visibility = "hidden";
   }
   function editer(id, type, name, price, second_hand, description)
   {
     var box = document.getElementById("edit-box");
     var inputs = box.getElementsByTagName("input");
     inputs[1].value = id;
     box.getElementsByTagName("select")[0].value = type;
     inputs[2].value = name;
     inputs[3].value = price;
     inputs[4].checked = (second_hand >= 1);
     inputs[5].value = description;
     box.style.visibility = "visible";
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

        <?= Item::add_form() ?>

        <div class="over" id="edit-box">
          <div class="opacity" onClick="close_editer();"></div>
          <div class="content"><?= Item::edit_form() ?></div>
        </div>

      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
