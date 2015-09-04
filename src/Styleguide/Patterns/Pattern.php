<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternInterface as SourcePatternInterface;
use Labcoat\Patterns\PseudoPatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class Pattern implements \JsonSerializable, PatternInterface {

  protected $content;
  protected $data;
  protected $file;
  protected $id;
  protected $includedPatterns = [];
  protected $includingPatterns = [];
  protected $includes;
  protected $isPseudo = false;
  protected $name;
  protected $parentId;
  protected $partial;
  protected $path;
  protected $state;
  protected $subtype;
  protected $template;
  protected $type;
  protected $variant;

  public function __construct(StyleguideInterface $styleguide, SourcePatternInterface $pattern) {
    $this->styleguide = $styleguide;
    $this->file = $pattern->getFile();
    $this->id = $pattern->getId();
    $this->name = $pattern->getName();
    $this->partial = $pattern->getPartial();
    $this->path = $pattern->getPath();
    $this->state = $pattern->getState();
    $this->subtype = $pattern->hasSubType() ? $pattern->getSubTypeId() : null;
    $this->template = $pattern->getTemplate();
    $this->type = $pattern->getTypeId();

    if ($pattern instanceof PseudoPatternInterface) {
      $this->isPseudo = true;
      $this->parentId = $pattern->getPattern()->getId();
      $this->variant = $pattern->getVariantName();
    }

    $this->includes = $pattern->getIncludedPatterns();
  }

  public function addIncludedPattern(PatternInterface $pattern) {
    $this->includedPatterns[$pattern->getId()] = $pattern;
  }

  public function addIncludingPattern(PatternInterface $pattern) {
    $this->includingPatterns[$pattern->getId()] = $pattern;
  }

  public function getContent() {
    if (!isset($this->content)) {
      $this->content = $this->styleguide->renderPattern($this, $this->getData());
    }
    return $this->content;
  }

  public function getData() {
    if (!isset($this->data)) {
      if ($this->isPseudo()) {
        $parent = $this->getPatternLab()->getPattern($this->getParentId());
        $source = $parent->getPseudoPatterns()[$this->getVariantName()];
        $data = $this->styleguide->getPattern($this->getParentId())->getData();
        $data = array_replace_recursive($data, $source->getData()->getData());
      }
      else {
        $data = $this->styleguide->getGlobalData();
        $source = $this->getPatternLab()->getPattern($this->getId());
        foreach ($source->getData() as $patternData) {
          $data = array_replace_recursive($data, $patternData->getData());
        }
      }
      $this->data = $data;
    }
    return $this->data;
  }

  public function getId() {
    return $this->id;
  }

  public function getIncludedPatterns() {
    return $this->includes;
  }

  public function getLineagePath() {
    $path = $this->getFilePath('html');
    array_unshift($path, '..');
    array_unshift($path, '..');
    return PatternLab::makePath($path);
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

  public function getParentId() {
    return $this->parentId;
  }

  public function getPartial() {
    return $this->partial;
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

  /**
   * @return string
   */
  public function getVariantName() {
    return $this->variant;
  }

  public function isPseudo() {
    return $this->isPseudo;
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
    return !empty($this->includedPatterns);
  }

  public function patternLineageEExists() {
    return false;
  }

  public function patternLineageRExists() {
    return !empty($this->includingPatterns);
  }

  public function patternLineages() {
    $patterns = [];
    foreach ($this->includedPatterns as $pattern) {
      $patterns[] = [
        'lineagePattern' => $pattern->getPartial(),
        'lineagePath' => $pattern->getLineagePath(),
      ];
    }
    return $patterns;
  }

  public function patternLineagesR() {
    $patterns = [];
    foreach ($this->includingPatterns as $pattern) {
      $patterns[] = [
        'lineagePattern' => $pattern->getPartial(),
        'lineagePath' => $pattern->getLineagePath(),
      ];
    }
    return $patterns;
  }

  public function patternLink() {
    return $this->name . DIRECTORY_SEPARATOR . $this->name . '.html';
  }

  public function patternName() {
    return ucwords(str_replace('-', ' ', $this->name));
  }

  public function patternPartial() {
    return $this->partial;
  }

  public function patternPartialCode() {
    return $this->getContent();
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

  /**
   * @return \Labcoat\PatternLabInterface
   */
  protected function getPatternLab() {
    return $this->styleguide->getPatternLab();
  }
}
