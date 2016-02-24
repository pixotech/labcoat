<?php

namespace Labcoat\Configuration;

use Labcoat\Data\Data;
use Labcoat\PatternLab\PatternInterface;
use Labcoat\PatternLab\PseudoPatternInterface;

class PseudoPattern implements PseudoPatternInterface {

  protected $data;

  protected $name;

  /**
   * @var PatternInterface
   */
  protected $pattern;

  public function __construct(PatternInterface $pattern, $name, $dataFile) {
    $this->pattern = $pattern;
    $this->name = $name;
    $this->data = Data::load($dataFile)->toArray();
  }

  public function getData() {
    return $this->data;
  }

  public function getName() {
    return $this->name;
  }

  public function getPattern() {
    return $this->pattern;
  }
}