<?php

namespace Pixo\PatternLab\Patterns;

class Pattern implements PatternInterface {

  protected $file;
  protected $name;
  protected $subType;
  protected $template;
  protected $type;

  public static function isShorthand($name) {
    return false === strpos($name, '/');
  }

  public function __construct($template, \SplFileInfo $file) {
    $this->template = $template;
    $this->file = $file;
    $this->parseTemplateName();
  }

  public function getFile() {
    return $this->file;
  }

  public function getName() {
    return $this->name;
  }

  public function getShorthand() {
    return $this->type . '-' . $this->name;
  }

  public function getSubType() {
    return $this->subType;
  }

  public function getTemplate() {
    return $this->template;
  }

  public function getTemplateWithoutExtension() {
    return substr($this->template, 0, strrpos($this->template, '.'));
  }

  public function getType() {
    return $this->type;
  }

  public function matches($name) {
    if ($this->matchesTemplate($name)) return true;
    if ($this->matchesPartialTemplate($name)) return true;
    if ($this->matchesShorthand($name)) return true;
    if ($this->matchesPartialShorthand($name)) return true;
    return false;
  }

  public function matchesPartialShorthand($shorthand) {
    list($type, $name) = explode('-', $shorthand, 2);
    return $type == $this->type && !(false === strpos($this->name, $name));
  }

  public function matchesPartialTemplate($template) {
    return $template == $this->getTemplateWithoutExtension();
  }

  public function matchesShorthand($shorthand) {
    return $shorthand == $this->getShorthand();
  }

  public function matchesTemplate($template) {
    return $template == $this->getTemplate();
  }

  protected function parseTemplateName() {
    $parts = array_map(['\Pixo\PatternLab\PatternLab', 'stripNumbering'], explode(DIRECTORY_SEPARATOR, $this->getTemplateWithoutExtension()));
    $this->name = array_pop($parts);
    $this->type = array_shift($parts);
    if (!empty($parts)) $this->subType = array_shift($parts);
  }
}