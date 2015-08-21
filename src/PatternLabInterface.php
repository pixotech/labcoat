<?php

namespace Labcoat;

use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternCollectionInterface;

interface PatternLabInterface {
  public function getAssets();
  public function getConfiguration();
  public function getConfigurationFilePath();
  public function getConfigurationValue($key, $default = null);
  public function getLayoutFile($name);

  /**
   * @param $name
   * @return Pattern
   */
  public function getPattern($name);

  public function getPatternExtension();

  /**
   * @return PatternCollectionInterface
   */
  public function getPatterns();
  public function getPatternsDirectoryPath();
  public function getPatternTypes();
  public function getSourceDirectoryPath();
  public function hasConfiguration();
  public function hasLayout($name);
  public function loadConfiguration();
}