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

  /**
   * @return string
   */
  public function getDescription() {
    return '';
  }

  /**
   * @return string
   */
  public function getFile() {
    return $this->getTemplate()->getFile()->getPathname();
  }

  /**
   * @return string
   */
  public function getLabel() {
    return ucfirst($this->getName());
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->getTemplate()->getName();
  }

  /**
   * @return string
   */
  public function getPath() {
    return $this->getTemplate()->getId();
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

  /**
   * @return string
   */
  public function getState() {
    return '';
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