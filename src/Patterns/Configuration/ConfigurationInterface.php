<?php

namespace Labcoat\Patterns\Configuration;

interface ConfigurationInterface {
  public function getName();
  public function getState();
  public function getSubtype();
  public function getType();
  public function hasName();
  public function hasState();
  public function hasSubtype();
  public function hasType();
}