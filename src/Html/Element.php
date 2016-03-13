<?php

namespace Labcoat\Html;

class Element implements ElementInterface {

  /**
   * @var array
   */
  protected $attributes = [];

  /**
   * @var mixed
   */
  protected $content;

  /**
   * @var string
   */
  protected $name;

  public function __construct($name, $attributes = [], $content = null) {
    $this->name = $name;
    $this->attributes = $attributes;
    $this->content = $content;
  }

  public function __toString() {
    $element = $this->makeOpeningTag();
    if (!$this->isSelfClosing()) $element .= $this->getContent() . $this->makeClosingTag();
    return $element;
  }

  /**
   * @return array
   */
  public function getAttributes() {
    return $this->attributes;
  }

  /**
   * @return mixed
   */
  public function getContent() {
    return $this->content;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return bool
   */
  public function isSelfClosing() {
    $tags = explode(' ', 'area base br col command embed hr img input keygen link meta param source track wbr');
    return in_array($this->getName(), $tags);
  }

  /**
   * @param array $attributes
   */
  public function setAttributes($attributes) {
    $this->attributes = $attributes;
  }

  /**
   * @param mixed $content
   */
  public function setContent($content) {
    $this->content = $content;
  }

  /**
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  protected function hasAttributes() {
    return !empty($this->attributes);
  }

  protected function makeAttributeString($key, $value) {
    return sprintf('%s="%s"', $key, htmlentities($value));
  }

  protected function makeAttributesString() {
    $string = '';
    if ($this->hasAttributes()) {
      $attributes = $this->getAttributes();
      $keys = array_keys($attributes);
      $values = array_values($attributes);
      $string .= ' ' . implode(' ', array_map([$this, 'makeAttributeString'], $keys, $values));
    }
    return $string;
  }

  protected function makeClosingTag() {
    return '</' . $this->getName() . '>';
  }

  protected function makeOpeningTag() {
    return '<' . $this->getName() . $this->makeAttributesString()  . '>';
  }
}