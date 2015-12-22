<?php

namespace Labcoat\Mocks\Patterns\Configuration;

use Labcoat\Patterns\Configuration\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

  public $description;
  public $id;
  public $label;
  public $name;
  public $state;

  public function getName() {
    return $this->name;
  }

  public function getState() {
    return $this->state;
  }

  public function getSubtype() {
    // TODO: Implement getSubtype() method.
  }

  public function getType() {
    // TODO: Implement getType() method.
  }

  public function hasName() {
    return !empty($this->name);
  }

  public function hasState() {
    return !empty($this->state);
  }

  public function hasSubtype() {
    // TODO: Implement hasSubtype() method.
  }

  public function hasType() {
    // TODO: Implement hasType() method.
  }

  public function getDescription() {
    return $this->description;
  }

  public function hasDescription() {
    return !empty($this->description);
  }

  public function getLabel() {
    return $this->label;
  }

  public function hasLabel() {
    return !empty($this->label);
  }

  public function getId() {
    return $this->id;
  }

  public function hasId() {
    return !empty($this->id);
  }
}