<?php

namespace Labcoat\PatternLab;

class PatternLab implements PatternLabInterface {

  public static function makeLabel($str) {
    return ucwords(trim(preg_replace('/[-_]+/', ' ', static::stripOrdering($str))));
  }

  public static function makePartial($type, $name) {
    return static::stripOrdering($type) . '-' . static::stripOrdering($name);
  }

  public static function splitPath($path) {
    $segments = explode('/', $path);
    if (count($segments) < 2) throw new \DomainException("Invalid pattern path");
    $name = array_pop($segments);
    $type = array_shift($segments);
    $subtype = !empty($segments) ? array_shift($segments) : null;
    return [$name, $type, $subtype];
  }

  public static function stripOrdering($str) {
    list($ordering, $ordered) = array_pad(explode('-', $str, 2), 2, null);
    return is_numeric($ordering) ? $ordered : $str;
  }
}