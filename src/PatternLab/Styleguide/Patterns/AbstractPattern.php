<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

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
  public function getExample() {
    if (!isset($this->example)) $this->example = $this->makeExample();
    return $this->example;
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
    return implode('-', [$this->getType(), $this->getName()]);
  }

  /**
   * @return array
   */
  protected function getTemplateVariables() {
    return $this->getData();
  }

  /**
   * @return string
   */
  protected function makeExample() {
    return $this->renderer->render($this->getTemplate(), $this->getTemplateVariables());
  }
}