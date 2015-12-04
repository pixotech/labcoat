<?php

namespace Labcoat\Patterns;

use Labcoat\Data\DataInterface;
use Labcoat\PatternLabInterface;
use Labcoat\Patterns\Paths\Path;
use Labcoat\Patterns\Configuration\Configuration;
use Labcoat\Patterns\Configuration\ConfigurationInterface;

class Pattern implements PatternInterface {

  protected $configuration;
  protected $file;
  protected $includedPatterns;
  protected $path;

  /**
   * @var PatternLabInterface
   */
  protected $patternlab;

  protected $pseudoPatterns;
  protected $time;
  protected $valid;

  public static function isInclude(\Twig_Token $token) {
    return self::isNameToken($token) && in_array($token->getValue(), ['include', 'extend']);
  }

  public static function isNameToken(\Twig_Token $token) {
    return $token->getType() == \Twig_Token::NAME_TYPE;
  }

  public function __construct(PatternLabInterface $patternlab, $path, $file) {
    $this->patternlab = $patternlab;
    $this->path = new Path($path);
    $this->file = $file;
    $this->parseTemplate();
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
    return $this->path->join('-');
  }

  public function getIncludedPatterns() {
    return $this->includedPatterns;
  }

  public function getLabel() {
    return $this->path->normalize()->getName()->capitalized();
  }

  /**
   * @return Paths\Name
   */
  public function getName() {
    return $this->path->getName();
  }

  public function getNormalizedPath() {
    return $this->getPath()->normalize();
  }

  public function getPagePath() {
    $id = $this->getId();
    return "$id/$id.html";
  }

  public function getPartial() {
    return $this->path->normalize()->getPartial();
  }

  public function getPath() {
    return $this->path;
  }

  /**
   * @return PseudoPatternInterface
   */
  public function getPseudoPatterns() {
    return $this->pseudoPatterns;
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

  public function getTemplateNames() {
    return [
      (string)$this->getNormalizedPath(),
      (string)$this->getPartial(),
    ];
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

  public function hasTemplateName($name) {
    return in_array($name, $this->getTemplateNames());
  }

  public function hasType() {
    return $this->path->hasType();
  }

  public function includes(PatternInterface $pattern) {
    foreach ($this->includedPatterns as $included) {
      if ($included == $pattern->getPartial()) return true;
      if ($included == (string)$pattern->getPath()) return true;
    }
    return false;
  }

  public function render(DataInterface $data = NULL) {
    return $this->patternlab->render($this, $data);
  }

  public function setConfiguration(ConfigurationInterface $configuration) {
    $this->configuration = $configuration;
  }

  protected function findData() {
    foreach (glob($this->getDataFilePattern()) as $path) {
      $name = basename($path, '.json');
      list (, $pseudoPattern) = array_pad(explode('~', $name, 2), 2, null);
      if (!empty($pseudoPattern)) {
        $this->pseudoPatterns[$pseudoPattern] = new PseudoPattern($this, $pseudoPattern, $path);
      }
      else {
        $this->dataFiles[] = $path;
      }
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

  protected function parseTemplate() {
    $this->valid = true;
    $this->includedPatterns = [];
    try {
      $tokens = $this->getTemplateTokens();
      while (!$tokens->isEOF()) {
        $token = $tokens->next();
        if (self::isInclude($token)) {
          $next = $tokens->next()->getValue();
          if ($next == '(') $next = $tokens->next()->getValue();
          $this->includedPatterns[] = $next;
        }
      }
    }
    catch (\Twig_Error_Syntax $e) {
      $this->valid = false;
    }
  }
}