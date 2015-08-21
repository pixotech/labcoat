<?php

namespace Labcoat;

use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternCollectionInterface;

interface PatternLabInterface {
  public function getAssets();
  public function getConfiguration();
  public function getConfigurationFilePath();
  public function getConfigurationValue($key, $default = null);
  public function getFilterExtension();

  /**
   * @return \SplFileInfo[]
   */
  public function getFilterFiles();

  public function getFunctionExtension();

  /**
   * @return \SplFileInfo[]
   */
  public function getFunctionFiles();

  public function getLayoutFile($name);
  public function getMacroExtension();

  /**
   * @return \SplFileInfo[]
   */
  public function getMacroFiles();

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
  public function getTagExtension();

  /**
   * @return \SplFileInfo[]
   */
  public function getTagFiles();

  public function getTestExtension();

  /**
   * @return \SplFileInfo[]
   */
  public function getTestFiles();

  public function getTwigDefaultDateFormat();
  public function getTwigDefaultIntervalFormat();
  public function hasConfiguration();
  public function hasLayout($name);
  public function loadConfiguration();
}