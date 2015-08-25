<?php

namespace Labcoat;

interface PatternLabInterface {

  /**
   * @return \Labcoat\Assets\AssetInterface[]
   */
  public function getAssets();

  public function copyAssetsTo($directoryPath);

  public function getDataDirectory();

  public function getDefaultDirectoryPermissions();

  /**
   * @return array
   */
  public function getExposedOptions();
  public function getIgnoredDirectories();
  public function getIgnoredExtensions();

  public function getMetaDirectory();

  /**
   * @param $name
   * @return \Labcoat\Patterns\Pattern
   */
  public function getPattern($name);
  public function getPatternExtension();

  /**
   * @return \Labcoat\Patterns\PatternCollection
   */
  public function getPatterns();

  public function getPatternsDirectory();

  /**
   * @return \Labcoat\Twig\Environment
   */
  public function getTwig();
  public function getVendorDirectory();
  public function makeDocument($patternName, $variables = null);
  public function render($patternName, $variables = null);
  public function setPatternsDirectory($path);
}