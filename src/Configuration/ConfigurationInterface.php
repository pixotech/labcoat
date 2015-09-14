<?php

namespace Labcoat\Configuration;

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
  public function getPatternsDirectory();
  public function getStyleguideAssetDirectories();
  public function getStyleguideFooter();
  public function getStyleguideHeader();
  public function getStyleguideTemplatesDirectories();
  public function getTwigOptions();
  public function setAnnotationsFile($path);
  public function setIgnoredDirectories(array $directories);
  public function setIgnoredExtensions(array $extensions);
  public function setPatternsDirectory($path);
  public function setStyleguideFooter($path);
  public function setStyleguideHeader($path);
  public function setStyleguideTemplatesDirectory($path);
  public function setTwigOptions(array $options);
}