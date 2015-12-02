<?php

namespace Labcoat\Styleguide\Navigation;

class TypeIndex extends TypeItem implements TypeIndexInterface, \JsonSerializable {

  /**
   * @var TypeInterface
   */
  protected $type;

  public function __construct(TypeInterface $type) {
    $this->type = $type;
  }

  public function getName() {
    return 'View All';
  }

  public function getSubtype() {
    return 'all';
  }

  public function getType() {
    return $this->type;
  }
}