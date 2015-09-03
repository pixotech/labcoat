<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\Patterns\PatternInterface as SourcePatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class Pattern implements \JsonSerializable, PatternInterface {

  protected $file;
  protected $id;
  protected $name;
  protected $partial;
  protected $path;
  protected $state;
  protected $subtype;
  protected $template;
  protected $type;

  public function __construct(SourcePatternInterface $pattern) {
    $this->file = $pattern->getFile();
    $this->id = $pattern->getId();
    $this->name = $pattern->getName();
    $this->partial = $pattern->getPartial();
    $this->path = $pattern->getPath();
    $this->state = $pattern->getState();
    $this->subtype = $pattern->hasSubType() ? $pattern->getSubTypeId() : null;
    $this->template = $pattern->getTemplate();
    $this->type = $pattern->getTypeId();
    #$this->includes = $pattern->getIncludedPatterns();
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getFile() {
    return $this->file;
  }

  public function getFilePath($extension) {
    $path = str_replace('/', '-', $this->getPath());
    return ['patterns', $path, "$path.$extension"];
  }

  public function getPath() {
    return $this->path;
  }

  /**
   * @return string
   */
  public function getTemplate() {
    return $this->template;
  }

  public function jsonSerialize() {
    $data = [
      'cssEnabled' => false,
      'lineage' => $this->patternLineages(),
      'lineageR' => $this->patternLineagesR(),
      'patternBreadcrumb' => $this->getBreadcrumb(),
      'patternDesc' => $this->patternDesc(),
      'patternExtension' => 'twig',
      'patternName' => $this->patternName(),
      'patternPartial' => $this->patternPartial(),
      'patternState' => $this->state,
      'extraOutput' => [],
    ];
    return $data;
  }

  public function patternCSS() {
    return null;
  }

  public function patternCSSExists() {
    return false;
  }

  public function patternDesc() {
    return "";
  }

  public function patternDescAdditions() {
    return [];
  }

  public function patternDescExists() {
    return false;
  }

  public function patternEngineName() {
    return "Twig";
  }

  public function patternExampleAdditions() {
    return [];
  }

  public function patternLineageExists() {
    return false;
  }

  public function patternLineageEExists() {
    return false;
  }

  public function patternLineageRExists() {
    return false;
  }

  public function patternLineages() {
    return [];
  }

  public function patternLineagesR() {
    return [];
  }

  public function patternLink() {
    return $this->getPath();
  }

  public function patternName() {
    return ucwords(str_replace('-', ' ', $this->name));
  }

  public function patternPartial() {
    return $this->partial;
  }

  public function patternPartialCode() {
  }

  public function patternPartialCodeE() {
    return '';
  }

  public function patternSectionSubtype() {
    return false;
  }

  protected function getBreadcrumb() {
    $crumb = [$this->type];
    if ($this->subtype) $crumb[] = $this->subtype;
    return implode(' &gt; ', $crumb);
  }
}
