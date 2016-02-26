<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\Data\DataInterface;

interface PatternInterface {

  /**
   * @return DataInterface
   */
  public function getData();

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
  public function getFile();

  /**
   * @return string
   */
  public function getId();

  /**
   * @return array
   */
  public function getIncludedPatterns();

  /**
   * @return array
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
   * @return \Labcoat\PatternLab\Styleguide\Patterns\PathInterface
   */
  public function getPath();

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
  public function getTemplate();

  /**
   * @return int
   */
  public function getTime();

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
}