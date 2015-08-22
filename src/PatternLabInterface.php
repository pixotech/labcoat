<?php

namespace Labcoat;

interface PatternLabInterface {

  /**
   * @return \Labcoat\Assets\AssetInterface[]
   */
  public function getAssets();

  public function copyAssetsTo($directoryPath);
  public function getIgnoredDirectories();
  public function getIgnoredExtensions();
  public function getLayout($name);

  /**
   * @param $name
   * @return \Labcoat\Patterns\Pattern
   */
  public function getPattern($name);
  public function getPatternExtension();
  public function getPatternsDirectory();
  public function hasLayout($name);
  public function makeDocument($patternName, $variables = null);
  public function render($patternName, $variables = null);
}