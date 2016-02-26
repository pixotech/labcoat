<?php

namespace Labcoat\PatternLab\Patterns;

use Labcoat\PatternLab\Templates\TemplateInterface;

class Pattern implements PatternInterface {

  /**
   * @var TemplateInterface
   */
  protected $template;

  /**
   * @param TemplateInterface $template
   */
  public function __construct(TemplateInterface $template) {
    $this->template = $template;
  }

  /**
   * @return array
   */
  public function getData() {
    return $this->getTemplate()->getData();
  }

  public function getDescription() {
    // TODO: Implement getDescription() method.
  }

  /**
   * @return string
   */
  public function getFile() {
    return $this->getTemplate()->getFile()->getPathname();
  }

  public function getLabel() {
    // TODO: Implement getLabel() method.
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->getTemplate()->getName();
  }

  public function getPath() {
    // TODO: Implement getPath() method.
  }

  /**
   * @return PseudoPattern[]
   */
  public function getPseudoPatterns() {
    $pseudoPatterns = [];
    foreach ($this->getTemplate()->getVariants() as $name => $data) {
      $pseudoPatterns[$name] = new PseudoPattern($this, $name, $data);
    }
    return $pseudoPatterns;
  }

  public function getState() {
    // TODO: Implement getState() method.
  }

  /**
   * @return string
   */
  public function getSubtype() {
    return $this->getTemplate()->getSubtype();
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->getTemplate()->getType();
  }

  /**
   * @return bool
   */
  public function hasSubtype() {
    return $this->getTemplate()->hasSubtype();
  }

  /**
   * @return TemplateInterface
   */
  protected function getTemplate() {
    return $this->template;
  }
}