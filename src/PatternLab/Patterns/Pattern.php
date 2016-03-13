<?php

namespace Labcoat\PatternLab\Patterns;

class Pattern implements PatternInterface {

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

  /**
   * @var string
   */
  protected $description = '';

  /**
   * @var string
   */
  protected $example = '';

  /**
   * @var string
   */
  protected $label;

  /**
   * @var PatternInterface[]
   */
  protected $lineage = [];

  /**
   * @var string
   */
  protected $name;

  /**
   * @var PatternInterface[]
   */
  protected $reverseLineage = [];

  /**
   * @var string
   */
  protected $state = '';

  /**
   * @var string
   */
  protected $subtype;

  /**
   * @var string
   */
  protected $template;

  /**
   * @var string
   */
  protected $type;

  /**
   * @param string $name
   * @param string $type
   * @param string|null $subtype
   */
  public function __construct($name, $type, $subtype = null) {
    $this->name = $name;
    $this->type = $type;
    $this->subtype = $subtype;
  }

  /**
   * @return string
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * @return string
   */
  public function getExample() {
    return $this->example;
  }

  /**
   * @return string
   */
  public function getLabel() {
    return $this->label ?: $this->makeLabel($this->getName());
  }

  /**
   * @return PatternInterface[]
   */
  public function getLineage() {
    return $this->lineage;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getPartial() {
    return $this->makePartial($this->getType(), $this->getName());
  }

  /**
   * @return PatternInterface[]
   */
  public function getReverseLineage() {
    return $this->reverseLineage;
  }

  /**
   * @return string
   */
  public function getState() {
    return $this->state;
  }

  /**
   * @return string
   */
  public function getSubtype() {
    return $this->subtype;
  }

  /**
   * @return string
   */
  public function getTemplate() {
    return $this->template;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @return bool
   */
  public function hasDescription() {
    return !empty($this->description);
  }

  /**
   * @return bool
   */
  public function hasLineage() {
    return !empty($this->lineage);
  }

  /**
   * @return bool
   */
  public function hasReverseLineage() {
    return !empty($this->reverseLineage);
  }

  /**
   * @return bool
   */
  public function hasState() {
    return !empty($this->state);
  }

  /**
   * @return bool
   */
  public function hasSubtype() {
    return !empty($this->subtype);
  }

  /**
   * @param string $description
   */
  public function setDescription($description) {
    $this->description = $description;
  }

  /**
   * @param string $example
   */
  public function setExample($example) {
    $this->example = $example;
  }

  /**
   * @param string $label
   */
  public function setLabel($label) {
    $this->label = $label;
  }

  /**
   * @param string $name
   */
  public function setName($name) {
    if (empty($name)) throw new \InvalidArgumentException("Name cannot be empty");
    $this->name = $name;
  }

  /**
   * @param string $state
   */
  public function setState($state) {
    $this->state = $state;
  }

  /**
   * @param string $subtype
   */
  public function setSubtype($subtype) {
    $this->subtype = $subtype;
  }

  /**
   * @param string $content
   */
  public function setTemplate($content) {
    $this->template = $content;
  }

  /**
   * @param string $type
   */
  public function setType($type) {
    if (empty($type)) throw new \InvalidArgumentException("Type cannot be empty");
    $this->type = $type;
  }
}