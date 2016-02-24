<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\PatternLab;
use Labcoat\PatternLab\Name;
use Labcoat\PatternLab\PatternInterface as SourceInterface;

class Pattern extends AbstractPattern {

  protected $includedPatterns = [];

  protected $source;

  protected $time;

  protected $valid;

  public static function isIncludeToken(\Twig_Token $token) {
    return self::isNameToken($token) && in_array($token->getValue(), ['include', 'extend']);
  }

  public static function isNameToken(\Twig_Token $token) {
    return $token->getType() == \Twig_Token::NAME_TYPE;
  }

  public function __construct(SourceInterface $source, PatternRendererInterface $renderer) {
    parent::__construct($renderer);
    $this->source = $source;
  }

  public function getData() {
    return $this->source->getData();
  }

  public function getDescription() {
    return $this->source->getDescription();
  }

  public function getFile() {
    return $this->source->getFile();
  }

  public function getIncludedPatterns() {
    $included = [];
    foreach ($this->includedPatterns as $pattern) {
      #$included[] = $this->patternlab->get($pattern);
    }
    return $included;
  }

  public function getIncludingPatterns() {
    return [];
  }

  public function getLabel() {
    return $this->source->getLabel();
  }

  /**
   * @return Name
   */
  public function getName() {
    return new Name($this->source->getName());
  }

  public function getPath() {
    return $this->source->getPath();
  }

  public function getState() {
    return $this->source->getState();
  }

  public function getSubtype() {
    return new Name($this->source->getSubtype());
  }

  public function getTemplate() {
    return $this->source->getPath();
  }

  public function getTemplateNames() {
    return [
      (string)$this->getPath()->normalize(),
      (string)$this->getPartial(),
    ];
  }

  public function getTime() {
    return filemtime($this->getFile());
  }

  public function getType() {
    return new Name($this->source->getType());
  }

  public function hasState() {
    return false;
  }

  public function hasSubtype() {
    return $this->source->hasSubtype();
  }

  public function includes(PatternInterface $pattern) {
    foreach ($this->includedPatterns as $included) {
      if ($included == $pattern->getPartial()) return true;
      if ($included == (string)$pattern->getPath()) return true;
    }
    return false;
  }

  public function matches($name) {
    if (PatternLab::isPartialName($name)) return $name == $this->getPartial();
    else return (string)PatternLab::normalizePath($name) == (string)PatternLab::normalizePath($this->getPath());
  }

  /**
   * @return \Twig_TokenStream
   * @throws \Twig_Error_Syntax
   */
  protected function getTemplateTokens() {
    $template = file_get_contents($this->getFile());
    $lexer = new \Twig_Lexer(new \Twig_Environment());
    return $lexer->tokenize($template);
  }

  protected function parseTemplate() {
    $this->valid = true;
    $this->includedPatterns = [];
    try {
      $tokens = $this->getTemplateTokens();
      while (!$tokens->isEOF()) {
        $token = $tokens->next();
        if (self::isIncludeToken($token)) {
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