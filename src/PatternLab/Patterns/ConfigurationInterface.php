<?php

namespace Labcoat\PatternLab\Patterns;

interface ConfigurationInterface {
  public function getDescription();
  public function getId();
  public function getLabel();
  public function getName();
  public function getState();
  public function getSubtype();
  public function getType();
  public function hasDescription();
  public function hasId();
  public function hasLabel();
  public function hasName();
  public function hasState();
  public function hasSubtype();
  public function hasType();
}