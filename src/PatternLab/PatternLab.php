<?php

namespace Labcoat\PatternLab;

class PatternLab implements PatternLabInterface {

  public static function makeLabel($str) {
    return ucwords(trim(preg_replace('/[-_]+/', ' ', static::stripOrdering($str))));
  }

  public static function makePartial($type, $name) {
    return static::stripOrdering($type) . '-' . static::stripOrdering($name);
  }

  public static function stripOrdering($str) {
    list($ordering, $ordered) = array_pad(explode('-', $str, 2), 2, null);
    return is_numeric($ordering) ? $ordered : $str;
  }
}