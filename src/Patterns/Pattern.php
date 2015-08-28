<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLab;

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

  public function __construct($path, $file) {
    $this->path = $path;
    $this->file = $file;
    list($this->type, $this->subType, $this->name) = PatternLab::splitPath($path);
    $this->extractState();
  }

  public function getData() {
    if (!isset($this->data)) $this->findData();
    $data = [];
    foreach ($this->data as $d) $data = array_merge_recursive($data, $d->getData());
    return $data;
  }

  public function getDisplayName() {
    return ucwords(str_replace('-', ' ', $this->getName()));
  }

  public function getFile() {
    return $this->file;
  }

  public function getIncludedPatterns() {
    if (!isset($this->includedPatterns)) $this->findIncludedPatterns();
    return $this->includedPatterns;
  }

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithoutDigits());
  }

  public function getName() {
    return $this->name;
  }

  public function getNameWithoutDigits() {
    return PatternLab::stripDigits($this->name);
  }

  public function getPartial() {
    return PatternLab::stripDigits($this->getType()) . '-' . $this->getNameWithoutDigits();
  }

  public function getPath() {
    return $this->path;
  }

  public function getPseudoPatterns() {
    if (!isset($this->pseudoPatterns)) $this->findData();
    return $this->pseudoPatterns;
  }

  public function getState() {
    return $this->state ?: '';
  }

  public function getStyleguidePathName() {
    return str_replace('/', '-', $this->getPath());
  }

  public function getSubType() {
    return $this->subType;
  }

  public function getTemplate() {
    return $this->getPath();
  }

  public function getTemplateContent() {
    return file_get_contents($this->file);
  }

  public function getTime() {
    $time = filemtime($this->file);
    // Check data file
    return $time;
  }

  public function getType() {
    return $this->type;
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
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