<?php

namespace Labcoat\Configuration;

interface ConfigurationInterface {
  public function get($key, $default = null);
  public function getIgnoredAssetDirectories();
  public function getIgnoredAssetExtensions();
  public function getPatternExtension();
  public function getSourceDirectory();
}