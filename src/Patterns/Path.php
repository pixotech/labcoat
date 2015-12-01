<?php

namespace Labcoat\Patterns;

class Path implements PathInterface {

  /**
   * @var string
   */
  protected $path;

  protected $slug;
  protected $state;
  protected $subtype;
  protected $type;

  /**
   * Remove ordering digits from a path segment
   *
   * @param string $str A path segment
   * @return string The path without any ordering digits
   */
  public static function stripDigits($str) {
    list($num, $name) = array_pad(explode('-', $str, 2), 2, NULL);
    return is_numeric($num) ? $name : $str;
  }

  public function __construct($path) {
    $this->path = $path;
    if (false !== strpos($this->path, '@')) {
      list($this->path, $this->state) = explode('@', $this->path, 2);
    }
    $segments = array_map([__CLASS__, 'stripDigits'], explode(DIRECTORY_SEPARATOR, $this->path));
    if (count($segments) > 1) {
      $this->type = array_shift($segments);
    }
    if (count($segments) > 1) {
      $this->subtype = array_shift($segments);
    }
    $this->slug = implode('--', $segments);
  }

  public function __toString() {
    return (string)$this->path;
  }

  /**
   * @return string
   */
  public function getPartial() {
    return !empty($this->type) ? "{$this->type}-{$this->slug}" : $this->slug;
  }

  /**
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * @return string
   */
  public function getSlug() {
    return $this->slug;
  }

  /**
   * @return string|null
   */
  public function getState() {
    return $this->state;
  }

  /**
   * @return string|null
   */
  public function getSubtype() {
    return $this->subtype;
  }

  /**
   * @return string|null
   */
  public function getType() {
    return $this->type;
  }
}