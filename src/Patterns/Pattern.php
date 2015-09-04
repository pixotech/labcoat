<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLab;

class Pattern implements \Countable, \RecursiveIterator, PatternInterface {
  use HasChildItems;

  /**
   * @var PatternDataInterface[]
   */
  protected $data;

  protected $dataFiles;

  protected $file;
  protected $id;
  protected $includedPatterns;
  protected $name;
  protected $nameWithDashes;
  protected $nameWithDashesWithoutDigits;
  protected $partial;
  protected $pseudoPatterns;
  protected $state;
  protected $subType;
  protected $type;

  public function __construct($id, $file) {
    $this->id = $id;
    $this->file = $file;
    list($this->type, $this->subType, $this->name) = PatternLab::splitPath($id);
    $this->extractState();
    $this->makePartial();
    $this->findData();
  }

  public function getData() {
    if (!isset($this->data)) $this->findData();
    return $this->data;
  }

  public function getDataFiles() {
    if (!isset($this->dataFiles)) $this->findData();
    return $this->dataFiles;
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
  }

  public function getIncludedPatterns() {
    if (!isset($this->includedPatterns)) $this->findIncludedPatterns();
    return $this->includedPatterns;
  }

  public function getName() {
    return $this->name;
  }

  public function getPartial() {
    return $this->partial;
  }

  public function getPath() {
    return $this->id;
  }

  /**
   * @return PseudoPatternInterface
   */
  public function getPseudoPatterns() {
    if (!isset($this->pseudoPatterns)) $this->findData();
    return $this->pseudoPatterns;
  }

  public function getState() {
    return $this->state ?: '';
  }

  public function getSubType() {
    return $this->subType;
  }

  public function getSubTypeId() {
    return $this->type . '/' . $this->subType;
  }

  public function getTemplate() {
    return $this->getPath();
  }

  public function getTime() {
    $time = filemtime($this->file);
    // Check data file
    return $time;
  }

  public function getType() {
    return $this->type;
  }

  public function getTypeId() {
    return $this->type;
  }

  public function hasSubType() {
    return !empty($this->subType);
  }

  protected function extractState() {
    if (false !== strpos($this->name, '@')) {
      list($this->name, $this->state) = explode('@', $this->name, 2);
    }
  }

  protected function findData() {
    $this->data = [];
    $this->dataFiles = [];
    $this->pseudoPatterns = [];
    foreach (glob($this->getDataFilePattern()) as $path) {
      $name = basename($path, '.json');
      list (, $pseudoPattern) = array_pad(explode('~', $name, 2), 2, null);
      if (!empty($pseudoPattern)) {
        $this->pseudoPatterns[$pseudoPattern] = new PseudoPattern($this, $pseudoPattern, $path);
        $this->items[$pseudoPattern] = $this->pseudoPatterns[$pseudoPattern];
      }
      else {
        $this->dataFiles[] = $path;
        $this->data[] = new PatternData($path);
      }
    }
  }

  protected function findIncludedPatterns() {
    $this->includedPatterns = [];
    try {
      $tokens = $this->getTemplateTokens();
      while (!$tokens->isEOF()) {
        $token = $tokens->next();
        if ($token->getType() == \Twig_Token::NAME_TYPE && in_array($token->getValue(), ['include', 'extend'])) {
          $next = $tokens->next()->getValue();
          if ($next == '(') $next = $tokens->next()->getValue();
          $this->includedPatterns[] = $next;
        }
      }
    }
    catch (\Twig_Error_Syntax $e) {
      // Template syntax error
    }
  }

  protected function getDataFilePattern() {
    return dirname($this->file) . DIRECTORY_SEPARATOR . $this->name . '*.json';
  }

  /**
   * @return \Twig_TokenStream
   * @throws \Twig_Error_Syntax
   */
  protected function getTemplateTokens() {
    $template = file_get_contents($this->file);
    $lexer = new \Twig_Lexer(new \Twig_Environment());
    return $lexer->tokenize($template);
  }

  protected function makePartial() {
    $this->partial = PatternLab::stripDigits($this->type) . '-' . PatternLab::stripDigits($this->name);
  }
}