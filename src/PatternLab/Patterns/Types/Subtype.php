<?php

namespace Labcoat\PatternLab\Patterns\Types;

use Labcoat\PatternLab\NameInterface;
use Labcoat\PatternLab\Patterns\PatternInterface;

class Subtype extends Type implements SubtypeInterface {

  /**
   * @var TypeInterface
   */
  protected $type;

  /**
   * @param TypeInterface $type
   * @param string $name
   * @param array $patterns
   */
  public function __construct(TypeInterface $type, NameInterface $name, array $patterns = []) {
    parent::__construct($name, $patterns);
    $this->type = $type;
  }
  /**
   * @param PatternInterface $pattern
   */
  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  public function getId() {
    return implode('-', [$this->type->getId(), $this->id]);
  }

  public function getPartial() {
    return 'viewall-' . implode('-', [$this->type, $this->name]);
  }

  /**
   * @return TypeInterface
   */
  public function getType() {
    return $this->type;
  }
}