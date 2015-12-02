<?php

namespace Labcoat\Patterns;

use Labcoat\Patterns\Paths\Path;
use Labcoat\Patterns\Configuration\Configuration;
use Labcoat\Patterns\Configuration\ConfigurationInterface;

class Pattern implements PatternInterface {

  use HasDataTrait;

  protected $configuration;
  protected $file;
  protected $includedPatterns;
  protected $path;
  protected $pseudoPatterns;
  protected $time;

  public function __construct($path, $file) {
    $this->path = new Path($path);
    $this->file = $file;
    $this->id = $path;
    $this->findData();
  }

  public function getConfiguration() {
    if (!isset($this->configuration)) $this->makeConfiguration();
    return $this->configuration;
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

  /**
   * @return Paths\Name
   */
  public function getName() {
    return $this->path->getName();
  }

  public function getPartial() {
    return $this->path->getPartial();
  }

  public function getPath() {
    return $this->path;
  }

  /**
   * @return PseudoPatternInterface
   */
  public function getPseudoPatterns() {
    return $this->items;
  }

  public function getSlug() {
    return $this->path->getName();
  }

  public function getState() {
    return $this->getConfiguration()->hasState() ? $this->getConfiguration()->getState() : '';
  }

  public function getSubtype() {
    return $this->path->getSubtype();
  }

  public function getTemplate() {
    return $this->getPath();
  }

  public function getTime() {
    if (!isset($this->time)) {
      $this->time = max(filemtime($this->file), $this->getDataTime());
    }
    return $this->time;
  }

  public function getType() {
    return $this->path->getType();
  }

  public function hasSubtype() {
    return $this->path->hasSubtype();
  }

  public function hasType() {
    return $this->path->hasType();
  }

  public function setConfiguration(ConfigurationInterface $configuration) {
    $this->configuration = $configuration;
  }

  protected function findData() {
    foreach (glob($this->getDataFilePattern()) as $path) {
      $name = basename($path, '.json');
      list (, $pseudoPattern) = array_pad(explode('~', $name, 2), 2, null);
      if (!empty($pseudoPattern)) {
        $this->items[$pseudoPattern] = new PseudoPattern($this, $pseudoPattern, $path);
      }
      else {
        $this->dataFiles[] = $path;
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

  protected function getConfigurationData() {
    return json_decode(file_get_contents($this->getConfigurationPath()), true);
  }

  protected function getConfigurationPath() {
    return dirname($this->file) . DIRECTORY_SEPARATOR . basename($this->path) . '.pattern.json';
  }

  protected function getDataFilePattern() {
    return dirname($this->file) . DIRECTORY_SEPARATOR . basename($this->path) . '*.json';
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

  protected function hasConfiguration() {
    return file_exists($this->getConfigurationPath());
  }

  protected function makeConfiguration() {
    $data = $this->hasConfiguration() ? $this->getConfigurationData() : [];
    $this->configuration = new Configuration($data);
  }
}