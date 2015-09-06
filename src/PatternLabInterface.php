<?php

namespace Labcoat;

interface PatternLabInterface extends HasItemsInterface {

  public function getAnnotationsFile();

  /**
   * @return \Labcoat\Assets\AssetInterface[]
   */
  public function getAssets();

  /**
   * @return array
   */
  public function getExposedOptions();

  /**
   * @return array
   */
  public function getGlobalData();

  /**
   * @return array
   */
  public function getHiddenControls();

  public function getIgnoredDirectories();
  public function getIgnoredExtensions();

  /**
   * @param $name
   * @return \Labcoat\Patterns\PatternInterface
   */
  public function getPattern($name);
  public function getPatternExtension();

  public function getPatternsDirectory();

  /**
   * @return \Labcoat\Patterns\PatternInterface[]
   */
  public function getPatterns();

  /**
   * @return string
   */
  public function getStyleguideAssetsDirectory();

  /**
   * @return string
   */
  public function getStyleguideFooter();

  /**
   * @return string
   */
  public function getStyleguideHeader();

  /**
   * @return string
   */
  public function getStyleguideTemplatesDirectory();

  /**
   * @return \Labcoat\Twig\Environment
   */
  public function getTwig();

  /**
   * @return \Labcoat\Sections\TypeInterface[]
   */
  public function getTypes();

  public function hasType($name);

  /**
   * @return bool
   */
  public function isHiddenFile($path);

  /**
   * @return bool
   */
  public function isIgnoredFile($path);

  public function makeDocument($patternName, $variables = null);
  public function render($patternName, $variables = null);
}