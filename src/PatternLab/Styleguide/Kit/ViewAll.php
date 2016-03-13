<?php

namespace Labcoat\PatternLab\Styleguide\Kit;

use Labcoat\Html\Element;
use Labcoat\PatternLab\Styleguide\Kit\Partials\PatternSection;
use Labcoat\PatternLab\Styleguide\Types\TypeInterface;

class ViewAll {

  protected $type = [];

  public function __construct(TypeInterface $type) {
    $this->type = $type;
  }

  public function __toString() {
    $viewAll  = $this->getContainer();
    $viewAll .= $this->getScript();
    return $viewAll;
  }

  public function getContainer() {
    $patterns = $this->getPatternsContainer();
    return new Element('div', ['class' => 'sg-main', 'role' => 'main'], $patterns);
  }

  public function getPartial() {
    return $this->type->getPartial();
  }

  public function getPatternSections() {
    $patterns = [];
    foreach ($this->getPatterns() as $pattern) $patterns[] = new PatternSection($pattern);
    return $patterns;
  }

  public function getPatterns() {
    return $this->type->getPatterns();
  }

  public function getPatternsContainer() {
    $patterns = implode('', $this->getPatternSections());
    return new Element('div', ['id' => 'sg-patterns'], $patterns);
  }

  public function getScript() {
    return new Element('script', [], $this->getScriptContent());
  }

  public function getScriptContent() {
    $content  = $this->getScriptVariable('patternPartial', $this->getPartial());
    $content .= $this->getScriptVariable('lineage', '');
    return $content;
  }

  public function getScriptVariable($name, $value) {
    return "var $name = \"$value\";";
  }
}