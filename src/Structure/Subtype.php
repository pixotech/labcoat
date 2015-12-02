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

  public function getId() {
    return implode('-', [$this->type->getId(), $this->name]);
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