<?php

namespace Labcoat\Patterns;

use Labcoat\Patterns\Configuration\ConfigurationInterface;

interface PatternInterface {

  /**
   * @return ConfigurationInterface
   */
  public function getConfiguration();

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
   * @return \Labcoat\Patterns\Paths\NameInterface
   */
  public function getName();

  /**
   * @return string
   */
  public function getPartial();

  /**
   * @return \Labcoat\Patterns\Paths\PathInterface
   */
  public function getPath();

  /**
   * @return PseudoPatternInterface[]
   */
  public function getPseudoPatterns();

  /**
   * @return string
   */
  public function getState();

  /**
   * @return \Labcoat\Patterns\Paths\SegmentInterface
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
   * @return \Labcoat\Patterns\Paths\SegmentInterface
   */
  public function getType();

  /**
   * @return bool
   */
  public function hasSubtype();

  /**
   * @return bool
   */
  public function hasType();

  /**
   * @param ConfigurationInterface $configurationInterface
   */
  public function setConfiguration(ConfigurationInterface $configurationInterface);
}