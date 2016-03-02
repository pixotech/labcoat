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

  public function getId() {
    return $this->type->getId() .'-' . $this->name;
  }

  public function getPartial() {
    $type = $this->type->getName();
    $name = $this->getName();
    return "viewall-{$type}-{$name}";
  }

  /**
   * @return TypeInterface
   */
  public function getType() {
    return $this->type;
  }
}