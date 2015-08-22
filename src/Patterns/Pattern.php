<?php

namespace Labcoat\Patterns;

use Labcoat\Filesystem\FileInterface;
use Labcoat\PatternLabInterface;

class Pattern implements PatternInterface {

  protected $file;
  protected $name;
  protected $path;
  protected $subType;
  protected $template;
  protected $templateWithoutExtension;
  protected $type;

  public static function isShorthand($name) {
    return false === strpos($name, '/');
  }

  public function __construct(PatternLabInterface $patternlab, FileInterface $file) {
    $this->template = $file->getPath();
    $this->templateWithoutExtension = $file->getPathWithoutExtension();
    $this->file = $file->getFullPath();
    $this->parseTemplateName();
  }

  public function getData() {
    return json_decode(file_get_contents($this->getDataFilePath()), true);
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
    return $this->templateWithoutExtension;
  }

  public function getType() {
    return $this->type;
  }

  public function hasData() {
    return is_file($this->getDataFilePath());
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

  protected function getDataFilePath() {
    $dir = substr($this->getFile()->getPathname(), 0, 0 - strlen($this->template));
    return $dir . $this->getTemplateWithoutExtension() . '.json';
  }

  protected function parseTemplateName() {
    $parts = array_map(['\Labcoat\PatternLab', 'stripNumbering'], explode(DIRECTORY_SEPARATOR, $this->getTemplateWithoutExtension()));
    $this->path = implode('/', $parts);
    $this->name = array_pop($parts);
    $this->type = array_shift($parts);
    if (!empty($parts)) $this->subType = array_shift($parts);
  }
}