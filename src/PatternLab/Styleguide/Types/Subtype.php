<?php

namespace Labcoat\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\Patterns\PatternInterface;

class Subtype extends Type implements SubtypeInterface {

  /**
   * @var TypeInterface
   */
  protected $type;

  /**
   * @param TypeInterface $type
   * @param string $name
   */
  public function __construct(TypeInterface $type, $name) {
    parent::__construct($name);
    $this->type = $type;
  }

  /**
   * @param PatternInterface $pattern
   */
  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  /*
   * @return string
   */
  public function getPartial() {
    return 'viewall-' . $this->type->getName() . '-' . $this->getName();
  }

  /**
   * @return string
   */
  public function getStyleguideDirectoryName() {
    return $this->type->getStyleguideDirectoryName() .'-' . $this->name;
  }

  /**
   * @return TypeInterface
   */
  public function getType() {
    return $this->type;
  }
}