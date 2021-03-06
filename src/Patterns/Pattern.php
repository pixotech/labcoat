<?php

namespace Labcoat\Patterns;

use Labcoat\HasItemsInterface;
use Labcoat\HasItemsTrait;
use Labcoat\Item;
use Labcoat\ItemInterface;

class Pattern extends Item implements \Countable, HasDataInterface, HasItemsInterface, PatternInterface {

  use HasDataTrait;
  use HasItemsTrait;

  protected $file;
  protected $includedPatterns;
  protected $partial;
  protected $pseudoPatterns;
  protected $state;
  protected $time;

  public function __construct($path, $file) {
    $this->path = $path;
    $this->file = $file;
    $this->id = $path;
    $this->extractState();
    $this->makePartial();
    $this->findData();
  }

  public function add(ItemInterface $item) {
    if ($item instanceof PseudoPatternInterface) {
      $this->items[$item->getVariantName()] = $item;
    }
    else {
      throw new \InvalidArgumentException();
    }
  }

  public function getFile() {
    return $this->file;
  }

  public function getIncludedPatterns() {
    if (!isset($this->includedPatterns)) $this->findIncludedPatterns();
    return $this->includedPatterns;
  }

  public function getPartial() {
    return $this->partial;
  }

  /**
   * @return PseudoPatternInterface
   */
  public function getPseudoPatterns() {
    return $this->items;
  }

  public function getState() {
    return $this->state ?: '';
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

  protected function extractState() {
    if (false !== strpos($this->path, '@')) {
      list($this->path, $this->state) = explode('@', $this->path, 2);
    }
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

  protected function makePartial() {
    $parts = explode('/', $this->getNormalizedPath());
    $this->partial = implode('-', [array_shift($parts), array_pop($parts)]);
  }
}