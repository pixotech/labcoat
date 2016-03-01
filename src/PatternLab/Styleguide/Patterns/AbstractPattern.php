<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\PatternLab\PatternLab;

abstract class AbstractPattern implements PatternInterface {

  /**
   * @var string
   */
  protected $example;

  /**
   * @var PatternRendererInterface
   */
  protected $renderer;

  /**
   * @param PatternRendererInterface $renderer
   */
  public function __construct(PatternRendererInterface $renderer) {
    $this->renderer = $renderer;
  }

  /**
   * @return string
   */
  public function getId() {
    return str_replace(DIRECTORY_SEPARATOR, '-', $this->getPath());
  }

  /**
   * @return string
   */
  public function getPartial() {
    $type = PatternLab::stripOrdering($this->getType());
    return $type . '-' . $this->getName();
  }
}