<?php

namespace Labcoat\Configuration;

use Labcoat\PatternLabInterface;

interface ConfigurationInterface {
  public function addAssetDirectory($path);
  public function addGlobalData($path);
  public function addListItems($path);
  public function addStyleguideAssetDirectory($path);
  public function getAnnotationsFile();
  public function getAssetDirectories();
  public function getExposedOptions();
  public function getGlobalDataFiles();
  public function getHiddenControls();
  public function getIgnoredDirectories();
  public function getIgnoredExtensions();
  public function getListItemFiles();
  public function getPatternExtension();
  public function getPatterns();
  public function getPatternsDirectory();

  /**
   * @param PatternLabInterface $patternlab
   * @return \Labcoat\PatternLab\Styleguide\StyleguideInterface
   */
  public function getStyleguide(PatternLabInterface $patternlab);

  public function getStyleguideAssetDirectories();
  public function getStyleguideFooter();
  public function getStyleguideHeader();
  public function getStyleguideTemplatesDirectories();
  public function getTwigOptions();
  public function hasStyleguideFooter();
  public function hasStyleguideHeader();
  public function setAnnotationsFile($path);
  public function setIgnoredDirectories(array $directories);
  public function setIgnoredExtensions(array $extensions);
  public function setPatternsDirectory($path);
  public function setStyleguideFooter($path);
  public function setStyleguideHeader($path);
  public function setStyleguideTemplatesDirectory($path);
  public function setTwigOptions(array $options);
}