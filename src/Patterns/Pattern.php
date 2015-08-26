<?php

namespace Labcoat\Patterns;

class Pattern implements PatternInterface {

  /**
   * @var PatternDataInterface[]
   */
  protected $data;

  protected $file;
  protected $includedPatterns;
  protected $name;
  protected $path;
  protected $pseudoPatterns;
  protected $state;
  protected $subType;
  protected $type;

  public static function isPartialName($name) {
    return false === strpos($name, '/');
  }

  public static function splitPartial($partial) {
    return explode('-', $partial, 2);
  }

  public static function splitPath($path) {
    $parts = explode('/', $path);
    if (count($parts) == 3) return $parts;
    if (count($parts) == 2) return [$parts[0], null, $parts[1]];
    throw new \InvalidArgumentException("Invalid path: $path");
  }

  public static function stripOrdering($str) {
    list($num, $name) = array_pad(explode('-', $str, 2), 2, null);
    return is_numeric($num) ? $name : $str;
  }

  public function __construct($path, $file) {
    $this->path = $path;
    $this->file = $file;
    list($this->type, $this->subType, $this->name) = self::splitPath($path);
    $this->extractState();
  }

  public function getData() {
    if (!isset($this->data)) $this->findData();
    return $this->data;
  }

  public function getFile() {
    return $this->file;
  }

  public function getIncludedPatterns() {
    if (!isset($this->includedPatterns)) $this->findIncludedPatterns();
    return $this->includedPatterns;
  }

  public function getName() {
    return $this->name;
  }

  public function getPartial() {
    return $this->getType() . '-' . $this->getName();
  }

  public function getPath() {
    return $this->path;
  }

  public function getPseudoPatterns() {
    if (!isset($this->pseudoPatterns)) $this->findData();
    return $this->pseudoPatterns;
  }

  public function getSubtype() {
    return $this->subType;
  }

  public function getType() {
    return $this->type;
  }

  public function getState() {
    return $this->state;
  }

  public function getStyleguidePathName() {
    return str_replace('/', '-', $this->getPath());
  }

  public function hasSubtype() {
    return !empty($this->subType);
  }

  protected function extractState() {
    if (false !== strpos($this->name, '@')) {
      list($this->name, $this->state) = explode('@', $this->name, 2);
    }
  }

  protected function findData() {
    $this->data = [];
    $this->pseudoPatterns = [];
    foreach (glob($this->getDataFilePattern()) as $path) {
      $name = basename($path, '.json');
      list (, $pseudoPattern) = array_pad(explode('~', $name, 2), 2, null);
      if (!empty($pseudoPattern)) {
        $this->pseudoPatterns[$pseudoPattern] = new PseudoPattern($this, $pseudoPattern, $path);
      }
      else {
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
          $this->includedPatterns[] = $tokens->next()->getValue();
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

  protected function getLineageMatch() {
    return '{%([ ]+)?include [&quot;\&#039;]([A-Za-z0-9-_]+)[&quot;\&#039;](.*)%}';
  }

  protected function getLineageMatchKey() {
    return 2;
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
}