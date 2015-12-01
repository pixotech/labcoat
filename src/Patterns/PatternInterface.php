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
   * @return string
   */
  public function getTemplate();

  /**
   * @return int
   */
  public function getTime();

  /**
   * @param ConfigurationInterface $configurationInterface
   */
  public function setConfiguration(ConfigurationInterface $configurationInterface);
}