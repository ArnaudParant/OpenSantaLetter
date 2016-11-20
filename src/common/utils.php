<?php

class Utils
{
  static function icon($name, $click)
  {
    return "<span class=\"icon icon-$name\" onClick=\"$click\"></span>";
  }

  static function icon_fa($name, $click)
  {
    return "<span class=\"icon fa fa-$name\" onClick=\"$click\"></span>";
  }

  static function table_line($header, $class, $cols)
  {
    $balise = "td";
    if ($header == true) { $balise = "th"; }

    $line = "<tr class='$class'>";
    foreach ($cols as $col)
    {
      if (is_array($col))
      {
        $class = $col["class"];
        $value = $col["value"];
        $line .= "<$balise class='$class'>$value</$balise>";
      }
      else
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
      $selected = "";
      if ($option["selected"]) $selected = "selected";
      $value = $option["value"];
      $select .= "<option value='$value' $selected>$name</option>";
    }
    $select .= "</select>";
    return $select;
  }

  static function message_block($messages)
  {
    return resultBlock($messages["errors"], $messages["successes"]);
  }

  static function escape_special_char($str)
  {
    $found = array("'", '"');
    $replace = array("\'", '\"');
    return str_replace($found, $replace, $str);
  }

  static function safe_get($get, $name)
  {
    if (isset($get[$name]) && strlen($get[$name]) > 0) return $get[$name];
    return NULL;
  }

}

class FormUtils
{
  static function generator($id, $name, $class, $title, $fields)
  {
    $form = "<div id='regbox' class='$class'>
             <div class='small_title'>$title</div>";
    $form .= self::open($name, $_SERVER['PHP_SELF'], "post");
    $form .= self::hidden("form", $name);
    $form .= self::hidden("item_id", $id);

    foreach ($fields as $field)
    {
      if (is_array($field))
      {
        if (isset($field["name"]))
        {
           $form .= FormUtils::labeled_field($field["name"], $field["value"],
                                             $field["description"]);
        }
        else
           $form .= "<p>". $field["value"] ."</p>";
      }
      else
        $form .= "<p>$field</p>";
    }

    $form .= self::close();
    $form .= "</div>";
    return $form;
  }

  static function form($name, $action, $method, $fields)
  {
    $form = self::open($name, $action, $method);
    if ($method == "post") $form .= self::hidden("form", $name);
    foreach ($fields as $field) { $form .= $field; }
    $form .= self::close();
    return $form;
  }

  static function open($name, $action, $method)
  {
    return "<form name='$name' action='$action' method='$method'>";
  }

  static function close()
  {
    return "</form>";
  }

  static function labeled_field($name, $value, $description)
  {
    if ($description) $description = "<span class='description'>$description</span>";
    return "<p><label>$name</label>$value $description</p>";
  }

  static function text($name)
  {
    return "<input type='text' class='form-control' name='$name' />";
  }

  static function hidden($name, $value)
  {
    return "<input type='hidden' name='$name' value='$value' />";
  }

  static function number($name, $value)
  {
    return "<input type='number' class='form-control'
                   name='$name' value='$value'
                   min='0' placeholder='0' />";
  }

  static function checkbox($name, $value)
  {
    return "<input type='checkbox' name='$name' value='$value' />";
  }

  static function submit($class, $value)
  {
    return "<input type='submit' class='btn $class submit' value='$value'/>";
  }

}

class UserUtils
{
  static function redirect_if_not_logged_in($root)
  {
    if (!isUserLoggedIn()) { header("Location: $root/login.php"); die(); }
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
    if ($second_hand >= 1) { return Utils::icon("check green"); }
    return Utils::icon("cancel");
  }

  static function types_options($value)
  {
    return [
       array("value" => "", "name" => "-"),
       array("value" => "food", "name" => lang("FOOD"),
             "selected" => $value == "food"),
       array("value" => "item_book", "name" => lang("ITEM_BOOK"),
             "selected" => $value == "item_book"),
       array("value" => "music", "name" => lang("MUSIC"),
             "selected" => $value == "music"),
       array("value" => "movie", "name" => lang("MOVIE"),
             "selected" => $value == "movie"),
       array("value" => "game", "name" => lang("GAME"),
             "selected" => $value == "game"),
       array("value" => "high-tech", "name" => lang("HIGH-TECH"),
             "selected" => $value == "high-tech"),
       array("value" => "home-appliance", "name" => lang("HOME-APPLIANCE"),
             "selected" => $value == "home-appliance"),
       array("value" => "clothes", "name" => lang("CLOTHES"),
             "selected" => $value == "clothes"),
       array("value" => "accessory", "name" => lang("ACCESSORY"),
             "selected" => $value == "accessory"),
       array("value" => "decoration", "name" => lang("DECORATION"),
             "selected" => $value == "decoration"),
       array("value" => "other", "name" => lang("OTHER"),
             "selected" => $value == "other")
    ];
  }

}

?>