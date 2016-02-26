<?php

namespace Labcoat\PatternLab\Patterns;

class PseudoPattern implements PseudoPatternInterface {

  /**
   * @var array
   */
  protected $data;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var PatternInterface
   */
  protected $pattern;

  public function __construct(PatternInterface $pattern, $name, array $data) {
    $this->pattern = $pattern;
    $this->name = $name;
    $this->data = $data;
  }

  /**
   * @return array
   */
  public function getData() {
    return $this->data;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return PatternInterface
   */
  public function getPattern() {
    return $this->pattern;
  }
}