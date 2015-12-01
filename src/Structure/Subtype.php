<?php

namespace Labcoat\Structure;

class Subtype extends Folder implements SubtypeInterface {

  /**
   * @var TypeInterface
   */
  protected $type;

  /**
   * @param TypeInterface $type
   * @param string $name
   * @param array $patterns
   */
  public function __construct(TypeInterface $type, $name, array $patterns = []) {
    parent::__construct($name, $patterns);
    $this->type = $type;
  }

  /**
   * @return TypeInterface
   */
  public function getType() {
    return $this->type;
  }
}