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
   * @return PatternInterface[]
   */
  public function getIncludedPatterns();

  /**
   * @return PatternInterface[]
   */
  public function getIncludingPatterns();

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
  public function getPartial();

  /**
   * @return string
   */
  public function getState();

  /**
   * @return string
   */
  public function getStyleguideDirectoryName();

  /**
   * @return string
   */
  public function getSubtype();

  /**
   * @return string
   */
  public function getTemplateContent();

  /**
   * @return string
   */
  public function getType();

  /**
   * @return bool
   */
  public function hasState();

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
   * @param string $content
   */
  public function setTemplateContent($content);

  /**
   * @param string $type
   */
  public function setType($type);
}