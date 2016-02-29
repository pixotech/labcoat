<?php

namespace Labcoat\PatternLab\Patterns;

interface PatternInterface {

  /**
   * @return string
   */
  public function getDescription();

  /**
   * @return string
   */
  public function getExample();

  /**
   * @return string
   */
  public function getLabel();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getState();

  /**
   * @return string
   */
  public function getSubtype();

  /**
   * @return string
   */
  public function getType();

  /**
   * @return bool
   */
  public function hasSubtype();

  /**
   * @param string $description
   */
  public function setDescription($description);

  /**
   * @param string $example
   */
  public function setExample($example);

  /**
   * @param string $label
   */
  public function setLabel($label);

  /**
   * @param string $name
   */
  public function setName($name);

  /**
   * @param string $state
   */
  public function setState($state);

  /**
   * @param string $subtype
   */
  public function setSubtype($subtype);

  /**
   * @param string $type
   */
  public function setType($type);
}