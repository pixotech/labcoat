<?php

namespace Labcoat\Patterns\Configuration;

class Configuration implements ConfigurationInterface {

  protected $config;

  public function __construct(array $config) {
    $this->config = $config;
  }

  public function getName() {
    return $this->hasName() ? $this->config['name'] : null;
  }

  public function getState() {
    return $this->hasState() ? $this->config['state'] : null;
  }

  public function getSubtype() {
    return $this->hasSubtype() ? $this->config['subtype'] : null;
  }

  public function getType() {
    return $this->hasType() ? $this->config['type'] : null;
  }

  public function hasName() {
    return !empty($this->config['name']);
  }

  public function hasState() {
    return !empty($this->config['state']);
  }

  public function hasSubtype() {
    return !empty($this->config['subtype']);
  }

  public function hasType() {
    return !empty($this->config['type']);
  }
}