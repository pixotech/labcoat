<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

class PatternRenderer {

  /**
   * @var array
   */
  protected $globalData;

  /**
   * @var \Twig_Environment
   */
  protected $parser;

  public function __construct(\Twig_Environment $parser, array $globalData = []) {
    $this->parser = $parser;
    $this->globalData = $globalData;
  }

  public function render($pattern, array $vars = []) {
    return $this->parser->render($pattern, $vars + $this->globalData);
  }
}