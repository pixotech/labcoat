<?php

namespace Labcoat\Configuration;

interface ConfigurationInterface {
  public function get($key, $default = null);
  public function getIgnoredDirectories();
  public function getIgnoredExtensions();
  public function getPatternExtension();
  public function getSourceDirectory();
}