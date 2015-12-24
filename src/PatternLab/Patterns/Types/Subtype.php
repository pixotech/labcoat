<?php

namespace Labcoat\PatternLab\Patterns\Types;

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
  public function __construct(TypeInterface $type, $id, array $patterns = []) {
    parent::__construct($id, $patterns);
    $this->type = $type;
  }

  public function getId() {
    return implode('-', [$this->type->getId(), $this->id]);
  }

  public function getLabel() {
    // TODO: Implement getLabel() method.
  }

  public function getPagePath() {
    // TODO: Implement getPagePath() method.
  }

  public function getPartial() {
    return implode('-', [$this->type, $this->name]);
  }

  /**
   * @return TypeInterface
   */
  public function getType() {
    return $this->type;
  }
}