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

}

class FormUtils
{
  static function generator($id, $name, $class, $title, $fields)
  {
    $php_self = $_SERVER['PHP_SELF'];
    $form = "<div id='regbox' class='$class'>
             <div class='small_title'>$title</div>
             <form name='$name' action='$php_self' method='post'>
             <input type='hidden' name='form' value='$name' />
             <input type='hidden' name='item_id' value='$id' />";

    foreach ($fields as $field)
    {
      if (isset($field["name"]))
        $form .= FormUtils::labeled_field($field["name"], $field["value"],
                                          $field["description"]);
      else
        $form .= "<p>". $field["value"] ."</p>";
    }

    $form .= "</form></div>";
    return $form;
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

  static function number($name)
  {
    return "<input type='number' class='form-control' name='$name'
                   min='0' placeholder='0' />";
  }

  static function checkbox($name, $value)
  {
    return "<input type='checkbox' name='$name' value='$value' />";
  }

  static function submit($value)
  {
    return "<input type='submit' class='btn btn-success submit' value='$value'/>";
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

}

?>