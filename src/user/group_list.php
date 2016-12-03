<?php

$path = dirname(dirname(__FILE__));
require_once("$path/models/config.php");
require_once("$path/common/utils.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

$location = "/user/index.php";

if(!empty($_POST))
{

  $errors = array();
  $successes = array();
  $form = $_POST["form"];

  $user_id = $_POST["user_id"];
  $item_id = $_POST["item_id"];

  if ($form == "bookItem")
  {
    $booked = bookItem($user_id, $item_id, $loggedInUser->user_id, $loggedInUser->username);
    if ($booked) {
      $successes[] = lang("USERLIST_ITEM_BOOKED");
    } else {
      $errors[] = lang("USERLIST_ITEM_BOOK_FAILED");
    }
  }
  else if ($form == "unbookItem")
  {
    $unbooked = unbookItem($user_id, $item_id, $loggedInUser->user_id, $loggedInUser->username);
    if ($unbooked) {
      $successes[] = lang("USERLIST_ITEM_UNBOOKED");
    } else {
      $errors[] = lang("USERLIST_ITEM_UNBOOK_FAILED");
    }
  }
}

class Search
{
  static function user_select($user_id, $value, $members)
  {
    $options = [array("value"=>"","name"=>"-")];
    foreach ($members as $member)
    {
      if ($member["id"] != $user_id)
        $options[] = array("value" => $member["name"],
                           "name" => $member["name"],
                           "selected" => $value == $member["name"]);
    }
    return Utils::select("username", $options);
  }

  static function type_select($value)
  {
    return Utils::select("type", ItemUtils::types_options($value));
  }

  static function second_hand_select($value)
  {
    $options = array(
      array("value"=>"", "name"=>"-"),
      array("value"=>"1", "name"=>lang("YES"), "selected" => $value == 1),
      array("value"=>"0", "name"=>lang("NO"), "selected" => $value == 0 && $value != NULL)
    );
    return Utils::select("second_hand", $options);
  }

  static function price_select($value)
  {
    return FormUtils::number("price", $value);
  }

  static function button()
  {
    $icon = Utils::icon("search");
    $value = lang("SEARCH");
    return "<button class='btn btn-info'>$icon $value</button>";
  }
}

class GroupList
{
  static function table($user_id, $group_id, $members, $search, $items)
  {
    $table  = "<table class='table table-striped group-list-table'>";
    $table .= self::header();
    $table .= self::search_line($user_id, $group_id, $members, $search);
    foreach ($items as $item)
    {
      $table .= self::display($user_id, $group_id, $search, $item);
    }
    $table .= "</table>";

    return $table;
  }

  private static function header()
  {
    $cols = [lang("USERNAME"),
             lang("TYPE"),
             lang("NAME"),
             lang("PRICE"),
             lang("SECOND_HAND"),
             lang("DESCRIPTION"),
             array("value" => lang("ACTION"), "class" => "text-right")];
    return Utils::table_line(true, "header", $cols);
  }

  private static function search_line($user_id, $group_id, $members, $search)
  {
    $cols = [Search::user_select($user_id, $search["username"], $members),
             Search::type_select($search["type"]),
             NULL,
             Search::price_select($search["price"]),
             Search::second_hand_select($search["second_hand"]),
             NULL,
             array("value" => Search::button(), "class" => "text-right")];

    $fields = [FormUtils::hidden("id", $group_id),
               Utils::table_line(true, "search-line", $cols)];
    return FormUtils::form("search", $url, "get", $fields);
  }

  private static function display($user_id, $group_id, $search, $item)
  {
    $cols = [$item['user']["name"],
             ItemUtils::type($item["type"]),
             $item['name'],
             $item['price'],
             ItemUtils::second_hand($item["second_hand"]),
             TextUtils::url_manager($item["description"]),
             array("value" => self::book_form($user_id, $group_id, $search, $item),
                   "class" => "text-right")];
    return Utils::table_line(false, NULL, $cols);
  }

  private static function book_form($user_id, $group_id, $search, $item)
  {
    $php_self = $_SERVER['PHP_SELF'];
    $url = "$php_self?id=$group_id";
    if ($search["username"] != NULL)
      $url .= "&username=". $search["username"];
    if ($search["type"] != NULL)
      $url .= "&type=". $search["type"];
    if ($search["price"] != NULL)
      $url .= "&price". $search["price"];
    if ($search["second_hand"] != NULL)
      $url .= "&second_hand=". $search["second_hand"];

    $item_user_id = $item['user']["id"];
    $item_id = $item['id'];

    if (strlen($item['booked']['id']) > 0)
    {
      if ($item['booked']['id'] != $user_id)
      {
        return "<div class='booked'>". lang("BOOKED") ."</div>";
      }
      else
      {
        $fields = [FormUtils::hidden("user_id", $item_user_id),
                   FormUtils::hidden("item_id", $item_id),
                   FormUtils::submit("btn-warning", lang("UNBOOK"))];
        return FormUtils::form("unbookItem", $url, "post", $fields);
      }
    }

    $fields = [FormUtils::hidden("user_id", $item_user_id),
               FormUtils::hidden("item_id", $item_id),
               FormUtils::submit("btn-success", lang("BOOK"))];
    return FormUtils::form("bookItem", $url, "post", $fields);
  }

}

$groupId = $_GET['id'];
$groupData = fetchGroupDetail($loggedInUser->user_id, $groupId);
$members = fetchGroupMember($groupId);

$search = array(
  "username" => Utils::safe_get($_GET, "username"),
  "type" => Utils::safe_get($_GET, "type"),
  "price" => Utils::safe_get($_GET, "price"),
  "second_hand" => Utils::safe_get($_GET, "second_hand"),
);

$list = fetchGroupList($loggedInUser->user_id, $groupData['id'], $search);

require_once("$path/models/header.php");

?>

<body>
  <div id='wrapper'>
    <?php include("$path/common/top.php") ?>
    <div id='content'>
      <?php include("$path/common/title.php") ?>
      <h2><?= lang("GROUP") ?> <?=$groupData['name'] ?></h2>
      <center><h3><?=$groupData['description'] ?></h3></center>
      <div id='left-nav'> <?php include("$path/common/left-nav.php"); ?> </div>

      <div id='main'>

<?php

 if (!$groupData)
 {
  echo "<div class='error'>". lang("GROUP_INVALID_ID") ."</div>";
  die();
 }

?>

        <?= resultBlock($errors, $successes); ?>

        <p class="right">
          <a href="group_members.php?id=<?=$groupId?>">
            <button class="btn btn-info"><?= lang("NAV_GROUP_MEMBERS") ?></button>
          </a>
        </p>

        <div class="panel-group" id="group_list" role="tablist" aria-multiselectable="true">

        <?= GroupList::table($loggedInUser->user_id, $groupId, $members, $search, $list); ?>

        </div>
      </div>
      <div id='bottom'></div>
    </div>
</body>
</html>
