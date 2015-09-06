<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternInterface as SourcePatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class Pattern implements \JsonSerializable, PatternInterface {

  protected $content;
  protected $data;
  protected $file;
  protected $id;

  /**
   * @var PatternInterface[]
   */
  protected $includedPatterns = [];

  /**
   * @var PatternInterface[]
   */
  protected $includingPatterns = [];

  protected $includes;
  protected $lineagePath;
  protected $name;
  protected $partial;
  protected $pagePath;
  protected $path;
  protected $sourcePath;
  protected $state;
  protected $template;
  protected $templatePath;
  protected $time;
  protected $type;

  public static function makeBreadcrumb($path) {
    $func = function ($segment) {
      return str_replace('-', ' ', PatternLab::stripDigits($segment));
    };
    $segments = array_map($func, explode('/', $path));
    return implode(' &gt; ', array_slice($segments, 0, -1));
  }

  public static function makeName($name) {
    return ucwords(str_replace('-', ' ', $name));
  }

  public function __construct(StyleguideInterface $styleguide, SourcePatternInterface $pattern) {
    $this->styleguide = $styleguide;
    $this->file = $pattern->getFile();
    $this->id = $pattern->getId();
    $this->partial = $pattern->getPartial();
    $this->state = $pattern->getState();
    $this->template = $pattern->getTemplate();
    $this->time = $pattern->getTime();

    $this->name = self::makeName($pattern->getName());
    $this->breadcrumb = self::makeBreadcrumb($pattern->getPath());

    $this->makePaths($pattern);

    $this->includes = $pattern->getIncludedPatterns();
  }

  public function addIncludedPattern(PatternInterface $pattern) {
    $this->includedPatterns[$pattern->getId()] = $pattern;
  }

  public function addIncludingPattern(PatternInterface $pattern) {
    $this->includingPatterns[$pattern->getId()] = $pattern;
  }

  public function getBreadcrumb() {
    return $this->breadcrumb;
  }

  public function getContent() {
    if (!isset($this->content)) {
      $this->content = $this->styleguide->renderPattern($this, $this->getData());
    }
    return $this->content;
  }

  public function getData() {
    if (!isset($this->data)) $this->makeData();
    return $this->data;
  }

  public function getId() {
    return $this->id;
  }

  public function getIncludedPatterns() {
    return $this->includes;
  }

  public function getLineagePath() {
    return $this->lineagePath;
  }

  public function getName() {
    return $this->name;
  }

  public function getFile() {
    return $this->file;
  }

  public function getPagePath() {
    return $this->pagePath;
  }

  public function getPartial() {
    return $this->partial;
  }

  /**
   * @return mixed
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * @return string
   */
  public function getSourcePath() {
    return $this->sourcePath;
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
  public function getTemplatePath() {
    return $this->templatePath;
  }

  public function getTime() {
    return $this->time;
  }

  public function jsonSerialize() {
    $data = [
      'cssEnabled' => false,
      'lineage' => $this->patternLineages(),
      'lineageR' => $this->patternLineagesR(),
      'patternBreadcrumb' => $this->getBreadcrumb(),
      'patternDesc' => $this->patternDesc(),
      'patternExtension' => 'twig',
      'patternName' => $this->name,
      'patternPartial' => $this->partial,
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
    return $this->path;
  }

  public function patternName() {
    return $this->name;
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

  /**
   * @return \Labcoat\PatternLabInterface
   */
  protected function getPatternLab() {
    return $this->styleguide->getPatternLab();
  }

  protected function makeData() {
    $data = $this->styleguide->getGlobalData();
    $source = $this->getPatternLab()->getPattern($this->getId());
    foreach ($source->getData() as $patternData) {
      $data = array_replace_recursive($data, $patternData->getData());
    }
    $this->data = $data;
  }

  protected function makePaths(SourcePatternInterface $pattern) {
    $path = preg_replace('|[/~]|', '-', $pattern->getPath());
    $this->path = PatternLab::makePath([$path, "$path.html"]);
    $this->pagePath = PatternLab::makePath(['patterns', $this->path]);
    $this->sourcePath = PatternLab::makePath(['patterns', $path, "$path.escaped.html"]);
    $this->templatePath = PatternLab::makePath(['patterns', $path, "$path.twig"]);
    $this->lineagePath = PatternLab::makePath(['..', '..', $this->pagePath]);
  }
}
